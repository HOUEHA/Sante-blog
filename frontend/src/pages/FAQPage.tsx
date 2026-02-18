import { useState, useEffect } from 'react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import { ChevronDown, ChevronUp, Send, MessageCircle, HelpCircle } from 'lucide-react';
import { apiService } from '../services/api';
import type { FAQ } from '../services/api';

const FAQPage = () => {
  const [openQuestion, setOpenQuestion] = useState<string | null>(null);
  const [faqData, setFaqData] = useState<Record<string, FAQ[]>>({});
  const [loading, setLoading] = useState(true);
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    question: ''
  });

  useEffect(() => {
    const fetchFAQ = async () => {
      try {
        const data = await apiService.getFAQ();
        setFaqData(data);
      } catch (error) {
        console.error('Error fetching FAQ:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchFAQ();
  }, []);

  const toggleQuestion = (index: string) => {
    setOpenQuestion(openQuestion === index ? null : index);
  };

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target as HTMLInputElement | HTMLTextAreaElement;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!formData.name || !formData.email || !formData.question) {
      alert('Veuillez remplir tous les champs obligatoires');
      return;
    }

    try {
      // Create FAQ with default answer
      await apiService.createFAQ({
        question: formData.question,
        answer: `Question soumise par ${formData.name} (${formData.email}). En attente de réponse de nos experts de santé.`,
        category: 'Questions des utilisateurs',
        sort_order: 999,
        is_active: false // Inactive until answered by admin
      });
      
      alert('Votre question a été soumise avec succès! Nous vous répondrons dans les plus brefs délais.');
      setFormData({ name: '', email: '', question: '' });
      
      // Refresh FAQ data to show the new question
      const data = await apiService.getFAQ();
      setFaqData(data);
      
    } catch (error: any) {
      console.error('Error submitting FAQ:', error);
      alert('Erreur lors de la soumission de votre question: ' + (error.message || 'Veuillez réessayer'));
    }
  };

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

  return (
    <div className="min-h-screen bg-white">
      <Header />
      
      <main>
        {/* Header */}
        <div className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center">
              <div className="flex justify-center mb-6">
                <HelpCircle className="h-16 w-16" />
              </div>
              <h1 className="text-4xl md:text-5xl font-bold mb-6">
                FAQ / Dr j'ai une question
              </h1>
              <p className="text-xl max-w-3xl mx-auto opacity-90">
                Retrouvez les réponses aux questions les plus fréquentes sur la santé et le bien-être. 
                Si vous ne trouvez pas votre réponse, n'hésitez pas à nous poser votre question.
              </p>
            </div>
          </div>
        </div>

        {/* FAQ Sections */}
        <section className="py-16">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {Object.entries(faqData).map(([category, questions]) => (
              <div key={category} className="mb-12">
                <h2 className="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-primary-500">
                  {category}
                </h2>
                
                <div className="space-y-4">
                  {questions.map((item, questionIndex) => {
                    const isOpen = openQuestion === `${category}-${questionIndex}`;
                    
                    return (
                      <div 
                        key={item.id}
                        className="bg-white border border-gray-200 rounded-lg overflow-hidden"
                      >
                        <button
                          onClick={() => toggleQuestion(`${category}-${questionIndex}`)}
                          className="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200"
                        >
                          <h3 className="text-lg font-medium text-gray-900 pr-4">
                            {item.question}
                          </h3>
                          <div className="flex-shrink-0">
                            {isOpen ? (
                              <ChevronUp className="h-5 w-5 text-gray-500" />
                            ) : (
                              <ChevronDown className="h-5 w-5 text-gray-500" />
                            )}
                          </div>
                        </button>
                        
                        {isOpen && (
                          <div className="px-6 pb-4 border-t border-gray-100">
                            <div className="pt-4 text-gray-700 leading-relaxed">
                              {item.answer}
                            </div>
                          </div>
                        )}
                      </div>
                    );
                  })}
                </div>
              </div>
            ))}
          </div>
        </section>

        {/* Formulaire de question */}
        <section className="py-16 bg-gray-50">
          <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <div className="flex justify-center mb-6">
                <MessageCircle className="h-12 w-12 text-primary-600" />
              </div>
              <h2 className="text-3xl font-bold text-gray-900 mb-4">
                Vous n'avez pas trouvé votre réponse ?
              </h2>
              <p className="text-lg text-gray-600">
                Posez votre question et nos experts de santé vous répondront.
              </p>
            </div>

            <form onSubmit={handleSubmit} className="bg-white rounded-xl shadow-lg p-8">
              <div className="mb-6">
                <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                  Votre nom *
                </label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  value={formData.name}
                  onChange={handleInputChange}
                  required
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                  placeholder="Jean Dupont"
                />
              </div>

              <div className="mb-6">
                <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                  Votre email *
                </label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                  required
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                  placeholder="jean.dupont@email.com"
                />
              </div>

              <div className="mb-6">
                <label htmlFor="question" className="block text-sm font-medium text-gray-700 mb-2">
                  Votre question *
                </label>
                <textarea
                  id="question"
                  name="question"
                  value={formData.question}
                  onChange={handleInputChange}
                  required
                  rows={5}
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none"
                  placeholder="Décrivez votre question en détail..."
                />
              </div>

              <button
                type="submit"
                className="w-full btn-primary flex items-center justify-center"
              >
                <Send className="h-5 w-5 mr-2" />
                Envoyer ma question
              </button>

              <p className="text-sm text-gray-500 mt-4 text-center">
                * Champs obligatoires. Vos données sont protégées et confidentielles.
              </p>
            </form>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  );
};

export default FAQPage;
