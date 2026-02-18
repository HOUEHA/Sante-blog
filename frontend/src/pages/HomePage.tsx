import { useState, useEffect } from 'react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import HeroSection from '../components/HeroSection';
import { apiService } from '../services/api';
import type { Article, Category } from '../services/api';

const HomePage = () => {
  const [recentArticles, setRecentArticles] = useState<Article[]>([]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const [articlesData, categoriesData] = await Promise.all([
          apiService.getRecentArticles(),
          apiService.getCategories()
        ]);
        
        setRecentArticles(articlesData);
        setCategories(categoriesData);
      } catch (error) {
        console.error('Error fetching data:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  if (loading) {
    return (
      <div className="min-h-screen bg-white">
        <Header />
        <main>
          <HeroSection />
          <div className="flex justify-center items-center py-16">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
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
        <HeroSection />

        {/* Derniers Articles */}
        <section className="py-16 bg-gray-50">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Derniers Articles
              </h2>
              <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                Découvrez nos derniers conseils et informations pour une vie plus saine
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {recentArticles.map((article) => (
                <article key={article.id} className="card group cursor-pointer">
                  <div className="relative h-48 overflow-hidden">
                    <img
                      src={article.featured_image_url}
                      alt={article.title}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                    <div className="absolute top-4 left-4">
                      <span 
                        className="text-white px-3 py-1 rounded-full text-sm font-medium"
                        style={{ backgroundColor: article.category?.color || '#10b981' }}
                      >
                        {article.category?.name}
                      </span>
                    </div>
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
                    
                    <a
                      href={`/article/${article.slug}`}
                      className="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium"
                    >
                      Lire la suite →
                    </a>
                  </div>
                </article>
              ))}
            </div>

            <div className="text-center mt-12">
              {recentArticles.length > 0 && (
                <a
                  href={`/article/${recentArticles[0].slug}`}
                  className="btn-primary inline-flex items-center"
                >
                  Lire le dernier article
                </a>
              )}
            </div>
          </div>
        </section>

        {/* Rubriques Populaires */}
        <section className="py-16 bg-white">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Rubriques Populaires
              </h2>
              <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                Explorez nos différentes thématiques pour trouver les informations qui vous intéressent
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {categories.map((category) => (
                <a
                  key={category.id}
                  href={`/${category.slug}`}
                  className="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300"
                >
                  <div 
                    className="h-32 opacity-90 group-hover:opacity-100 transition-opacity duration-300"
                    style={{ backgroundColor: category.color }}
                  ></div>
                  <div className="absolute inset-0 flex items-center justify-center p-6">
                    <h3 className="text-white text-xl font-bold text-center group-hover:scale-105 transition-transform duration-300">
                      {category.name}
                    </h3>
                  </div>
                </a>
              ))}
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  );
};

export default HomePage;
