import { Heart, Mail, Facebook, Twitter, Instagram, Linkedin } from 'lucide-react';

const Footer = () => {
  const currentYear = new Date().getFullYear();

  const navigation = [
    { name: 'Accueil', href: '/' },
    { name: 'Nutrition et Alimentation', href: '/nutrition' },
    { name: 'Prévention et Bien-être', href: '/prevention' },
    { name: 'Santé mentale', href: '/sante-mentale' },
    { name: 'Interview et témoignage', href: '/interviews' },
    { name: 'Puériculture', href: '/puericulture' },
    { name: 'FAQ / Dr j\'ai une question', href: '/faq' },
    { name: 'À Propos / Contact', href: '/a-propos' },
  ];

  const socialLinks = [
    { name: 'Facebook', href: '#', icon: Facebook },
    { name: 'Twitter', href: '#', icon: Twitter },
    { name: 'Instagram', href: '#', icon: Instagram },
    { name: 'LinkedIn', href: '#', icon: Linkedin },
  ];

  return (
    <footer className="bg-gray-900 text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          {/* Logo et description */}
          <div className="col-span-1 md:col-span-2">
            <div className="flex items-center space-x-2 mb-4">
              <Heart className="h-8 w-8 text-primary-500" />
              <div className="flex flex-col">
                <span className="text-xl font-bold text-white">Ma Santé</span>
                <span className="text-sm text-primary-400 font-medium">Ma responsabilité</span>
              </div>
            </div>
            <p className="text-gray-300 mb-4 max-w-md">
              Votre guide pour une vie saine et équilibrée. Des informations essentielles pour prendre des décisions éclairées sur votre santé.
            </p>
            <div className="flex space-x-4">
              {socialLinks.map((item) => {
                const Icon = item.icon;
                return (
                  <a
                    key={item.name}
                    href={item.href}
                    className="text-gray-400 hover:text-primary-400 transition-colors duration-200"
                    aria-label={item.name}
                  >
                    <Icon className="h-5 w-5" />
                  </a>
                );
              })}
            </div>
          </div>

          {/* Navigation */}
          <div>
            <h3 className="text-lg font-semibold text-white mb-4">Navigation</h3>
            <ul className="space-y-2">
              {navigation.map((item) => (
                <li key={item.name}>
                  <a
                    href={item.href}
                    className="text-gray-300 hover:text-primary-400 transition-colors duration-200"
                  >
                    {item.name}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h3 className="text-lg font-semibold text-white mb-4">Contact</h3>
            <div className="space-y-2">
              <a
                href="mailto:contact@masante-responsabilite.fr"
                className="flex items-center text-gray-300 hover:text-primary-400 transition-colors duration-200"
              >
                <Mail className="h-4 w-4 mr-2" />
                contact@masante-responsabilite.fr
              </a>
            </div>
            <div className="mt-4">
              <a
                href="/a-propos"
                className="text-primary-400 hover:text-primary-300 transition-colors duration-200"
              >
                En savoir plus sur nous →
              </a>
            </div>
          </div>
        </div>

        {/* Copyright */}
        <div className="border-t border-gray-800 mt-8 pt-8 text-center">
          <p className="text-gray-400">
            © {currentYear} Ma Santé, Ma responsabilité. Tous droits réservés.
          </p>
          <div className="mt-2 space-x-4">
            <a href="#" className="text-gray-400 hover:text-primary-400 text-sm">
              Politique de confidentialité
            </a>
            <span className="text-gray-600">•</span>
            <a href="#" className="text-gray-400 hover:text-primary-400 text-sm">
              Mentions légales
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
