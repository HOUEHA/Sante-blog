#!/bin/bash

echo "🚀 Déploiement Blog Santé sur serveurs gratuits..."

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}📋 Préparation du déploiement...${NC}"

# Check if we're in the right directory
if [ ! -d "backend" ] || [ ! -d "frontend" ]; then
    echo -e "${RED}❌ Erreur: Vous devez être dans le répertoire racine du projet${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Structure du projet vérifiée${NC}"

# Backend preparation
echo -e "${YELLOW}📦 Préparation du backend...${NC}"
cd backend

# Install composer dependencies
echo "Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader

# Install and build frontend assets
echo "Build des assets du backend..."
npm install
npm run build

# Clear caches
echo "Nettoyage des caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Set production environment
echo "Configuration de l'environnement de production..."
cp .env.example .env.production
echo "⚠️  N'oubliez pas de configurer vos variables d'environnement dans .env.production"

cd ..
echo -e "${GREEN}✅ Backend prêt${NC}"

# Frontend preparation
echo -e "${YELLOW}📦 Préparation du frontend...${NC}"
cd frontend

# Install dependencies
echo "Installation des dépendances Node..."
npm install

# Build for production
echo "Build de production..."
npm run build

cd ..
echo -e "${GREEN}✅ Frontend prêt${NC}"

# Create deployment files
echo -e "${YELLOW}📝 Création des fichiers de configuration...${NC}"

# Vercel configuration
cat > frontend/vercel.json << EOF
{
  "buildCommand": "npm run build",
  "outputDirectory": "dist",
  "installCommand": "npm install",
  "framework": "vite",
  "rewrites": [
    {
      "source": "/(.*)",
      "destination": "/index.html"
    }
  ]
}
EOF

# Render configuration
cat > backend/render.yaml << EOF
services:
  - type: web
    name: blog-sante-api
    env: php
    buildCommand: "composer install --no-dev && npm install && npm run build"
    startCommand: "php artisan serve --host=0.0.0.0 --port=\$PORT"
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: APP_KEY
        generateValue: true
      - key: DB_CONNECTION
        value: pgsql
databases:
  - name: blog-sante-db
    databaseName: blog_sante
    user: blog_sante_user
EOF

# Dockerfile (alternative)
cat > Dockerfile << EOF
FROM php:8.2-fpm

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY backend/ .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage \
    && chmod -R 755 /app/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EOF

# .env.production template
cat > backend/.env.production.template << EOF
APP_NAME="Blog Santé"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-backend.onrender.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host.render.com
DB_PORT=5432
DB_DATABASE=blog_sante
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# CORS settings
SANCTUM_STATEFUL_DOMAINS=https://your-frontend.vercel.app

# Mail settings (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@blog-sante.com"
MAIL_FROM_NAME="\${APP_NAME}"
EOF

echo -e "${GREEN}✅ Fichiers de configuration créés${NC}"

# Create GitHub deployment guide
cat > GITHUB_DEPLOYMENT.md << EOF
# 🚀 Déploiement avec GitHub

## Étape 1: Push sur GitHub
\`\`\`bash
git add .
git commit -m "🚀 Ready for deployment"
git push origin main
\`\`\`

## Étape 2: Déployer sur Vercel (Frontend)
1. Aller sur [vercel.com](https://vercel.com)
2. Importer votre repository GitHub
3. Configurer:
   - Framework: React
   - Build Command: \`npm run build\`
   - Output Directory: \`dist\`

## Étape 3: Déployer sur Render (Backend)
1. Aller sur [render.com](https://render.com)
2. Importer votre repository GitHub
3. Utiliser le fichier \`render.yaml\`
4. Configurer la base de données PostgreSQL

## Étape 4: Configuration finale
1. Mettre à jour les URLs dans le frontend
2. Configurer les variables d'environnement
3. Tester les API endpoints
4. Configurer le domaine personnalisé (optionnel)
EOF

echo -e "${GREEN}✅ Guide GitHub créé${NC}"

# Summary
echo -e "${YELLOW}📊 Résumé du déploiement:${NC}"
echo ""
echo "📁 Fichiers créés:"
echo "  - frontend/vercel.json (Configuration Vercel)"
echo "  - backend/render.yaml (Configuration Render)"
echo "  - Dockerfile (Alternative déploiement)"
echo "  - backend/.env.production.template (Template environnement)"
echo "  - GITHUB_DEPLOYMENT.md (Guide étape par étape)"
echo ""
echo -e "${GREEN}🎉 Projet prêt pour le déploiement!${NC}"
echo ""
echo -e "${YELLOW}📖 Prochaines étapes:${NC}"
echo "1. Lire le fichier DEPLOYMENT_GUIDE.md"
echo "2. Suivre le guide GITHUB_DEPLOYMENT.md"
echo "3. Configurer les variables d'environnement"
echo "4. Déployer sur Vercel et Render"
echo ""
echo -e "${GREEN}🌐 Votre Blog Santé sera bientôt en ligne!${NC}"
