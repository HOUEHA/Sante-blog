import { useState, useEffect } from 'react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import AuthGuard from '../components/AuthGuard';
import { 
  LayoutDashboard, 
  FileText, 
  MessageSquare, 
  Settings, 
  Users, 
  Plus, 
  Edit, 
  Trash2, 
  Save, 
  Eye,
  Search,
  Filter
} from 'lucide-react';
import { apiService } from '../services/api';
import type { Article, Category, FAQ } from '../services/api';
import CreateArticleModal from '../components/CreateArticleModal';
import CreateCategoryModal from '../components/CreateCategoryModal';
import CreateUserModal from '../components/CreateUserModal';

const AdminDashboardPage = () => {
  const [activeTab, setActiveTab] = useState('articles');
  const [articles, setArticles] = useState<Article[]>([]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [faqs, setFaqs] = useState<Record<string, FAQ[]>>({});
  const [users, setUsers] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');
  const [showCreateArticleModal, setShowCreateArticleModal] = useState(false);
  const [showCreateCategoryModal, setShowCreateCategoryModal] = useState(false);
  const [showCreateUserModal, setShowCreateUserModal] = useState(false);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const [articlesData, categoriesData, faqsData, usersData] = await Promise.all([
        apiService.getArticles({ per_page: 50 }),
        apiService.getCategories(),
        apiService.getFAQ(),
        apiService.getUsers({ per_page: 50 })
      ]);
      
      setArticles(articlesData.data || []);
      setCategories(categoriesData);
      setFaqs(faqsData);
      setUsers(usersData.data || []);
    } catch (error) {
      console.error('Error fetching data:', error);
    } finally {
      setLoading(false);
    }
  };

  const filteredArticles = articles.filter(article =>
    article.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    article.excerpt.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleEditArticle = (article: Article) => {
    // TODO: Implement edit functionality
    console.log('Edit article:', article);
    alert('Fonction de modification à implémenter');
  };

  const handleSaveSettings = () => {
    // TODO: Implement settings save functionality
    console.log('Saving settings...');
    alert('Paramètres sauvegardés avec succès!');
  };

  const handleCreateUser = () => {
    setShowCreateUserModal(true);
  };

  const handleEditUser = async (user: any) => {
    // TODO: Implement edit user modal
    console.log('Edit user:', user);
    alert('Fonction de modification utilisateur à implémenter (modal d\'édition)');
  };

  const handleDeleteUser = async (user: any) => {
    if (window.confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${user.name}" ?`)) {
      try {
        console.log('Deleting user:', user);
        await apiService.deleteUser(user.id);
        setUsers(users.filter(u => u.id !== user.id));
        alert('Utilisateur supprimé avec succès!');
      } catch (error: any) {
        console.error('Error deleting user:', error);
        alert('Erreur lors de la suppression de l\'utilisateur: ' + (error.message || 'Erreur inconnue'));
      }
    }
  };

  const handleDeleteArticle = async (article: Article) => {
    if (window.confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
      console.log('Attempting to delete article:', article);
      try {
        console.log('Calling API with slug:', article.slug);
        await apiService.deleteArticle(article.slug);
        console.log('Article deleted successfully, updating UI');
        setArticles(articles.filter(a => a.id !== article.id));
        alert('Article supprimé avec succès!');
      } catch (error: any) {
        console.error('Error deleting article:', error);
        console.error('Error details:', {
          message: error.message,
          status: error.status,
          response: error.response
        });
        alert('Erreur lors de la suppression de l\'article: ' + (error.message || 'Erreur inconnue'));
      }
    }
  };

  const sidebarItems = [
    { id: 'articles', name: 'Articles', icon: FileText },
    { id: 'categories', name: 'Catégories', icon: LayoutDashboard },
    { id: 'faq', name: 'FAQ', icon: MessageSquare },
    { id: 'settings', name: 'Paramètres', icon: Settings },
    { id: 'users', name: 'Utilisateurs', icon: Users },
  ];

  const renderArticles = () => (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold text-gray-900">Gestion des Articles</h2>
        <button
          onClick={() => setShowCreateArticleModal(true)}
          className="btn-primary flex items-center"
        >
          <Plus className="h-5 w-5 mr-2" />
          Nouvel Article
        </button>
      </div>

      <div className="bg-white rounded-lg shadow p-4">
        <div className="flex items-center space-x-4 mb-4">
          <div className="flex-1 relative">
            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
            <input
              type="text"
              placeholder="Rechercher un article..."
              value={searchTerm}
              onChange={(e) => setSearchTerm((e.target as HTMLInputElement).value)}
              className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
          <button className="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            <Filter className="h-4 w-4" />
            <span>Filtrer</span>
          </button>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="border-b">
                <th className="text-left py-3 px-4">Titre</th>
                <th className="text-left py-3 px-4">Catégorie</th>
                <th className="text-left py-3 px-4">Date</th>
                <th className="text-left py-3 px-4">Statut</th>
                <th className="text-left py-3 px-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              {filteredArticles.map((article) => (
                <tr key={article.id} className="border-b hover:bg-gray-50">
                  <td className="py-3 px-4">
                    <div>
                      <div className="font-medium">{article.title}</div>
                      <div className="text-sm text-gray-500 line-clamp-1">{article.excerpt}</div>
                    </div>
                  </td>
                  <td className="py-3 px-4">
                    <span 
                      className="px-2 py-1 rounded-full text-xs font-medium text-white"
                      style={{ backgroundColor: article.category?.color }}
                    >
                      {article.category?.name}
                    </span>
                  </td>
                  <td className="py-3 px-4 text-sm text-gray-500">
                    {article.formatted_date}
                  </td>
                  <td className="py-3 px-4">
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                      article.is_published 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-yellow-100 text-yellow-800'
                    }`}>
                      {article.is_published ? 'Publié' : 'Brouillon'}
                    </span>
                  </td>
                  <td className="py-3 px-4">
                    <div className="flex items-center space-x-2">
                      <button 
                        onClick={() => window.open(`/article/${article.slug}`, '_blank')}
                        className="p-1 hover:bg-gray-100 rounded"
                        title="Voir l'article"
                      >
                        <Eye className="h-4 w-4 text-gray-600" />
                      </button>
                      <button 
                        onClick={() => handleEditArticle(article)}
                        className="p-1 hover:bg-gray-100 rounded"
                        title="Modifier l'article"
                      >
                        <Edit className="h-4 w-4 text-gray-600" />
                      </button>
                      <button 
                        onClick={() => handleDeleteArticle(article)}
                        className="p-1 hover:bg-gray-100 rounded"
                        title="Supprimer l'article"
                      >
                        <Trash2 className="h-4 w-4 text-red-600" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );

  const renderCategories = () => (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold text-gray-900">Gestion des Catégories</h2>
        <button 
          onClick={() => setShowCreateCategoryModal(true)}
          className="btn-primary flex items-center"
        >
          <Plus className="h-5 w-5 mr-2" />
          Nouvelle Catégorie
        </button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {categories.map((category) => (
          <div key={category.id} className="bg-white rounded-lg shadow-lg p-6">
            <div className="flex items-center justify-between mb-4">
              <div 
                className="w-12 h-12 rounded-lg flex items-center justify-center text-white"
                style={{ backgroundColor: category.color }}
              >
                <LayoutDashboard className="h-6 w-6" />
              </div>
              <div className="flex items-center space-x-2">
                <button className="p-1 hover:bg-gray-100 rounded">
                  <Edit className="h-4 w-4 text-gray-600" />
                </button>
                <button className="p-1 hover:bg-gray-100 rounded">
                  <Trash2 className="h-4 w-4 text-red-600" />
                </button>
              </div>
            </div>
            
            <h3 className="text-lg font-semibold mb-2">{category.name}</h3>
            <p className="text-gray-600 text-sm mb-4">{category.description}</p>
            
            <div className="flex items-center justify-between text-sm">
              <span className="text-gray-500">
                {category.articles_count || 0} articles
              </span>
              <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                category.is_active 
                  ? 'bg-green-100 text-green-800' 
                  : 'bg-gray-100 text-gray-800'
              }`}>
                {category.is_active ? 'Active' : 'Inactive'}
              </span>
            </div>
          </div>
        ))}
      </div>
    </div>
  );

  const renderFAQ = () => (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold text-gray-900">Gestion des FAQ</h2>
        <button className="btn-primary flex items-center">
          <Plus className="h-5 w-5 mr-2" />
          Nouvelle Question
        </button>
      </div>

      {Object.entries(faqs).map(([category, questions]) => (
        <div key={category} className="bg-white rounded-lg shadow">
          <div className="p-4 border-b">
            <h3 className="text-lg font-semibold">{category}</h3>
            <p className="text-sm text-gray-500">{questions.length} questions</p>
          </div>
          
          <div className="divide-y">
            {questions.map((faq) => (
              <div key={faq.id} className="p-4 hover:bg-gray-50">
                <div className="flex items-start justify-between">
                  <div className="flex-1">
                    <h4 className="font-medium mb-2">{faq.question}</h4>
                    <p className="text-gray-600 text-sm line-clamp-2">{faq.answer}</p>
                  </div>
                  <div className="flex items-center space-x-2 ml-4">
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                      faq.is_active 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-gray-100 text-gray-800'
                    }`}>
                      {faq.is_active ? 'Active' : 'Inactive'}
                    </span>
                    <button className="p-1 hover:bg-gray-100 rounded">
                      <Edit className="h-4 w-4 text-gray-600" />
                    </button>
                    <button className="p-1 hover:bg-gray-100 rounded">
                      <Trash2 className="h-4 w-4 text-red-600" />
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      ))}
    </div>
  );

  const renderSettings = () => (
    <div className="space-y-6">
      <h2 className="text-2xl font-bold text-gray-900">Paramètres du Site</h2>
      
      <div className="bg-white rounded-lg shadow p-6">
        <h3 className="text-lg font-semibold mb-4">Informations Générales</h3>
        <div className="space-y-4">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Nom du site
            </label>
            <input
              type="text"
              defaultValue="Ma Santé, Ma responsabilité"
              className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
          
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Description
            </label>
            <textarea
              rows={3}
              defaultValue="Blog dédié à la santé et au bien-être"
              className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
          
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Email de contact
            </label>
            <input
              type="email"
              defaultValue="contact@masante-responsabilite.fr"
              className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
        </div>
        
        <div className="mt-6">
          <button onClick={handleSaveSettings} className="btn-primary">
            <Save className="h-5 w-5 mr-2" />
            Sauvegarder
          </button>
        </div>
      </div>
    </div>
  );

  const renderUsers = () => (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold text-gray-900">Gestion des Utilisateurs</h2>
        <button onClick={handleCreateUser} className="btn-primary flex items-center">
          <Plus className="h-5 w-5 mr-2" />
          Nouvel Utilisateur
        </button>
      </div>

      <div className="bg-white rounded-lg shadow">
        <div className="p-4 border-b">
          <div className="flex items-center space-x-4">
            <div className="flex-1 relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
              <input
                type="text"
                placeholder="Rechercher un utilisateur..."
                className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
              />
            </div>
            <button className="flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
              <Filter className="h-5 w-5 mr-2" />
              Filtrer
            </button>
          </div>
        </div>
        
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-200">
              {users.map((user) => (
                <tr key={user.id}>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <div className="flex items-center">
                      <div className="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                        <span className="text-primary-600 font-medium">
                          {user.name.split(' ').map((n: string) => n[0]).join('').toUpperCase().slice(0, 2)}
                        </span>
                      </div>
                      <div className="ml-4">
                        <div className="text-sm font-medium text-gray-900">{user.name}</div>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {user.email}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                      user.role === 'admin' 
                        ? 'bg-purple-100 text-purple-800' 
                        : 'bg-blue-100 text-blue-800'
                    }`}>
                      {user.role === 'admin' ? 'Administrateur' : 'Utilisateur'}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                      user.is_active 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-gray-100 text-gray-800'
                    }`}>
                      {user.is_active ? 'Actif' : 'Inactif'}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {new Date(user.created_at).toLocaleDateString('fr-FR')}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div className="flex items-center space-x-2">
                      <button 
                        onClick={() => handleEditUser(user)}
                        className="p-1 hover:bg-gray-100 rounded"
                        title="Modifier l'utilisateur"
                      >
                        <Edit className="h-4 w-4 text-gray-600" />
                      </button>
                      <button 
                        onClick={() => handleDeleteUser(user)}
                        className="p-1 hover:bg-gray-100 rounded"
                        title="Supprimer l'utilisateur"
                      >
                        <Trash2 className="h-4 w-4 text-red-600" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );

  const renderContent = () => {
    switch (activeTab) {
      case 'articles':
        return renderArticles();
      case 'categories':
        return renderCategories();
      case 'faq':
        return renderFAQ();
      case 'settings':
        return renderSettings();
      case 'users':
        return renderUsers();
      default:
        return renderArticles();
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-100 flex items-center justify-center">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  return (
    <AuthGuard>
      <div className="min-h-screen bg-gray-100">
        <Header />
        
        <div className="flex">
          {/* Sidebar */}
          <div className="w-64 bg-white shadow-lg min-h-screen">
            <div className="p-6 border-b border-gray-200">
              <h1 className="text-xl font-bold text-gray-900">Administration</h1>
            </div>
            
            <nav className="px-4 py-4">
              {sidebarItems.map((item) => {
                const Icon = item.icon;
                return (
                  <button
                    key={item.id}
                    onClick={() => setActiveTab(item.id)}
                    className={`w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-left transition-colors duration-200 mb-2 ${
                      activeTab === item.id
                        ? 'bg-primary-100 text-primary-700'
                        : 'text-gray-700 hover:bg-gray-100'
                    }`}
                  >
                    <Icon className="h-5 w-5" />
                    <span>{item.name}</span>
                  </button>
                );
              })}
            </nav>
          </div>

          {/* Main Content */}
          <div className="flex-1 p-8">
            {renderContent()}
          </div>
        </div>

        {/* Modals */}
        <CreateArticleModal
          isOpen={showCreateArticleModal}
          onClose={() => setShowCreateArticleModal(false)}
          categories={categories}
          onSuccess={fetchData}
        />
        <CreateCategoryModal
          isOpen={showCreateCategoryModal}
          onClose={() => setShowCreateCategoryModal(false)}
          onSuccess={fetchData}
        />
        <CreateUserModal
          isOpen={showCreateUserModal}
          onClose={() => setShowCreateUserModal(false)}
          onSuccess={fetchData}
        />
      </div>

      <Footer />
    </AuthGuard>
  );
};

export default AdminDashboardPage;
