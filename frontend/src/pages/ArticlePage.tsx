import { useParams, Link } from 'react-router-dom';
import { useState, useEffect } from 'react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import { ArrowLeft, Clock, Calendar, User, Heart, MessageCircle, Share2 } from 'lucide-react';
import { apiService, type Article } from '../services/api';

const ArticlePage = () => {
  const { id } = useParams<{ id: string }>();
  const [article, setArticle] = useState<Article | null>(null);
  const [relatedArticles, setRelatedArticles] = useState<Article[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [likes, setLikes] = useState(0);
  const [isLiked, setIsLiked] = useState(false);
  const [showComments, setShowComments] = useState(false);
  const [comments, setComments] = useState<Array<{id: string, author: string, content: string, date: string}>>([]);
  const [newComment, setNewComment] = useState('');
  const [showShareMenu, setShowShareMenu] = useState(false);

  useEffect(() => {
    const fetchArticle = async () => {
      if (!id) return;

      try {
        setLoading(true);
        const [articleData, relatedData] = await Promise.all([
          apiService.getArticle(id),
          apiService.getRelatedArticles(id)
        ]);
        
        setArticle(articleData);
        setRelatedArticles(relatedData);
        
        // Initialize likes and comments (mock data for demo)
        setLikes(Math.floor(Math.random() * 50) + 10);
        setIsLiked(Math.random() > 0.5);
        setComments([
          {
            id: '1',
            author: 'Marie Dubois',
            content: 'Excellent article, très instructif!',
            date: '2026-02-15 14:30'
          },
          {
            id: '2',
            author: 'Jean Martin',
            content: 'Merci pour ces conseils pratiques.',
            date: '2026-02-15 16:45'
          }
        ]);
      } catch (err) {
        setError('Article non trouvé');
        console.error('Error fetching article:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchArticle();
  }, [id]);

  // Close share menu when clicking outside
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (showShareMenu && !(event.target as Element).closest('.relative')) {
        setShowShareMenu(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [showShareMenu]);

  const handleLike = () => {
    if (isLiked) {
      setLikes(likes - 1);
      setIsLiked(false);
    } else {
      setLikes(likes + 1);
      setIsLiked(true);
    }
  };

  const handleComment = (e: React.FormEvent) => {
    e.preventDefault();
    if (newComment.trim()) {
      const comment = {
        id: Date.now().toString(),
        author: 'Visiteur',
        content: newComment,
        date: new Date().toLocaleString('fr-FR')
      };
      setComments([comment, ...comments]);
      setNewComment('');
    }
  };

  const handleShare = (platform: string) => {
    const url = window.location.href;
    const text = article?.title || '';
    
    switch (platform) {
      case 'facebook':
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
        break;
      case 'twitter':
        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
        break;
      case 'linkedin':
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank');
        break;
      case 'copy':
        navigator.clipboard.writeText(url);
        alert('Lien copié dans le presse-papiers!');
        break;
    }
    setShowShareMenu(false);
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-white">
        <Header />
        <main className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="flex justify-center items-center h-64">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
          </div>
        </main>
        <Footer />
      </div>
    );
  }

  if (error || !article) {
    return (
      <div className="min-h-screen bg-white">
        <Header />
        <main className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center">
            <h1 className="text-2xl font-bold text-gray-900 mb-4">Article non trouvé</h1>
            <p className="text-gray-600 mb-6">L'article que vous recherchez n'existe pas.</p>
            <Link 
              to="/" 
              className="btn-primary"
            >
              Retour à l'accueil
            </Link>
          </div>
        </main>
        <Footer />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-white">
      <Header />
      
      <main className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Navigation retour */}
        <Link 
          to={`/${article.category?.slug || 'nutrition'}`} 
          className="inline-flex items-center text-gray-600 hover:text-primary-600 mb-8"
        >
          <ArrowLeft className="h-4 w-4 mr-2" />
          Retour à la rubrique {article.category?.name || 'Nutrition'}
        </Link>

        {/* En-tête de l'article */}
        <article className="prose prose-lg max-w-none">
          <header className="mb-8">
            <div className="flex items-center space-x-4 text-sm text-gray-500 mb-4">
              <span 
                className="px-3 py-1 rounded-full font-medium text-white"
                style={{ backgroundColor: article.category?.color || '#10b981' }}
              >
                {article.category?.name || 'Non catégorisé'}
              </span>
            </div>
            
            <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
              {article.title}
            </h1>
            
            <div className="flex flex-wrap items-center gap-4 text-gray-600 mb-6">
              <div className="flex items-center">
                <User className="h-4 w-4 mr-2" />
                <span>{article.author?.name || 'Anonyme'}</span>
              </div>
              <div className="flex items-center">
                <Calendar className="h-4 w-4 mr-2" />
                <span>{new Date(article.published_date).toLocaleDateString('fr-FR', { 
                  day: 'numeric', 
                  month: 'long', 
                  year: 'numeric' 
                })}</span>
              </div>
              <div className="flex items-center">
                <Clock className="h-4 w-4 mr-2" />
                <span>{article.read_time} min de lecture</span>
              </div>
            </div>

            {/* Image principale */}
            {article.featured_image_url && (
              <div className="relative h-64 md:h-96 rounded-xl overflow-hidden mb-8">
                <img
                  src={article.featured_image_url}
                  alt={article.title}
                  className="w-full h-full object-cover"
                  onError={(e) => {
                    console.error('Image failed to load:', article.featured_image_url);
                    e.currentTarget.src = 'https://via.placeholder.com/800x400?text=Image+non+disponible';
                  }}
                />
              </div>
            )}
          </header>

          {/* Contenu de l'article */}
          <div 
            className="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-strong:text-gray-900 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:text-gray-700 prose-blockquote:text-gray-600 prose-blockquote:border-l-primary-500 prose-code:text-primary-600 prose-pre:bg-gray-100 prose-hr:border-gray-200"
            dangerouslySetInnerHTML={{ __html: article.content }}
          />

          {/* Actions sociales */}
          <div className="flex items-center justify-between mt-8 pt-8 border-t">
            <div className="flex items-center space-x-4">
              <button 
                onClick={handleLike}
                className={`flex items-center transition-colors duration-200 ${
                  isLiked 
                    ? 'text-red-600 hover:text-red-700' 
                    : 'text-gray-600 hover:text-red-600'
                }`}
              >
                <Heart className={`h-5 w-5 mr-2 ${isLiked ? 'fill-current' : ''}`} />
                {likes} J'aime{likes > 1 ? 's' : ''}
              </button>
              <button 
                onClick={() => setShowComments(!showComments)}
                className="flex items-center text-gray-600 hover:text-blue-600"
              >
                <MessageCircle className="h-5 w-5 mr-2" />
                {comments.length} Commentaire{comments.length > 1 ? 's' : ''}
              </button>
            </div>
            <div className="relative">
              <button 
                onClick={() => setShowShareMenu(!showShareMenu)}
                className="flex items-center text-gray-600 hover:text-primary-600"
              >
                <Share2 className="h-5 w-5 mr-2" />
                Partager
              </button>
              
              {/* Share Menu */}
              {showShareMenu && (
                <div className="absolute right-0 top-12 bg-white border border-gray-200 rounded-lg shadow-lg p-2 z-10 min-w-48">
                  <button
                    onClick={() => handleShare('facebook')}
                    className="w-full text-left px-4 py-2 hover:bg-gray-100 rounded flex items-center"
                  >
                    <span className="w-4 h-4 bg-blue-600 rounded mr-3"></span>
                    Facebook
                  </button>
                  <button
                    onClick={() => handleShare('twitter')}
                    className="w-full text-left px-4 py-2 hover:bg-gray-100 rounded flex items-center"
                  >
                    <span className="w-4 h-4 bg-sky-500 rounded mr-3"></span>
                    Twitter
                  </button>
                  <button
                    onClick={() => handleShare('linkedin')}
                    className="w-full text-left px-4 py-2 hover:bg-gray-100 rounded flex items-center"
                  >
                    <span className="w-4 h-4 bg-blue-700 rounded mr-3"></span>
                    LinkedIn
                  </button>
                  <button
                    onClick={() => handleShare('copy')}
                    className="w-full text-left px-4 py-2 hover:bg-gray-100 rounded flex items-center"
                  >
                    <span className="w-4 h-4 bg-gray-600 rounded mr-3"></span>
                    Copier le lien
                  </button>
                </div>
              )}
            </div>
          </div>

          {/* Comments Section */}
          {showComments && (
            <div className="mt-8 border-t pt-8">
              <h3 className="text-xl font-bold text-gray-900 mb-6">Commentaires ({comments.length})</h3>
              
              {/* Comment Form */}
              <form onSubmit={handleComment} className="mb-8">
                <div className="flex gap-4">
                  <input
                    type="text"
                    value={newComment}
                    onChange={(e) => setNewComment((e.target as HTMLInputElement).value)}
                    placeholder="Ajoutez un commentaire..."
                    className="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                  />
                  <button
                    type="submit"
                    className="btn-primary"
                  >
                    Envoyer
                  </button>
                </div>
              </form>

              {/* Comments List */}
              <div className="space-y-4">
                {comments.map((comment) => (
                  <div key={comment.id} className="bg-gray-50 rounded-lg p-4">
                    <div className="flex items-center justify-between mb-2">
                      <span className="font-medium text-gray-900">{comment.author}</span>
                      <span className="text-sm text-gray-500">{comment.date}</span>
                    </div>
                    <p className="text-gray-700">{comment.content}</p>
                  </div>
                ))}
              </div>
            </div>
          )}
        </article>

        {/* Articles similaires */}
        {relatedArticles.length > 0 && (
          <section className="mt-16">
            <h2 className="text-2xl font-bold text-gray-900 mb-8">Articles similaires</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {relatedArticles.map((relatedArticle) => (
                <article key={relatedArticle.id} className="group cursor-pointer">
                  <div className="relative h-48 overflow-hidden rounded-lg mb-4">
                    <img
                      src={relatedArticle.featured_image_url || 'https://via.placeholder.com/400x300?text=Article'}
                      alt={relatedArticle.title}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                      onError={(e) => {
                        e.currentTarget.src = 'https://via.placeholder.com/400x300?text=Article';
                      }}
                    />
                    <div className="absolute top-4 left-4">
                      <span 
                        className="text-white px-3 py-1 rounded-full text-sm font-medium"
                        style={{ backgroundColor: relatedArticle.category?.color || '#10b981' }}
                      >
                        {relatedArticle.category?.name || 'Non catégorisé'}
                      </span>
                    </div>
                  </div>
                  <div className="p-4">
                    <div className="flex items-center text-sm text-gray-500 mb-2">
                      <span className="bg-primary-100 text-primary-800 px-2 py-1 rounded text-xs">
                        {relatedArticle.category?.name || 'Non catégorisé'}
                      </span>
                      <span className="mx-2">•</span>
                      <span>{relatedArticle.read_time} min</span>
                    </div>
                    <h3 className="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors duration-200">
                      <Link to={`/article/${relatedArticle.slug}`}>
                        {relatedArticle.title}
                      </Link>
                    </h3>
                  </div>
                </article>
              ))}
            </div>
          </section>
        )}
      </main>

      <Footer />
    </div>
  );
};

export default ArticlePage;
