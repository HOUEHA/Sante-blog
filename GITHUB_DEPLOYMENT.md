# 🚀 Déploiement avec GitHub

## Étape 1: Push sur GitHub
```bash
git add .
git commit -m "🚀 Ready for deployment"
git push origin main
```

## Étape 2: Déployer sur Vercel (Frontend)
1. Aller sur [vercel.com](https://vercel.com)
2. Importer votre repository GitHub
3. Configurer:
   - Framework: React
   - Build Command: `npm run build`
   - Output Directory: `dist`

## Étape 3: Déployer sur Render (Backend)
1. Aller sur [render.com](https://render.com)
2. Importer votre repository GitHub
3. Utiliser le fichier `render.yaml`
4. Configurer la base de données PostgreSQL

## Étape 4: Configuration finale
1. Mettre à jour les URLs dans le frontend
2. Configurer les variables d'environnement
3. Tester les API endpoints
4. Configurer le domaine personnalisé (optionnel)
