import Dexie from 'dexie';

const db = new Dexie('OfflineStorage');
db.version(1).stores({
    pendingActions: '++id, url, method, body, headers, createdAt',
    cachedData: '++id, key, value, timestamp'
});

export const OfflineDB = {
    async saveAction(request) {
        return db.pendingActions.add({
            url: request.url,
            method: request.method,
            body: request.body,
            headers: Object.fromEntries(request.headers.entries()),
            createdAt: new Date()
        });
    },

    async getPendingActions() {
        return db.pendingActions.toArray();
    },

    async removePendingAction(id) {
        return db.pendingActions.delete(id);
    },

    async cacheData(key, value) {
        return db.cachedData.put({
            key,
            value,
            timestamp: Date.now()
        });
    },

    async getCachedData(key) {
        const result = await db.cachedData.get({ key });
        return result?.value;
    },

    async clearExpiredData(maxAge = 86400000) { // 24h par défaut
        const threshold = Date.now() - maxAge;
        return db.cachedData
            .where('timestamp')
            .below(threshold)
            .delete();
    }
};