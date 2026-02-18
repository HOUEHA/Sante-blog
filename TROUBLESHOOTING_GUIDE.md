# 🔧 Guide de Dépannage - Blog Santé

## 🎯 **Problèmes Identifiés et Solutions**

### **1. ❌ Erreur lors de la création de l'article**

#### **Diagnostic:**
- ✅ **Backend API**: Fonctionne (test PHP réussi)
- ✅ **Base de données**: Accepte les articles (26 articles au total)
- ❌ **Frontend**: Erreur lors de la création

#### **Causes Possibles:**

##### **A. Problème d'Authentification**
```bash
# Test d'authentification
php test_frontend_article_creation.php
```

##### **B. Problème de Format de Données**
Le frontend envoie des données incorrectes:
```typescript
// Dans CreateArticleModal.tsx
const articleData = {
    title: formData.title,
    excerpt: formData.excerpt,
    content: formData.content,
    category_id: parseInt(formData.category_id), // ⚠️ Doit être un nombre
    author_id: 1,
    published_date: new Date().toISOString(), // ⚠️ Format incorrect
    is_published: true,
    read_time: parseInt(formData.read_time.toString()) // ⚠️ Conversion inutile
};
```

##### **C. Route API Incorrecte**
Vérifier la route dans `api.ts`:
```typescript
async createArticle(articleData: any): Promise<Article> {
    return this.request<Article>('/articles/create', { // ⚠️ Vérifier cette route
        method: 'POST',
        body: JSON.stringify(articleData),
    });
}
```

---

### **2. ❌ Erreur lors de la création de la catégorie**

#### **Diagnostic:**
- ✅ **Backend API**: Fonctionne (test PHP réussi)
- ✅ **Base de données**: Accepte les catégories (9 catégories au total)
- ❌ **Frontend**: "Erreur lors de la création de la catégorie"

#### **Causes Possibles:**

##### **A. Middleware d'Authentification**
Les routes catégories sont protégées:
```php
// Dans routes/api.php
Route::middleware('simple.auth')->group(function () {
    Route::post('/categories/create', [CategoryController::class, 'store']);
});
```

##### **B. Token Frontend Invalide**
Vérifier le token dans localStorage:
```javascript
// Dans le navigateur
console.log('Token:', localStorage.getItem('admin_token'));
```

---

### **3. ❌ Pages Alimentation/Prévention/Interview vides**

#### **Diagnostic:**
- ✅ **Backend**: Articles existent (13, 3, 4 articles)
- ✅ **API Routes**: Fonctionnelles (HTTP 200)
- ❌ **Frontend**: Pages vides

#### **Causes Possibles:**

##### **A. Mauvais Slug de Catégorie**
Le frontend utilise les mauvais slugs:
```typescript
// Dans CategoryPage.tsx
const { categorySlug } = useParams<{ categorySlug: string }>();

// Slugs corrects:
nutrition-alimentation     // ✅
prevention-bien-etre      // ✅  
interview-temoignage      // ✅

// Slugs incorrects:
alimentation              // ❌
prevention               // ❌
interview-et-temoignage   // ❌
```

##### **B. Route API Incorrecte**
Vérifier l'appel API:
```typescript
// Dans api.ts
async getArticlesByCategory(categorySlug: string): Promise<Article[]> {
    return this.request<Article[]>(`/articles/category/${categorySlug}`); // ⚠️ Route incorrecte
}
```

---

## 🛠️ **Scripts de Diagnostic**

### **1. Test Complet du Frontend**
```bash
cd backend
php test_frontend_complete.php
```

### **2. Vérification des Routes**
```bash
php artisan route:list | grep -E "(articles|categories|faq)"
```

### **3. Test d'Authentification**
```bash
php test_auth_flow.php
```

---

## 🔧 **Solutions Immédiates**

### **Solution 1: Corriger les Slugs**
```typescript
// Dans CategoryPage.tsx
const categoryMapping: { [key: string]: string } = {
    'alimentation': 'nutrition-alimentation',
    'prevention': 'prevention-bien-etre', 
    'interview-et-temoignage': 'interview-temoignage'
};

const mappedSlug = categoryMapping[categorySlug] || categorySlug;
```

### **Solution 2: Corriger le Format de Données**
```typescript
// Dans CreateArticleModal.tsx
const articleData = {
    title: formData.title,
    excerpt: formData.excerpt,
    content: formData.content,
    category_id: parseInt(formData.category_id),
    author_id: 1,
    published_date: new Date().toISOString().split('T')[0], // Format YYYY-MM-DD
    is_published: true,
    read_time: parseInt(formData.read_time)
};
```

### **Solution 3: Vérifier les Routes API**
```typescript
// Dans api.ts
async getArticlesByCategory(categorySlug: string): Promise<Article[]> {
    // Utiliser la route correcte
    return this.request<Article[]>(`/articles?category_slug=${categorySlug}`);
}
```

---

## 📋 **Checklist de Dépannage**

### **Étape 1: Vérifier le Backend**
- [ ] Serveur Laravel démarré (`php artisan serve`)
- [ ] Base de données accessible (`php artisan tinker`)
- [ ] Routes fonctionnelles (`php artisan route:list`)

### **Étape 2: Vérifier le Frontend**
- [ ] Token d'authentification présent
- [ ] Appels API corrects
- [ ] Slugs de catégories valides

### **Étape 3: Tester les Fonctionnalités**
- [ ] Création d'article
- [ ] Création de catégorie
- [ ] Affichage des pages de catégorie

---

## 🚀 **Actions Correctives**

### **1. Corriger CreateArticleModal.tsx**
```typescript
// Format correct des données
const articleData = {
    ...formData,
    category_id: parseInt(formData.category_id),
    author_id: 1,
    published_date: new Date().toISOString().split('T')[0],
    is_published: true,
    read_time: parseInt(formData.read_time)
};
```

### **2. Corriger CategoryPage.tsx**
```typescript
// Mapping des slugs corrects
const getCategorySlug = (slug: string) => {
    const mapping = {
        'alimentation': 'nutrition-alimentation',
        'prevention': 'prevention-bien-etre',
        'interview-et-temoignage': 'interview-temoignage'
    };
    return mapping[slug] || slug;
};
```

### **3. Corriger api.ts**
```typescript
// Routes correctes
async getArticlesByCategory(categorySlug: string): Promise<Article[]> {
    return this.request<Article[]>(`/articles?category_slug=${categorySlug}`);
}
```

---

## 📊 **Tests de Validation**

### **Test 1: Article Creation**
```bash
php test_article_creation_debug.php
```

### **Test 2: Category Creation**  
```bash
php test_category_creation_debug.php
```

### **Test 3: Page Display**
```bash
php test_page_display.php
```

---

## 🎯 **Objectif Final**

Après avoir appliqué ces corrections:
- ✅ **Création d'article**: Fonctionnelle
- ✅ **Création de catégorie**: Fonctionnelle  
- ✅ **Pages de catégorie**: Affichent le contenu
- ✅ **Dashboard admin**: Complètement opérationnel

---

**🔧 Appliquez ces corrections pour un fonctionnement optimal !**
