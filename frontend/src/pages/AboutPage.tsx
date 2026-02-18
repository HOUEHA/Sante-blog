import { useState } from 'react';
import Header from '../components/Header';
import Footer from '../components/Footer';
import { Mail, Phone, MapPin, Heart, Award, Users, BookOpen } from 'lucide-react';
import { apiService } from '../services/api';

const AboutPage = () => {
  const [email, setEmail] = useState('');
  const [isSubscribing, setIsSubscribing] = useState(false);
  const [subscriptionMessage, setSubscriptionMessage] = useState('');

  const handleSubscribe = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!email) {
      setSubscriptionMessage('Veuillez entrer une adresse email valide');
      return;
    }

    setIsSubscribing(true);
    setSubscriptionMessage('');

    try {
      await apiService.subscribeNewsletter(email);
      setSubscriptionMessage('Inscription réussie! Merci de votre confiance. Vous recevrez un email de confirmation.');
      setEmail('');
    } catch (error) {
      console.error('Newsletter subscription error:', error);
      setSubscriptionMessage('Erreur lors de l\'inscription. Veuillez réessayer.');
    } finally {
      setIsSubscribing(false);
    }
  };
  return (
    <div className="min-h-screen bg-white">
      <Header />
      
      <main>
        {/* Hero Section */}
        <div className="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-16">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center">
              <h1 className="text-4xl md:text-5xl font-bold mb-6">
                À Propos / Contact
              </h1>
              <p className="text-xl max-w-3xl mx-auto opacity-90">
                Découvrez l'histoire derrière "Ma Santé, Ma responsabilité" 
                et la mission qui nous anime.
              </p>
            </div>
          </div>
        </div>

        {/* Notre Mission */}
        <section className="py-16">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-gray-900 mb-6">
                Notre Mission
              </h2>
              <p className="text-lg text-gray-700 leading-relaxed">
                "Ma Santé, Ma responsabilité" est né d'une conviction profonde : 
                chacun d'entre nous a le pouvoir d'influencer positivement sa santé. 
                Notre mission est de vous fournir les connaissances, les outils et 
                l'inspiration nécessaires pour prendre en main votre bien-être.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
              <div className="text-center">
                <div className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Heart className="h-8 w-8 text-primary-600" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                  Prévention
                </h3>
                <p className="text-gray-600">
                  Mieux vaut prévenir que guérir. Nous mettons l'accent sur 
                  les habitudes de vie qui protègent votre santé sur le long terme.
                </p>
              </div>

              <div className="text-center">
                <div className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Award className="h-8 w-8 text-primary-600" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                  Qualité
                </h3>
                <p className="text-gray-600">
                  Toutes nos informations sont validées par des professionnels 
                  de santé et basées sur des preuves scientifiques solides.
                </p>
              </div>

              <div className="text-center">
                <div className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Users className="h-8 w-8 text-primary-600" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                  Accessibilité
                </h3>
                <p className="text-gray-600">
                  Des conseils pratiques et compréhensibles pour que chacun puisse 
                  appliquer facilement nos recommandations au quotidien.
                </p>
              </div>
            </div>
          </div>
        </section>

        {/* À Propos de l'Auteur */}
        <section className="py-16 bg-gray-50">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex flex-col md:flex-row gap-12 items-center">
              <div className="md:w-1/3">
                <div className="w-48 h-48 bg-primary-200 rounded-full mx-auto flex items-center justify-center">
                  <BookOpen className="h-24 w-24 text-primary-600" />
                </div>
              </div>
              
              <div className="md:w-2/3">
                <h2 className="text-3xl font-bold text-gray-900 mb-6">
                  Dr. Martin Santé
                </h2>
                
                <div className="text-gray-700 space-y-4 mb-6">
                  <p>
                    Médecin de formation avec plus de 15 ans d'expérience, 
                    je me suis spécialisé en médecine préventive et en nutrition. 
                    Ma carrière m'a permis d'observer l'impact considérable 
                    de nos habitudes de vie sur notre santé.
                  </p>
                  
                  <p>
                    C'est cette constatation qui m'a poussé à créer ce blog : 
                    partager mes connaissances et mon expérience pour aider 
                    chacun à devenir acteur de sa propre santé.
                  </p>
                  
                  <p>
                    Je crois fermement que l'information et l'éducation sont 
                    les clés d'une vie plus saine et plus épanouie.
                  </p>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div className="text-center">
                    <div className="text-2xl font-bold text-primary-600">15+</div>
                    <div className="text-sm text-gray-600">Années d'expérience</div>
                  </div>
                  <div className="text-center">
                    <div className="text-2xl font-bold text-primary-600">500+</div>
                    <div className="text-sm text-gray-600">Articles publiés</div>
                  </div>
                  <div className="text-center">
                    <div className="text-2xl font-bold text-primary-600">10k+</div>
                    <div className="text-sm text-gray-600">Lecteurs mensuels</div>
                  </div>
                  <div className="text-center">
                    <div className="text-2xl font-bold text-primary-600">98%</div>
                    <div className="text-sm text-gray-600">Satisfaction</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* Contact */}
        <section className="py-16">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-gray-900 mb-6">
                Contactez-nous
              </h2>
              <p className="text-lg text-gray-600">
                Une question ? Une suggestion ? Nous serions ravis de vous entendre.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
              {/* Contact Info */}
              <div className="space-y-6">
                <div className="flex items-center space-x-4">
                  <div className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <Mail className="h-6 w-6 text-primary-600" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900">Email</h3>
                    <p className="text-gray-600">contact@masante-responsabilite.fr</p>
                  </div>
                </div>

                <div className="flex items-center space-x-4">
                  <div className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <Phone className="h-6 w-6 text-primary-600" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900">Téléphone</h3>
                    <p className="text-gray-600">+33 1 23 45 67 89</p>
                  </div>
                </div>

                <div className="flex items-center space-x-4">
                  <div className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <MapPin className="h-6 w-6 text-primary-600" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900">Localisation</h3>
                    <p className="text-gray-600">Paris, France</p>
                  </div>
                </div>
              </div>

              {/* Contact Form */}
              <div className="bg-gray-50 rounded-xl p-6">
                <form className="space-y-4">
                  <div>
                    <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                      Nom complet
                    </label>
                    <input
                      type="text"
                      id="name"
                      name="name"
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                      placeholder="Votre nom"
                    />
                  </div>

                  <div>
                    <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                      Email
                    </label>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                      placeholder="votre@email.com"
                    />
                  </div>

                  <div>
                    <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                      Message
                    </label>
                    <textarea
                      id="message"
                      name="message"
                      rows={4}
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none"
                      placeholder="Votre message..."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full btn-primary"
                  >
                    Envoyer le message
                  </button>
                </form>
              </div>
            </div>
          </div>
        </section>

        {/* Newsletter */}
        <section className="py-16 bg-primary-600 text-white">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 className="text-3xl font-bold mb-4">
              Restez informé
            </h2>
            <p className="text-xl mb-8 opacity-90">
              Abonnez-vous à notre newsletter pour recevoir nos derniers articles 
              et conseils santé directement dans votre boîte mail.
            </p>
            
            <form onSubmit={handleSubscribe} className="max-w-md mx-auto flex gap-4">
              <input
                type="email"
                placeholder="votre@email.com"
                value={email}
                onChange={(e) => setEmail((e.target as HTMLInputElement).value)}
                className="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white"
                required
              />
              <button 
                type="submit"
                disabled={isSubscribing}
                className="btn-primary bg-white text-primary-600 hover:bg-gray-100 disabled:opacity-50"
              >
                {isSubscribing ? 'Inscription...' : 'S\'abonner'}
              </button>
            </form>
            
            {subscriptionMessage && (
              <div className={`mt-4 p-3 rounded-lg text-center ${
                subscriptionMessage.includes('réussie') 
                  ? 'bg-green-100 text-green-800' 
                  : 'bg-red-100 text-red-800'
              }`}>
                {subscriptionMessage}
              </div>
            )}
          </div>
        </section>
      </main>

      <Footer />
    </div>
  );
};

export default AboutPage;
