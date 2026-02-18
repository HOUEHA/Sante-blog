# 📋 Plateforme Blog Santé - Documentation Complète

## 🏗️ Architecture Générale

### **Frontend (React + TypeScript)**
- **Framework**: React 18 + TypeScript
- **Styling**: Tailwind CSS
- **Routing**: React Router
- **Icons**: Lucide React
- **Build Tool**: Vite
- **Port**: 5173 (dev)

### **Backend (Laravel PHP)**
- **Framework**: Laravel 11
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **API**: RESTful (POST-only pour sécurité)
- **Port**: 8002 (dev)

---

## 🔐 Authentification

### **Login Admin**
- **Email**: `constant.houeha@gmail.com`
- **Password**: `password@123`
- **Token**: Stocké dans `localStorage` sous `admin_token`

### **Flow Authentification**
1. **POST** `/api/login` → Token JWT
2. **Token** stocké dans `localStorage`
3. **Headers**: `Authorization: Bearer {token}`
4. **Routes protégées**: `middleware('auth:sanctum')`

---

## 📊 Structure des Données

### **📄 Articles**
```sql
articles:
- id, title, slug, excerpt, content
- featured_image_url, category_id, author_id
- published_date, is_published, read_time
- created_at, updated_at
```

**Articles actuels**: 5 articles de test
- La méditation pour débutants
- Importance de l'hydratation
- Les bienfaits du yoga
- Alimentation équilibrée
- 5 exercices pour renforcer le dos

### **📂 Catégories (8)**
```sql
categories:
- id, name, slug, description, color, icon
- is_active, created_at, updated_at
```

**Liste complète**:
1. **Nutrition et Alimentation** 🥗 (#10B981)
2. **Prévention et Bien-être** 💙 (#3B82F6)
3. **Santé mentale** 💜 (#8B5CF6)
4. **Exercice et Fitness** ❤️ (#EF4444)
5. **Interview et témoignage** 🧡 (#F59E0B)
6. **Puériculture** 💗 (#EC4899)
7. **Maladies chroniques** 🩶 (#6B7280)
8. **Médecine naturelle** 💚 (#059669)

### **❓ FAQs (13)**
```sql
f_a_q_s:
- id, category, question, answer
- is_active, created_at, updated_at
```

**Distribution par catégorie**:
- Nutrition: 3 questions
- Prévention: 2 questions
- Santé mentale: 2 questions
- Exercice: 2 questions
- Puériculture: 2 questions
- Maladies chroniques: 1 question
- Médecine naturelle: 1 question

### **👥 Utilisateurs (3)**
```sql
users:
- id, name, email, password (hashed)
- role (user/admin), is_active
- remember_token, email_verified_at
- created_at, updated_at
```

**Utilisateurs**:
1. **Constant Houeha** (admin) - `constant.houeha@gmail.com`
2. Test User API (user) - `testapi@example.com`
3. Test User Auth (user) - `testauth@example.com`

### **📧 Newsletters (0)**
```sql
newsletters:
- id, email, subscribed_at
- created_at, updated_at
```

---

## 🛠️ API Endpoints

### **Authentication**
```http
POST /api/login          → Login + Token
POST /api/logout         → Logout (protégé)
```

### **Articles**
```http
POST /api/articles           → Lister articles
POST /api/articles/{slug}    → Voir article
POST /api/articles/recent    → Articles récents
POST /api/articles/{slug}/related → Articles similaires
POST /api/articles/{slug}/update  → Modifier (protégé)
POST /api/articles/{slug}/delete  → Supprimer (protégé)
```

### **Catégories**
```http
POST /api/categories         → Lister catégories
POST /api/categories/{slug}  → Voir catégorie
```

### **FAQs**
```http
POST /api/faq               → Lister FAQs
POST /api/faq/categories    → Catégories FAQ
```

### **Utilisateurs (protégé)**
```http
POST /api/users             → Lister utilisateurs
POST /api/users/create      → Créer utilisateur
POST /api/users/{id}        → Voir utilisateur
POST /api/users/{id}/update → Modifier utilisateur
POST /api/users/{id}/delete → Supprimer utilisateur
```

### **Newsletters**
```http
POST /api/newsletter/subscribe   → S'inscrire
POST /api/newsletter/unsubscribe → Se désinscrire
POST /api/newsletter/subscribers → Liste (protégé)
```

---

## 🎯 Fonctionnalités Frontend

### **Pages Publiques**
- **Accueil**: Articles récents
- **Articles**: Détail article avec likes/commentaires
- **À propos**: Newsletter + contact
- **Login**: Authentification admin

### **Dashboard Admin**
- **Articles**: CRUD complet (Voir/Modifier/Supprimer)
- **Catégories**: Gestion catégories
- **FAQs**: Gestion questions/réponses
- **Utilisateurs**: CRUD utilisateurs
- **Paramètres**: Configuration site

### **Composants**
- **Header**: Navigation + authentification
- **AuthGuard**: Protection routes admin
- **CreateArticleModal**: Création articles
- **CreateUserModal**: Création utilisateurs
- **CreateCategoryModal**: Création catégories

---

## 🔧 Configuration

### **Environment Variables**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=santeblog
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=http://localhost:5173
SESSION_DOMAIN=http://localhost:5173
```

### **Base de Données**
- **Nom**: `santeblog`
- **Tables**: articles, categories, f_a_q_s, users, newsletters
- **Migrations**: Laravel standard

---

## 🚀 Déploiement

### **Frontend**
```bash
cd frontend
npm install
npm run dev    # Dev (port 5173)
npm run build  # Production
```

### **Backend**
```bash
cd backend
composer install
php artisan migrate
php artisan serve --host=127.0.0.1 --port=8002
```

---

## 🐛 Debugging

### **Problèmes Connus**
1. **Login 500 Error**: Vérifier token Sanctum + CORS
2. **Articles vides**: Exécuter `php create_test_articles.php`
3. **Catégories manquantes**: Exécuter `php create_default_categories.php`
4. **FAQs vides**: Exécuter `php create_default_faqs.php`

### **Scripts de Test**
```bash
php check_data.php              # Vérifier données
php create_admin_user.php      # Créer admin
php test_user_api.php          # Tester API users
php test_frontend_user_creation.php # Test complet
```

---

## 📱 Interface Utilisateur

### **Dashboard Navigation**
- **Articles**: Tableau avec actions Voir/Modifier/Supprimer
- **Catégories**: Cartes avec couleurs et icônes
- **FAQs**: Groupées par catégorie
- **Utilisateurs**: Tableau avec rôles et statuts
- **Paramètres**: Formulaire configuration

### **Design System**
- **Colors**: Tailwind primary colors
- **Icons**: Lucide React
- **Typography**: Inter/Roboto
- **Responsive**: Mobile-first

---

## 🔒 Sécurité

### **Authentication**
- **Tokens**: Laravel Sanctum
- **Expiration**: Configurable
- **Routes**: Middleware `auth:sanctum`

### **Validation**
- **Input**: Laravel validation rules
- **Sanitization**: XSS protection
- **CSRF**: Laravel built-in

---

## 📈 Performance

### **Optimisations**
- **Lazy Loading**: Components React
- **Caching**: Laravel cache
- **Images**: Optimisées (WebP)
- **API**: Pagination

### **Monitoring**
- **Logs**: Laravel logs
- **Errors**: Frontend console
- **Performance**: DevTools

---

## 🔄 Mises à Jour

### **Version Actuelle**: v1.0.0
- ✅ Authentification complète
- ✅ CRUD Articles/Catégories/FAQs/Utilisateurs
- ✅ Newsletter système
- ✅ Dashboard admin
- ✅ Design responsive

### **Roadmap**
- 🔄 Éditeur de texte riche
- 🔄 Système de commentaires
- 🔄 Recherche avancée
- 🔄 Analytics dashboard

---

## 📞 Support

### **Contact**
- **Admin**: constant.houeha@gmail.com
- **Documentation**: Ce fichier
- **Issues**: Console logs + Laravel logs

### **Dépannage Rapide**
1. **Vider cache**: `php artisan cache:clear`
2. **Migrate**: `php artisan migrate:fresh --seed`
3. **Frontend**: `npm run dev` (reload)
4. **Backend**: Redémarrer serveur

---

*Documentation générée le 17 février 2026 - Platforme Blog Santé v1.0.0*
