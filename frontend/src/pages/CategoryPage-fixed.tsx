// CategoryPage.tsx - Version Corrigée

import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { ChevronRight, Calendar, Clock, User } from 'lucide-react';
import { apiService, Article, Category } from '../services/api-fixed';

const CategoryPage: React.FC = () => {
  const { categorySlug } = useParams<{ categorySlug: string }>();
  const [articles, setArticles] = useState<Article[]>([]);
  const [category, setCategory] = useState<Category | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  // Mapping des slugs corrects
  const getCategorySlug = (slug: string): string => {
    const mapping: { [key: string]: string } = {
      'alimentation': 'nutrition-alimentation',
      'prevention': 'prevention-bien-etre',
      'interview-et-temoignage': 'interview-temoignage'
    };
    return mapping[slug] || slug;
  };

  const mappedSlug = getCategorySlug(categorySlug || '');

  useEffect(() => {
    const fetchCategoryData = async () => {
      try {
        setLoading(true);
        setError(null);

        // Récupérer les informations de la catégorie
        const categoryData = await apiService.getCategory(mappedSlug);
        setCategory(categoryData);

        // Récupérer les articles de cette catégorie
        const articlesData = await apiService.getArticlesByCategory(mappedSlug);
        
        // Filtrer uniquement les articles publiés
        const publishedArticles = articlesData.filter(article => article.is_published);
        setArticles(publishedArticles);
        
      } catch (err) {
        console.error('Error fetching category data:', err);
        setError('Impossible de charger les articles de cette catégorie');
      } finally {
        setLoading(false);
      }
    };

    fetchCategoryData();
  }, [mappedSlug]);

  if (loading) {
    return (
      <div className="min-h-screen bg-white flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Chargement des articles...</p>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="min-h-screen bg-white flex items-center justify-center">
        <div className="text-center">
          <div className="text-red-600 text-xl mb-4">❌</div>
          <p className="text-gray-600">{error}</p>
          <Link 
            to="/" 
            className="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700"
          >
            Retour à l'accueil
          </Link>
        </div>
      </div>
    );
  }

  if (!category) {
    return (
      <div className="min-h-screen bg-white flex items-center justify-center">
        <div className="text-center">
          <div className="text-red-600 text-xl mb-4">❌</div>
          <p className="text-gray-600">Catégorie non trouvée</p>
          <Link 
            to="/" 
            className="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700"
          >
            Retour à l'accueil
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-white">
      {/* Header */}
      <header className="bg-white shadow-sm sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center">
              <Link to="/" className="text-2xl font-bold text-gray-900">
                🏥 Blog Santé
              </Link>
            </div>
            <nav className="hidden md:flex space-x-8">
              <Link
                to="/nutrition"
                className="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium"
              >
                Alimentation
              </Link>
              <Link
                to="/prevention"
                className="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium"
              >
                Prévention
              </Link>
              <Link
                to="/interviews"
                className="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium"
              >
                Interviews
              </Link>
            </nav>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <div className="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h1 className="text-4xl md:text-5xl font-bold mb-6">
              {category.name}
            </h1>
            <p className="text-xl max-w-3xl mx-auto opacity-90">
              {category.description}
            </p>
            <div className="mt-8 flex justify-center space-x-4">
              <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                <Calendar className="h-4 w-4 mr-1" />
                {articles.length} articles
              </span>
            </div>
          </div>
        </div>
      </div>

      {/* Articles Grid */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {articles.length === 0 ? (
          <div className="text-center py-12">
            <div className="text-gray-500 text-xl mb-4">
              Aucun article publié dans cette catégorie pour le moment.
            </div>
            <p className="text-gray-400">
              Revenez bientôt pour découvrir de nouveaux contenus !
            </p>
          </div>
        ) : (
          <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            {articles.map((article) => (
              <article 
                key={article.id} 
                className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
              >
                <Link to={`/article/${article.slug}`} className="block">
                  {article.featured_image_url && (
                    <div className="h-48 bg-gray-200">
                      <img
                        src={article.featured_image_url}
                        alt={article.title}
                        className="w-full h-full object-cover"
                      />
                    </div>
                  )}
                  <div className="p-6">
                    <div className="flex items-center text-sm text-gray-500 mb-2">
                      <Calendar className="h-4 w-4 mr-1" />
                      {new Date(article.published_date).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                      })}
                    </div>
                    <h3 className="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                      {article.title}
                    </h3>
                    <p className="text-gray-600 mb-4 line-clamp-3">
                      {article.excerpt}
                    </p>
                    <div className="flex items-center justify-between">
                      <div className="flex items-center text-sm text-gray-500">
                        <Clock className="h-4 w-4 mr-1" />
                        {article.read_time} min de lecture
                      </div>
                      <div className="flex items-center text-sm text-gray-500">
                        <User className="h-4 w-4 mr-1" />
                        {article.author?.name || 'Anonyme'}
                      </div>
                    </div>
                  </div>
                </Link>
              </article>
            ))}
          </div>
        )}
      </div>

      {/* Footer */}
      <footer className="bg-gray-50">
        <div className="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <p className="text-gray-400">
              &copy; 2026 Blog Santé. Tous droits réservés.
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default CategoryPage;
