// CreateArticleModal.tsx - Version Corrigée

import React, { useState } from 'react';
import { X, Eye, Save } from 'lucide-react';
import { apiService } from '../services/api-fixed';
import type { Category } from '../services/api-fixed';

interface CreateArticleModalProps {
  isOpen: boolean;
  onClose: () => void;
  categories: Category[];
  onSuccess: () => void;
}

const CreateArticleModal: React.FC<CreateArticleModalProps> = ({
  isOpen,
  onClose,
  categories,
  onSuccess
}) => {
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
  const [imageMode, setImageMode] = useState<'url' | 'upload'>('url');
  const [uploadProgress, setUploadProgress] = useState(0);
  const [preview, setPreview] = useState(false);

  const handleImageUpload = (file: File) => {
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
      
      // Format corrigé des données pour le backend
      const articleData = {
        title: formData.title,
        excerpt: formData.excerpt,
        content: formData.content,
        featured_image_url: formData.featured_image_url,
        category_id: parseInt(formData.category_id),
        author_id: 1, // ID de l'auteur par défaut
        published_date: formData.published_date, // Format YYYY-MM-DD
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
        <div className="flex-1 overflow-y-auto">
          {preview ? (
            <div className="p-6">
              <div className="max-w-4xl mx-auto">
                <h1 className="text-3xl font-bold mb-4">{formData.title || 'Titre de l\'article'}</h1>
                <div className="text-gray-500 text-sm mb-4">
                  Publié le {new Date(formData.published_date).toLocaleDateString('fr-FR')}
                </div>
                <div 
                  className="prose prose-lg max-w-none"
                  dangerouslySetInnerHTML={{ __html: formData.content }}
                />
              </div>
            </div>
          ) : (
            <form onSubmit={handleSubmit} className="p-6 space-y-6">
              {/* Title */}
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
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                  placeholder="Entrez un titre percutant..."
                />
              </div>

              {/* Excerpt */}
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
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                  placeholder="Un résumé percutant de l'article..."
                />
              </div>

              {/* Content */}
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
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                  placeholder="Rédigez votre article ici..."
                />
              </div>

              {/* Category */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Catégorie *
                </label>
                <select
                  name="category_id"
                  value={formData.category_id}
                  onChange={handleInputChange}
                  required
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
                  <option value="">Sélectionnez une catégorie...</option>
                  {categories.map((category) => (
                    <option key={category.id} value={category.id}>
                      {category.name}
                    </option>
                  ))}
                </select>
              </div>

              {/* Featured Image */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Image mise en avant
                </label>
                <div className="space-y-4">
                  {/* Image Mode Toggle */}
                  <div className="flex items-center space-x-4">
                    <label className="flex items-center">
                      <input
                        type="radio"
                        name="imageMode"
                        value="url"
                        checked={imageMode === 'url'}
                        onChange={() => setImageMode('url')}
                        className="mr-2"
                      />
                      <span>URL de l'image</span>
                    </label>
                    <label className="flex items-center">
                      <input
                        type="radio"
                        name="imageMode"
                        value="upload"
                        checked={imageMode === 'upload'}
                        onChange={() => setImageMode('upload')}
                        className="mr-2"
                      />
                      <span>Télécharger une image</span>
                    </label>
                  </div>

                  {/* URL Input */}
                  {imageMode === 'url' && (
                    <input
                      type="url"
                      name="featured_image_url"
                      value={formData.featured_image_url}
                      onChange={handleInputChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                      placeholder="https://example.com/image.jpg"
                    />
                  )}

                  {/* File Upload */}
                  {imageMode === 'upload' && (
                    <div>
                      <input
                        type="file"
                        accept="image/*"
                        onChange={handleFileChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                      />
                      {uploadProgress > 0 && (
                        <div className="mt-2">
                          <div className="w-full bg-gray-200 rounded-full h-2">
                            <div
                              className="bg-primary-600 h-2 rounded-full transition-all duration-300"
                              style={{ width: `${uploadProgress}%` }}
                            />
                          </div>
                        </div>
                      )}
                    </div>
                  )}

                  {/* Image Preview */}
                  {formData.featured_image_url && (
                    <div className="mt-4">
                      <img
                        src={formData.featured_image_url}
                        alt="Aperçu de l'image"
                        className="w-full h-48 object-cover rounded-lg"
                      />
                    </div>
                  )}
                </div>
              </div>

              {/* Published Date */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Date de publication
                </label>
                <input
                  type="date"
                  name="published_date"
                  value={formData.published_date}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
              </div>

              {/* Reading Time */}
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
                  max="60"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
              </div>
            </form>
          )}
        </div>

        {/* Footer */}
        <div className="flex justify-end p-6 border-t bg-gray-50">
          <div className="flex items-center space-x-3">
            <button
              onClick={onClose}
              type="button"
              className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            >
              Annuler
            </button>
            <button
              type="submit"
              disabled={loading}
              onClick={handleSubmit}
              className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50"
            >
              {loading ? (
                <>
                  <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                  Création...
                </>
              ) : (
                <>
                  <Save className="h-4 w-4 mr-2" />
                  Créer l'article
                </>
              )}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CreateArticleModal;
