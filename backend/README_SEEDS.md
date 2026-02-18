# 🌱 Database Seeds Documentation

## 📋 Overview

Ce dossier contient tous les **seeds** Laravel pour remplir la base de données du Blog Santé avec des données de test complètes et réalistes.

## 🎯 Seeds Disponibles

### **1. UserSeeder** 👥
- **Admin**: Constant Houeha (constant.houeha@gmail.com)
- **Test Users**: Marie Dupont, Jean Martin, Sophie Laurent
- **Rôles**: admin, user
- **Statuts**: actif/inactif
- **Mots de passe**: `password@123` (admin), `password123` (users)

### **2. CategorySeeder** 📂
- **8 catégories** complètes avec couleurs et icônes
- **Nutrition et Alimentation** 🥗 (#10B981)
- **Prévention et Bien-être** 💙 (#3B82F6)
- **Santé mentale** 💜 (#8B5CF6)
- **Exercice et Fitness** ❤️ (#EF4444)
- **Interview et témoignage** 🧡 (#F59E0B)
- **Puériculture** 💗 (#EC4899)
- **Maladies chroniques** 🩶 (#6B7280)
- **Médecine naturelle** 💚 (#059669)

### **3. ArticleSeeder** 📄
- **8 articles** complets avec contenu HTML
- **Images**: Unsplash pour chaque article
- **Catégories**: Distribution équilibrée
- **Temps de lecture**: 5-10 minutes
- **Contenu riche**: Articles détaillés et informatifs

### **4. FAQSeeder** ❓
- **13 questions** réparties par catégorie
- **Réponses détaillées**: Informations pratiques
- **Catégories**: Alignées avec les catégories d'articles
- **Statuts**: Toutes actives

## 🚀 Utilisation

### **Exécuter tous les seeds:**
```bash
php artisan db:seed
```

### **Exécuter un seed spécifique:**
```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=FAQSeeder
```

### **Recharger la base de données complète:**
```bash
php artisan migrate:fresh --seed
```

## 📊 Données Générées

### **Résumé après exécution:**
- **Utilisateurs**: 4 (1 admin + 3 test)
- **Catégories**: 8 (toutes actives)
- **Articles**: 8 (contenu HTML complet)
- **FAQs**: 13 (questions utiles)

### **Login Admin:**
- **Email**: `constant.houeha@gmail.com`
- **Password**: `password@123`

## 🔧 Configuration

### **DatabaseSeeder principal:**
```php
$this->call([
    UserSeeder::class,
    CategorySeeder::class,
    ArticleSeeder::class,
    FAQSeeder::class,
]);
```

### **UpdateOrCreate:**
Tous les seeds utilisent `updateOrCreate()` pour éviter les doublons et permettre les ré-exécutions.

## 🎨 Caractéristiques

### **Articles:**
- **Titres**: Accrocheurs et informatifs
- **Extraits**: Résumés percutants
- **Contenu**: HTML structuré avec H2, H3, listes
- **Images**: URLs Unsplash optimisées
- **SEO**: Slugs URL-friendly

### **Catégories:**
- **Couleurs**: Palette cohérente Tailwind
- **Icônes**: Noms d'icônes Lucide
- **Descriptions**: Textes informatifs
- **Tri**: Ordre logique

### **FAQs:**
- **Questions**: Problématiques réelles
- **Réponses**: Conseils pratiques
- **Catégories**: Alignées thématiquement
- **Ordre**: Priorité logique

## 🔄 Maintenance

### **Ajouter de nouvelles données:**
1. Modifier le seeder approprié
2. Ajouter les nouvelles entrées
3. Ré-exécuter: `php artisan db:seed --class=NomSeeder`

### **Réinitialiser les données:**
```bash
php artisan migrate:fresh --seed
```

### **Mettre à jour les données existantes:**
Les seeds utilisent `updateOrCreate()` donc les modifications seront appliquées lors de la prochaine exécution.

## 📝 Notes

- **Images**: URLs Unsplash (nécessitent internet pour l'affichage)
- **Mots de passe**: Hashés automatiquement
- **Dates**: Utilisent `Carbon::now()` pour cohérence
- **Relations**: Articles liés aux catégories par ID
- **HTML**: Contenu valide et sécurisé

---

*Documentation des seeds - Blog Santé v1.0.0*
