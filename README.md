# To-Do List Backend - Laravel 12

Backend de l'application To-Do List développée avec Laravel 12, authentification JWT, et notifications temps réel via Pusher WebSockets.

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- MySQL 8.0 ou supérieur

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone <votre-repo-url>
cd todo-list-backend
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Installer les packages supplémentaires

```bash
# JWT Authentication
composer require tymon/jwt-auth

# Pusher pour WebSockets
composer require pusher/pusher-php-server
```

### 4. Configuration de l'environnement

Copier le fichier d'environnement :

```bash
cp .env.example .env
```

Générer la clé d'application :

```bash
php artisan key:generate
```

### 5. Configuration de la base de données MySQL

Mettre à jour le fichier `.env` avec vos informations MySQL :

```env
# Base de données MySQL
APP_NAME="Todo List API"
APP_ENV=local
APP_KEY=base64:your_generated_key
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_list
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### 6. Configuration JWT

Publier la configuration JWT :

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

Mettre à jour `config/auth.php` :

```php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

### 7. Configuration Pusher

Ajouter vos credentials Pusher dans `.env` :

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster

# Pour le frontend
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 8. Créer la base de données MySQL

Connectez-vous à MySQL et créez la base de données :

```sql
mysql -u root -p
CREATE DATABASE todo_list CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 9. Exécuter les migrations

Créer les tables de la base de données :

```bash
php artisan migrate
```

### 10. Configuration du stockage

Créer le lien symbolique pour les fichiers uploadés :

```bash
php artisan storage:link

# Créer le dossier pour les images utilisateurs
mkdir -p storage/app/public/user_images
chmod -R 775 storage/app/public/user_images
```

## 🖥️ Démarrage du projet

### Serveur PHP intégré

```bash
php artisan serve
```

L'API sera accessible sur `http://localhost:8000`

### Démarrage des workers pour les notifications

```bash
# Pour les événements en temps réel
php artisan queue:work
```

## 📡 Endpoints API

### Authentification

```
POST /api/auth/register    - Inscription utilisateur
POST /api/auth/login       - Connexion utilisateur
POST /api/auth/logout      - Déconnexion (avec token)
POST /api/auth/refresh     - Renouveler le token
GET  /api/auth/profile     - Profil utilisateur (avec token)
```

### Gestion des tâches (nécessite authentification)

```
GET    /api/tasks          - Liste des tâches de l'utilisateur
GET    /api/tasks/{id}     - Détail d'une tâche
POST   /api/tasks          - Créer une nouvelle tâche
PUT    /api/tasks/{id}     - Modifier une tâche
DELETE /api/tasks/{id}     - Supprimer une tâche
```

### Fichiers utilisateurs

```
GET /api/user_images/{filename} - Récupérer une image utilisateur
```