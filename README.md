
# 📁 DIRM - Gestion des Formulaires

![PHP](https://img.shields.io/badge/PHP-8.3.16-blue?logo=php)
![Symfony](https://img.shields.io/badge/Symfony-7.0-black?logo=symfony)
![MySQL](https://img.shields.io/badge/SQL-MySQL-4479A1?logo=mysql)
![MongoDB](https://img.shields.io/badge/NoSQL-MongoDB-47A248?logo=mongodb)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.4.1-06B6D4?logo=tailwindcss)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?logo=docker)
![License](https://img.shields.io/badge/License-MIT-green)
![Tests](https://github.com/Meriem1403/DIRM/actions/workflows/tests.yml/badge.svg)

Application Symfony développée pour la Direction Interrégionale de la Mer Méditerranée (DIRM Med), permettant de gérer 3 types de demandes administratives :
- Formulaires de mobilité des agents
- Accès aux outils métier
- Déclarations de mise en chantier

---

## 📋 Fonctionnalités principales

- 🧾 Questionnaire dynamique multi-étapes
- 👥 Authentification sécurisée avec rôles (Agent, Chef de service, Admin)
- ✅ Validation des demandes avec statut, historique et signature
- 📎 Gestion de pièces jointes
- 📊 Page d’indicateurs administratifs
- ✉️ Notifications email (Mailpit)
- 🐳 Environnement Dockerisé

---

## ⚙️ Stack Technique

| Technologie | Version      |
|-------------|--------------|
| Symfony     | 7.3.x        |
| PHP         | 8.3.16 (Laragon) |
| MySQL       | 9.1 (Docker) |
| Mailpit     | Dernière     |
| Docker      | Compose v2   |
| Tailwind CSS| Intégré via Encore |
| Stimulus.js | Pour interactions dynamiques |

---

## 🚀 Installation locale

### 1. Cloner le projet

```bash
git clone https://github.com/Meriem1403/DIRM.git
cd DIRM
```

### 2. Installer les dépendances PHP et JS

```bash
composer install
yarn install && yarn dev
```

### 3. Configurer l’environnement

Créer un fichier `.env.local` avec vos identifiants :
```dotenv
DATABASE_URL="mysql://root:<your_db_password>@127.0.0.1:3307/dirm?serverVersion=9.1"
MAILER_DSN=smtp://localhost:1026
APP_ENV=dev
APP_DEBUG=1
APP_SECRET=your_secret_here
```

---

## 🐳 Lancer avec Docker

```bash
docker compose -f compose.yaml up -d
```

- 📂 phpMyAdmin → [http://localhost:8081](http://localhost:8081)
- ✉️ Mailpit → [http://localhost:8026](http://localhost:8026)

---

## 🧱 Générer la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

---

## 🔐 Rôles utilisateurs

- `ROLE_AGENT` : renseigne ses formulaires
- `ROLE_CHEF_SERVICE` : validation
- `ROLE_ADMIN` : supervise tout et gère les droits

---

## 🧪 Tester

Lancer les tests automatiques :

```bash
php bin/phpunit
```

---

## 📂 Structure du projet

```
├── src/
│   ├── Entity/
│   ├── Controller/
│   ├── Form/
│   ├── Repository/
│   └── Service/
├── templates/
├── public/
├── migrations/
├── docker/
├── compose.yaml
```

---

## 🙌 Crédits

Ce projet a été réalisé dans le cadre d’une certification Studi pour la DIRM Méditerranée.  
Développé par Meriem Zahzouh, Licence CDA 2025.
