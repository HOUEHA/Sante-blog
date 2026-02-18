import { useParams } from 'react-router-dom';
import { useState, useEffect } from 'react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import { apiService } from '../services/api';
import type { Category, Article } from '../services/api';

const CategoryPage = () => {
  const { category } = useParams();
  const [categoryData, setCategoryData] = useState<Category | null>(null);
  const [articles, setArticles] = useState<Article[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchData = async () => {
      if (!category) return;
      
      try {
        const [categoryResponse, articlesResponse] = await Promise.all([
          apiService.getCategory(category),
          apiService.getArticles({ category, per_page: 12 })
        ]);
        
        setCategoryData(categoryResponse);
        setArticles(articlesResponse.data);
      } catch (err) {
        console.error('Error fetching category data:', err);
        setError('Catégorie non trouvée');
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [category]);

  if (loading) {
    return (
      <div className="min-h-screen bg-white">
        <Header />
        <main>
          <div className="flex justify-center items-center py-16">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
          </div>
        </main>
        <Footer />
      </div>
    );
  }

  if (error || !categoryData) {
    return (
      <div className="min-h-screen bg-white">
        <Header />
        <main>
          <div className="text-center py-16">
            <h1 className="text-2xl font-bold text-gray-900 mb-4">
              Catégorie non trouvée
            </h1>
            <p className="text-gray-600 mb-8">
              Désolé, cette catégorie n'existe pas ou a été supprimée.
            </p>
            <a href="/" className="btn-primary">
              Retour à l'accueil
            </a>
          </div>
        </main>
        <Footer />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-white">
      <Header />
      
      <main>
        {/* Header de catégorie */}
        <div style={{ backgroundColor: categoryData.color }} className="text-white py-16">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center">
              <h1 className="text-4xl md:text-5xl font-bold mb-6">
                {categoryData.name}
              </h1>
              <p className="text-xl max-w-3xl mx-auto opacity-90">
                {categoryData.description}
              </p>
            </div>
          </div>
        </div>

        {/* Filtres et tri */}
        <div className="bg-gray-50 border-b">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div className="flex flex-col sm:flex-row justify-between items-center gap-4">
              <div className="flex items-center space-x-4">
                <span className="text-gray-600">Trier par:</span>
                <select className="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                  <option>Date de publication</option>
                  <option>Plus lus</option>
                  <option>Titre alphabétique</option>
                </select>
              </div>
              <div className="text-gray-600">
                {articles.length} articles trouvés
              </div>
            </div>
          </div>
        </div>

        {/* Liste des articles */}
        <section className="py-12">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {articles.length === 0 ? (
              <div className="text-center py-16">
                <p className="text-gray-600">
                  Aucun article trouvé dans cette catégorie pour le moment.
                </p>
              </div>
            ) : (
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {articles.map((article) => (
                  <article key={article.id} className="card group cursor-pointer">
                    <div className="relative h-48 overflow-hidden">
                      <img
                        src={article.featured_image_url}
                        alt={article.title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                      />
                    </div>
                    
                    <div className="p-6">
                      <div className="flex items-center text-sm text-gray-500 mb-3">
                        <span>{article.formatted_date}</span>
                        <span className="mx-2">•</span>
                        <span>{article.reading_time}</span>
                      </div>
                      
                      <h3 className="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-200">
                        {article.title}
                      </h3>
                      
                      <p className="text-gray-600 mb-4 line-clamp-3">
                        {article.excerpt}
                      </p>
                      
                      <div className="flex items-center justify-between">
                        <span className="text-sm text-gray-500">
                          Par {article.author?.name}
                        </span>
                        <a
                          href={`/article/${article.slug}`}
                          className="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium"
                        >
                          Lire la suite →
                        </a>
                      </div>
                    </div>
                  </article>
                ))}
              </div>
            )}

            {/* Pagination */}
            <div className="flex justify-center mt-12">
              <nav className="flex items-center space-x-2">
                <button className="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>
                  Précédent
                </button>
                <button className="px-3 py-2 bg-primary-600 text-white rounded-lg">1</button>
                <button className="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button className="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                <button className="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Suivant</button>
              </nav>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  );
};

export default CategoryPage;
