import { Heart } from 'lucide-react';

const LoginOnlyHeader = () => {
  return (
    <header className="bg-white shadow-sm sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-center items-center h-16">
          {/* Logo */}
          <div className="flex items-center space-x-2">
            <Heart className="h-8 w-8 text-primary-600" />
            <div className="flex flex-col">
              <span className="text-xl font-bold text-gray-900">Ma Santé</span>
              <span className="text-sm text-primary-600 font-medium">Ma responsabilité</span>
            </div>
          </div>
        </div>
      </div>
    </header>
  );
};

export default LoginOnlyHeader;
