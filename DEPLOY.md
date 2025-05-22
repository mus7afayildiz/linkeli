Déploiement – Linkeli

Ce projet utilise "GitHub Actions" pour effectuer un déploiement automatique à chaque "push" sur la branche `main`.
Clonage du repo        
Compilation assets frontend  
Deploiement via SSH          
Execution des commandes Laravel

name: Deploy to Server

Le deploiement s’active automatiquement quand un commit est poussé sur :
on:
  push:
    branches:
      - main

jobs:
  deploy:
    runs-on: ubuntu-latest

Récupération du dépôt
    steps:
      - name: Checkout Repository
        uses: actions/checkout@v4

Clône le code source du projet à partir du repository GitHub.
Installation de sshpass (connexion SSH automatisée)
      - name: Install sshpass
        run: sudo apt-get install -y sshpass

Nettoyage des dependances existantes
      - name: Clean node_modules and package-lock.json
        run: |
          rm -rf node_modules
          rm package-lock.json

Réinstallation des dépendances frontend
      - name: Install dependencies
        run: npm install

 Compilation des fichiers frontend 
      - name: Build project
        run: npm run build

Synchronisation du projet vers le serveur
      - name: Sync project to server
        run: sshpass -p "${{ secrets.LINKELI_DEPLOY }}" rsync -avz 

Synchronise le contenu du projet via "`rsync` avec SSH" vers le répertoire web du serveur distant.        
            -e "ssh -p 222 -o StrictHostKeyChecking=no" 
            --exclude "node_modules"
            --exclude "storage"
            --exclude ".git"  
            --exclude ".env" 
            ./ 

Dossier cible            
            pm2etml-jmy-tpi24-linkeli-w3@jmy-tpi24-linkeli.w3.pm2etml.ch:htdocs/jmy-tpi24-linkeli.w3.pm2etml.ch

Commandes Laravel exécutées à distance            
      - name: Run Laravel commands
        run: sshpass -p "${{ secrets.LINKELI_DEPLOY }}" ssh -o StrictHostKeyChecking=no -p 222 pm2etml-jmy-tpi24-linkeli-w3@jmy-tpi24-linkeli.w3.pm2etml.ch '
            cd htdocs/jmy-tpi24-linkeli.w3.pm2etml.ch &&
            
Commandes exécutées après synchronisation :      
 Installe les dépendances PHP en production
 Vide tous les caches Laravel
 Applique les migrations de la base de données      
            composer install --no-dev --optimize-autoloader &&
            php artisan optimize:clear &&
            php artisan migrate --force
          '

Sécurité:
Le mot de passe SSH est stocké de manière sécurisée dans "GitHub Secrets"


Prérequis sur le serveur distant
PHP ≥ 8.1
Composer
Serveur Node.js pour `npm run build`
Accès SSH (port 222)
Serveur Web (Nginx configuré)

