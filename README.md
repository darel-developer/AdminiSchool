

# 📚 AdminiSchool

**AdminiSchool** est une plateforme interactive de gestion scolaire qui permet une meilleure communication entre l’administration scolaire et les parents d’élèves. Ce projet vise à moderniser les échanges entre les établissements scolaires et les familles en centralisant les informations clés telles que les devoirs, les signatures, les absences, les notifications et les bulletins.

---

## ✨ Fonctionnalités principales

- 📖 Gestion du cahier de texte (enseignants et élèves)
- 🧑‍🏫 Espace dédié aux enseignants pour gérer les devoirs, les matières et les niveaux
- 🧑‍🎓 Accès parent avec suivi des devoirs et notifications
- 📝 Système de signature (image, scan, reconnaissance faciale)
- 📊 Tableau de bord interactif
- 🔔 Système de notification SMS via l’API Infobip
- 🗂️ Gestion des utilisateurs (admin, enseignants, parents)

---

## 🚀 Comment faire fonctionner le projet

### ⚙️ Prérequis

- PHP >= 8.1
- Composer
- Laravel 10+
- MySQL / MariaDB
- Node.js + npm
- Clé API Infobip (pour l'envoi de SMS)

### 🔧 Installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/votre-utilisateur/adminischool.git
cd adminischool
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Copier le fichier `.env`**

```bash
cp .env.example .env
```

4. **Configurer la base de données et l'API Infobip dans `.env`**

```
DB_DATABASE=adminischool
DB_USERNAME=root
DB_PASSWORD=

INFOBIP_API_KEY=votre_clé_api
INFOBIP_BASE_URL=https://xxxxx.api.infobip.com
INFOBIP_SENDER_ID=AdminiSchool
```

5. **Générer la clé d'application**

```bash
php artisan key:generate
```

6. **Lancer les migrations**

```bash
php artisan migrate
```

7. **Installer les dépendances front-end (si nécessaire)**

```bash
npm install && npm run dev
```

8. **Démarrer le serveur**

```bash
php artisan serve
```

---

## 🧱 Structure du projet

```
adminischool/
├── app/                    # Contrôleurs, modèles et logiques métier
├── database/               # Migrations et seeders
├── public/                 # Fichiers publics accessibles (CSS, JS compilés, etc.)
├── resources/
│   ├── views/              # Vues Blade (frontend Laravel)
│   └── js/ & css/          # Fichiers JS et CSS (si Vue.js ou autres frameworks)
├── routes/
│   └── web.php             # Routes de l'application
├── config/                 # Fichiers de configuration
├── .env                    # Variables d'environnement
```

---

## 💡 À venir

- Intégration d’une version mobile (Flutter)
- Gestion des emplois du temps
- Système de messagerie interne
- Génération de bulletins PDF

