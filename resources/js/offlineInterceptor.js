import axios from 'axios';
import { OfflineDB } from './offlineDB';

axios.interceptors.request.use(async (config) => {
    // Vérifie si on est hors ligne
    if (!navigator.onLine && config.url.startsWith('/api/')) {
        const cachedData = await OfflineDB.getCachedData(config.url);
        if (cachedData) {
            config.adapter = () => Promise.resolve({
                data: cachedData,
                status: 200,
                config
            });
        }
    }
    return config;
});

axios.interceptors.response.use(null, async (error) => {
    if (!navigator.onLine && error.config) {
        // Sauvegarde les actions pour sync ultérieure
        await OfflineDB.saveAction({
            url: error.config.url,
            method: error.config.method,
            body: JSON.stringify(error.config.data),
            headers: error.config.headers
        });

        // Pour les requêtes POST/PUT, retourne un succès simulé
        if (['post', 'put'].includes(error.config.method.toLowerCase())) {
            return Promise.resolve({
                data: { 
                    status: 'offline',
                    message: 'Action will be synced when online' 
                },
                status: 202
            });
        }
    }
    return Promise.reject(error);
});

// Synchronisation automatique
window.addEventListener('online', async () => {
    const actions = await OfflineDB.getPendingActions();
    if (actions.length > 0) {
        await Promise.all(actions.map(async (action) => {
            try {
                await axios({
                    url: action.url,
                    method: action.method,
                    data: action.body,
                    headers: action.headers
                });
                await OfflineDB.removePendingAction(action.id);
            } catch (err) {
                console.error('Sync error:', err);
            }
        }));
    }
});