# 🚀 Guide de Déploiement - Blog Santé

## 📋 Options de Déploiement Gratuit

### 1. **Vercel** (Recommandé pour Frontend)
- **Frontend React**: ✅ Parfait
- **Backend API**: ❌ Non compatible PHP
- **Coût**: Gratuit
- **Domain**: Custom domain possible

### 2. **Netlify** (Alternative Frontend)
- **Frontend React**: ✅ Parfait
- **Backend API**: ❌ Non compatible PHP
- **Coût**: Gratuit
- **Domain**: Custom domain possible

### 3. **Render** (Recommandé pour Backend)
- **Backend Laravel**: ✅ Compatible PHP
- **Database**: PostgreSQL gratuit
- **Coût**: Gratuit (limites)
- **Domain**: Custom domain possible

### 4. **Heroku** (Alternative Backend)
- **Backend Laravel**: ✅ Compatible PHP
- **Database**: PostgreSQL gratuit
- **Coût**: Gratuit (limites)
- **Domain**: Custom domain possible

### 5. **Railway** (Backend + Database)
- **Backend Laravel**: ✅ Compatible PHP
- **Database**: PostgreSQL inclus
- **Coût**: Gratuit ($5/mois crédit)
- **Domain**: Custom domain possible

---

## 🎯 **Solution Recommandée: Split Architecture**

### **Frontend**: Vercel
### **Backend**: Render ou Railway

---

## 📝 Étapes de Déploiement

### **Étape 1: Préparation du Backend**

#### **1.1. Configuration environnement**
```bash
# Créer .env.production
cp .env .env.production
```

#### **1.2. Variables d'environnement**
```env
APP_NAME=BlogSante
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY
APP_DEBUG=false
APP_URL=https://your-backend.onrender.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=blog_sante
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

#### **1.3. Database Setup**
```bash
# Migration PostgreSQL
php artisan migrate --force
php artisan db:seed --force
```

#### **1.4. Build Assets**
```bash
npm install
npm run build
```

---

### **Étape 2: Déploiement Backend sur Render**

#### **2.1. Créer compte Render**
- Aller sur [render.com](https://render.com)
- Créer compte GitHub connecté

#### **2.2. Nouveau Web Service**
- Repository: Votre repo GitHub
- Runtime: PHP
- Build Command: `composer install && npm install && npm run build`
- Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

#### **2.3. Database PostgreSQL**
- Ajouter PostgreSQL Database
- Copier les credentials dans .env

---

### **Étape 3: Préparation Frontend**

#### **3.1. Configuration API URL**
```typescript
// frontend/src/services/api.ts
const API_BASE_URL = 'https://your-backend.onrender.com/api';
```

#### **3.2. Build Production**
```bash
cd frontend
npm install
npm run build
```

#### **3.3. Vercel Configuration**
```json
// frontend/vercel.json
{
  "buildCommand": "npm run build",
  "outputDirectory": "dist",
  "installCommand": "npm install"
}
```

---

### **Étape 4: Déploiement Frontend sur Vercel**

#### **4.1. Créer compte Vercel**
- Aller sur [vercel.com](https://vercel.com)
- Importer votre projet GitHub

#### **4.2. Configuration**
- Framework: React
- Build Command: `npm run build`
- Output Directory: `dist`

#### **4.3. Environment Variables**
- Ajouter `VITE_API_URL` si nécessaire

---

## 🔧 **Configuration CORS**

### **Backend CORS Setup**
```php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://your-frontend.vercel.app',
        'http://localhost:3000'
    ],
    'allowed_headers' => ['*'],
];
```

---

## 📊 **Coûts et Limites**

### **Vercel (Frontend)**
- ✅ Gratuit: 100GB bandwidth/mois
- ✅ 1000 builds/mois
- ✅ Custom domain

### **Render (Backend)**
- ✅ Gratuit: 750h/mois
- ✅ 512MB RAM
- ✅ PostgreSQL gratuit (10k rows)
- ⚠️ Sleep après 15min inactivité

### **Railway (Alternative)**
- ✅ $5/mois crédit
- ✅ Pas de sleep
- ✅ Database inclus

---

## 🚀 **Déploiement Rapide**

### **Option 1: Script Automatisé**
```bash
# deploy.sh
#!/bin/bash

echo "🚀 Déploiement Blog Santé..."

# Backend
echo "📦 Build backend..."
cd backend
composer install --no-dev
npm install && npm run build

# Frontend
echo "📦 Build frontend..."
cd ../frontend
npm install && npm run build

echo "✅ Prêt pour déploiement!"
```

### **Option 2: Docker (Alternative)**
```dockerfile
# Dockerfile
FROM php:8.2-fpm

WORKDIR /app

# Install dependencies
COPY backend/ .
RUN composer install --no-dev

# Install Node and build
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN npm install && npm run build

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
```

---

## 🌐 **Domaines Personnalisés**

### **Configuration DNS**
```
A Record: @ -> Vercel IP
CNAME: api -> your-backend.onrender.com
```

### **SSL Certificates**
- ✅ Automatique sur Vercel
- ✅ Automatique sur Render

---

## 🔍 **Monitoring**

### **Logs et Erreurs**
- **Vercel**: Logs temps réel
- **Render**: Logs et métriques
- **Database**: Monitoring PostgreSQL

### **Performance**
- **Frontend**: Vercel Analytics
- **Backend**: Render metrics
- **CDN**: Automatique

---

## 📝 **Checklist Déploiement**

- [ ] GitHub repo prêt
- [ ] Variables d'environnement configurées
- [ ] Database migrée et seedée
- [ ] CORS configuré
- [ ] Frontend buildé
- [ ] Backend testé localement
- [ ] Domaines configurés
- [ ] HTTPS activé
- [ ] Monitoring en place

---

## 🆘 **Support**

### **Dépannage**
1. **CORS Errors**: Vérifier origins autorisées
2. **Database Connection**: Tester credentials
3. **Build Errors**: Vérifier versions Node/PHP
4. **API 404**: Vérifier routes et middleware

### **Contact Support**
- **Vercel**: support@vercel.com
- **Render**: support@render.com
- **Community**: Discord/Forums

---

**🎉 Votre Blog Santé sera en ligne gratuitement!**
