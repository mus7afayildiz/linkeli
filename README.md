# 📎 Linkeli – Raccourcisseur d’URL sécurisé

Linkeli est une application web permettant de raccourcir des liens, de les protéger avec un mot de passe et de générer des QR codes pour un partage simplifié. Développée dans le cadre du TPI à l'ETML.

## 🔧 Fonctionnalités

- 🔗 Création de liens courts personnalisés
- 🔐 Protection des liens par mot de passe
- 📈 Suivi du nombre de clics (compteur)
- 🕒 Expiration automatique configurable
- 📷 Génération de QR code (format SVG)
- ✉️ Vérification d’email avec token (Mailtrap)
- 🎨 Interface simple et moderne (Laravel Blade + Tailwind)

## 🛠️ Technologies

- **Back-end** : PHP 8.1, Laravel 12
- **Base de données** : MariaDB
- **Front-end** : HTML, Tailwind CSS, JavaScript
- **Outils** : Git, GitHub Actions, Mailtrap, HeidiSQL

## 🚀 Installation locale

```bash
git clone https://github.com/ton-utilisateur/linkeli.git
cd linkeli
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan serve
