import { useState } from 'react';
import { X, Save, Eye, Upload, Image as ImageIcon } from 'lucide-react';
import { apiService } from '../services/api';
import type { Category } from '../services/api';

interface CreateArticleModalProps {
  isOpen: boolean;
  onClose: () => void;
  categories: Category[];
  onSuccess: () => void;
}

const CreateArticleModal = ({ isOpen, onClose, categories, onSuccess }: CreateArticleModalProps) => {
  const [formData, setFormData] = useState({
    title: '',
    excerpt: '',
    content: '',
    featured_image_url: '',
    category_id: '',
    published_date: new Date().toISOString().split('T')[0],
    is_published: false,
    read_time: 5
  });
  const [loading, setLoading] = useState(false);
  const [preview, setPreview] = useState(false);
  const [imageMode, setImageMode] = useState<'url' | 'upload'>('url');
  const [selectedFile, setSelectedFile] = useState<File | null>(null);
  const [uploadProgress, setUploadProgress] = useState(0);

  const handleImageUpload = async (file: File) => {
    if (!file) return;

    // Validate file type
    if (!file.type.startsWith('image/')) {
      alert('Veuillez sélectionner une image valide');
      return;
    }

    // Validate file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
      alert('L\'image ne doit pas dépasser 5MB');
      return;
    }

    setSelectedFile(file);
    setUploadProgress(0);

    // Create preview
    const reader = new FileReader();
    reader.onloadend = () => {
      setFormData(prev => ({
        ...prev,
        featured_image_url: reader.result as string
      }));
    };
    reader.readAsDataURL(file);

    // Simulate upload progress
    const interval = setInterval(() => {
      setUploadProgress(prev => {
        if (prev >= 100) {
          clearInterval(interval);
          return 100;
        }
        return prev + 10;
      });
    }, 100);
  };

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
      handleImageUpload(file);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    try {
      console.log('Submitting article data:', formData);
      
      const articleData = {
        ...formData,
        category_id: parseInt(formData.category_id),
        author_id: 1, // ID de l'auteur par défaut
        published_date: new Date().toISOString(), // Full datetime string
        is_published: true, // Publier automatiquement l'article
        read_time: parseInt(formData.read_time.toString())
      };
      
      console.log('Processed article data:', articleData);
      
      const response = await apiService.createArticle(articleData);
      console.log('Article created successfully:', response);
      
      // Reset form
      setFormData({
        title: '',
        excerpt: '',
        content: '',
        featured_image_url: '',
        category_id: '',
        published_date: new Date().toISOString().split('T')[0],
        is_published: false,
        read_time: 5
      });
      setImageMode('url');
      setSelectedFile(null);
      setUploadProgress(0);
      
      alert('Article créé avec succès!');
      onSuccess();
      onClose();
    } catch (error) {
      console.error('Error creating article:', error);
      alert('Erreur lors de la création de l\'article: ' + (error as Error).message);
    } finally {
      setLoading(false);
    }
  };

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value, type } = e.target as HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement;
    setFormData(prev => ({
      ...prev,
      [name]: type === 'checkbox' ? (e.target as HTMLInputElement).checked : value
    }));
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div className="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
        {/* Header */}
        <div className="flex items-center justify-between p-6 border-b">
          <h2 className="text-2xl font-bold text-gray-900">Créer un nouvel article</h2>
          <div className="flex items-center space-x-2">
            <button
              onClick={() => setPreview(!preview)}
              className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
            >
              <Eye className="h-5 w-5 text-gray-600" />
            </button>
            <button
              onClick={onClose}
              className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
            >
              <X className="h-5 w-5 text-gray-600" />
            </button>
          </div>
        </div>

        {/* Content */}
        <div className="p-6 overflow-y-auto max-h-[calc(90vh-8rem)]">
          {preview ? (
            <div className="prose prose-lg max-w-none">
              <h1>{formData.title || 'Titre de l\'article'}</h1>
              <div className="text-gray-600 mb-4">{formData.excerpt}</div>
              <div dangerouslySetInnerHTML={{ __html: formData.content || '<p>Contenu de l\'article...</p>' }} />
            </div>
          ) : (
            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Titre de l'article *
                  </label>
                  <input
                    type="text"
                    name="title"
                    value={formData.title}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Titre attractif..."
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Catégorie *
                  </label>
                  <select
                    name="category_id"
                    value={formData.category_id}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                  >
                    <option value="">Sélectionner une catégorie</option>
                    {categories.map((category) => (
                      <option key={category.id} value={category.id}>
                        {category.name}
                      </option>
                    ))}
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Extrait *
                </label>
                <textarea
                  name="excerpt"
                  value={formData.excerpt}
                  onChange={handleInputChange}
                  required
                  rows={3}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                  placeholder="Résumé de l'article (150-200 caractères)..."
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Image principale
                </label>
                
                {/* Image Mode Toggle */}
                <div className="flex space-x-4 mb-4">
                  <button
                    type="button"
                    onClick={() => setImageMode('url')}
                    className={`px-4 py-2 rounded-lg font-medium transition-colors ${
                      imageMode === 'url'
                        ? 'bg-primary-600 text-white'
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                  >
                    URL
                  </button>
                  <button
                    type="button"
                    onClick={() => setImageMode('upload')}
                    className={`px-4 py-2 rounded-lg font-medium transition-colors flex items-center ${
                      imageMode === 'upload'
                        ? 'bg-primary-600 text-white'
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                  >
                    <Upload className="h-4 w-4 mr-2" />
                    Upload
                  </button>
                </div>

                {/* URL Input */}
                {imageMode === 'url' && (
                  <input
                    type="url"
                    name="featured_image_url"
                    value={formData.featured_image_url}
                    onChange={handleInputChange}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="https://example.com/image.jpg"
                  />
                )}

                {/* File Upload */}
                {imageMode === 'upload' && (
                  <div className="space-y-3">
                    <div className="flex items-center justify-center w-full">
                      <label className="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div className="flex flex-col items-center justify-center pt-5 pb-6">
                          <Upload className="w-8 h-8 mb-3 text-gray-400" />
                          <p className="mb-2 text-sm text-gray-500">
                            <span className="font-semibold">Cliquez pour uploader</span> ou glissez-déposez
                          </p>
                          <p className="text-xs text-gray-500">PNG, JPG, GIF (MAX. 5MB)</p>
                        </div>
                        <input
                          type="file"
                          className="hidden"
                          accept="image/*"
                          onChange={handleFileChange}
                        />
                      </label>
                    </div>
                    
                    {selectedFile && (
                      <div className="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                        <ImageIcon className="h-5 w-5 text-blue-600" />
                        <span className="text-sm text-blue-800">{selectedFile.name}</span>
                        {uploadProgress > 0 && uploadProgress < 100 && (
                          <div className="flex-1 bg-blue-200 rounded-full h-2">
                            <div 
                              className="bg-blue-600 h-2 rounded-full transition-all duration-300"
                              style={{ width: `${uploadProgress}%` }}
                            />
                          </div>
                        )}
                      </div>
                    )}
                  </div>
                )}

                {/* Image Preview */}
                {formData.featured_image_url && (
                  <div className="mt-4">
                    <img
                      src={formData.featured_image_url}
                      alt="Preview"
                      className="w-full h-48 object-cover rounded-lg"
                    />
                  </div>
                )}
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Contenu *
                </label>
                <textarea
                  name="content"
                  value={formData.content}
                  onChange={handleInputChange}
                  required
                  rows={12}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                  placeholder="Écrivez votre article ici (HTML autorisé)..."
                />
                <p className="text-sm text-gray-500 mt-1">
                  Vous pouvez utiliser du HTML pour formater votre contenu
                </p>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Date de publication *
                  </label>
                  <input
                    type="date"
                    name="published_date"
                    value={formData.published_date}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Temps de lecture (minutes)
                  </label>
                  <input
                    type="number"
                    name="read_time"
                    value={formData.read_time}
                    onChange={handleInputChange}
                    min="1"
                    max="30"
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                  />
                </div>

                <div className="flex items-center">
                  <input
                    type="checkbox"
                    name="is_published"
                    id="is_published"
                    checked={formData.is_published}
                    onChange={handleInputChange}
                    className="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                  />
                  <label htmlFor="is_published" className="ml-2 text-sm text-gray-700">
                    Publier immédiatement
                  </label>
                </div>
              </div>
            </form>
          )}
        </div>

        {/* Footer */}
        <div className="flex items-center justify-between p-6 border-t bg-gray-50">
          <div className="text-sm text-gray-500">
            * Champs obligatoires
          </div>
          <div className="flex items-center space-x-3">
            <button
              onClick={onClose}
              className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Annuler
            </button>
            <button
              onClick={handleSubmit}
              disabled={loading}
              className="btn-primary flex items-center"
            >
              <Save className="h-5 w-5 mr-2" />
              {loading ? 'Création...' : 'Créer l\'article'}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CreateArticleModal;
