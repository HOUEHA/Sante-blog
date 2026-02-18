#!/bin/bash

echo "🚀 Migration Blog Santé vers repositories séparés..."

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# Check if we're in the right directory
if [ ! -d "backend" ] || [ ! -d "frontend" ]; then
    echo -e "${RED}❌ Erreur: Vous devez être dans le répertoire racine du projet${NC}"
    exit 1
fi

echo -e "${YELLOW}📦 Création du repository Backend...${NC}"

# Backend Repository
if [ ! -d "sante-blog-backend" ]; then
    mkdir sante-blog-backend
    cp -r backend/* sante-blog-backend/
    
    # Create backend-specific files
    cat > sante-blog-backend/render.yaml << EOF
services:
  - type: web
    name: sante-blog-backend
    runtime: php
    plan: free
    buildCommand: |
      composer install --no-dev --optimize-autoloader && \
      npm install && \
      npm run build
    startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: APP_KEY
        generateValue: true
      - key: DB_CONNECTION
        value: pgsql
    healthCheckPath: /api/health

databases:
  - name: sante-blog-db
    databaseName: blog_sante
    user: blog_sante_user
    plan: free
EOF

    # Initialize git
    cd sante-blog-backend
    git init
    git add .
    git commit -m "🚀 Backend Santé Blog - Laravel API"
    
    echo -e "${GREEN}✅ Backend repository créé${NC}"
    echo "📝 Commandes pour le backend:"
    echo "   cd sante-blog-backend"
    echo "   git remote add origin git@github.com:HOUEHA/sante-blog-backend.git"
    echo "   git push -u origin main"
    echo ""
    
    cd ..
else
    echo -e "${YELLOW}⚠️  Le répertoire sante-blog-backend existe déjà${NC}"
fi

echo -e "${YELLOW}📦 Création du repository Frontend...${NC}"

# Frontend Repository
if [ ! -d "sante-blog-frontend" ]; then
    mkdir sante-blog-frontend
    cp -r frontend/* sante-blog-frontend/
    
    # Create frontend-specific files
    cat > sante-blog-frontend/vercel.json << EOF
{
  "version": 2,
  "buildCommand": "npm install && npm run build",
  "outputDirectory": "dist",
  "framework": "vite",
  "routes": [
    {
      "src": "/(.*)",
      "dest": "/index.html"
    }
  ],
  "env": {
    "VITE_API_URL": "https://sante-blog-backend.onrender.com/api"
  }
}
EOF

    # Create .gitignore for frontend
    cat > sante-blog-frontend/.gitignore << EOF
node_modules
dist
.env
.env.local
.env.production
.DS_Store
*.log
EOF

    # Initialize git
    cd sante-blog-frontend
    git init
    git add .
    git commit -m "🚀 Frontend Santé Blog - React App"
    
    echo -e "${GREEN}✅ Frontend repository créé${NC}"
    echo "📝 Commandes pour le frontend:"
    echo "   cd sante-blog-frontend"
    echo "   git remote add origin git@github.com:HOUEHA/sante-blog-frontend.git"
    echo "   git push -u origin main"
    echo ""
    
    cd ..
else
    echo -e "${YELLOW}⚠️  Le répertoire sante-blog-frontend existe déjà${NC}"
fi

echo -e "${GREEN}🎉 Migration terminée!${NC}"
echo ""
echo -e "${YELLOW}📋 Prochaines étapes:${NC}"
echo "1. Créer les repositories sur GitHub:"
echo "   - HOUEHA/sante-blog-backend"
echo "   - HOUEHA/sante-blog-frontend"
echo ""
echo "2. Pusher les repositories:"
echo "   cd sante-blog-backend && git push -u origin main"
echo "   cd ../sante-blog-frontend && git push -u origin main"
echo ""
echo "3. Déployer:"
echo "   - Frontend: Vercel (sante-blog-frontend)"
echo "   - Backend: Render (sante-blog-backend)"
echo ""
echo "4. Configurer les URLs:"
echo "   - Backend: https://sante-blog-backend.onrender.com/api"
echo "   - Frontend: https://sante-blog-frontend.vercel.app"
echo ""
echo -e "${GREEN}🌐 Votre Blog Santé sera prêt pour le déploiement séparé!${NC}"
