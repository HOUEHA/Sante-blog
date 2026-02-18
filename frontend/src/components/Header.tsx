import { useState, useEffect } from 'react';
import { Menu, X, Heart, LogOut } from 'lucide-react';

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isAdmin, setIsAdmin] = useState(false);

  useEffect(() => {
    // Check if user is logged in as admin
    const token = localStorage.getItem('admin_token');
    setIsAdmin(!!token);
    
    // Listen for storage changes (for cross-tab updates)
    const handleStorageChange = () => {
      const updatedToken = localStorage.getItem('admin_token');
      setIsAdmin(!!updatedToken);
    };
    
    window.addEventListener('storage', handleStorageChange);
    
    return () => {
      window.removeEventListener('storage', handleStorageChange);
    };
  }, []);

  const handleLogout = () => {
    localStorage.removeItem('admin_token');
    localStorage.removeItem('admin_user');
    setIsAdmin(false);
    window.location.href = '/login';
  };

  const navigation = [
    { name: 'Accueil', href: '/' },
    { name: 'Alimentation', href: '/nutrition' },
    { name: 'Prévention', href: '/prevention' },
    { name: 'Santé mentale', href: '/sante-mentale' },
    { name: 'Interview et témoignage', href: '/interviews' },
    { name: 'Puériculture', href: '/puericulture' },
    { name: 'FAQ', href: '/faq' },
    { name: 'À Propos / Contact', href: '/a-propos' },
  ];

  return (
    <header className="bg-white shadow-sm sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          {/* Logo */}
          <div className="flex items-center space-x-2">
            <Heart className="h-8 w-8 text-primary-600" />
            <div className="flex flex-col">
              <span className="text-xl font-bold text-gray-900">Ma Santé</span>
              <span className="text-sm text-primary-600 font-medium">Ma responsabilité</span>
            </div>
          </div>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex space-x-1">
            {navigation.map((item) => (
              <a
                key={item.name}
                href={item.href}
                className="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-gray-700 hover:text-primary-600"
              >
                {item.name}
              </a>
            ))}
            {isAdmin && (
              <>
                <a
                  href="/admin"
                  className="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 bg-primary-600 text-white hover:bg-primary-700"
                >
                  Dashboard
                </a>
                <button
                  onClick={handleLogout}
                  className="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 bg-red-600 text-white hover:bg-red-700 flex items-center"
                >
                  <LogOut className="h-4 w-4 mr-1" />
                  Logout
                </button>
              </>
            )}
          </nav>

          {/* Mobile menu button */}
          <div className="md:hidden">
            <button
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              className="text-gray-700 hover:text-primary-600 p-2"
            >
              {isMenuOpen ? (
                <X className="h-6 w-6" />
              ) : (
                <Menu className="h-6 w-6" />
              )}
            </button>
          </div>
        </div>

        {/* Mobile Navigation */}
        {isMenuOpen && (
          <div className="md:hidden">
            <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3">
              {navigation.map((item) => (
                <a
                  key={item.name}
                  href={item.href}
                  className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600"
                  onClick={() => setIsMenuOpen(false)}
                >
                  {item.name}
                </a>
              ))}
              {isAdmin && (
                <>
                  <a
                    href="/admin"
                    className="block px-3 py-2 rounded-md text-base font-medium bg-primary-600 text-white hover:bg-primary-700"
                    onClick={() => setIsMenuOpen(false)}
                  >
                    Dashboard
                  </a>
                  <button
                    onClick={() => {
                      handleLogout();
                      setIsMenuOpen(false);
                    }}
                    className="block w-full text-left px-3 py-2 rounded-md text-base font-medium bg-red-600 text-white hover:bg-red-700 flex items-center"
                  >
                    <LogOut className="h-4 w-4 mr-2" />
                    Logout
                  </button>
                </>
              )}
            </div>
          </div>
        )}
      </div>
    </header>
  );
};

export default Header;
