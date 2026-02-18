const HeroSection = () => {
  return (
    <div className="relative bg-gradient-to-r from-primary-600 to-secondary-600 overflow-hidden">
      {/* Background image with overlay */}
      <div className="absolute inset-0">
        <div className="absolute inset-0 bg-black opacity-40"></div>
        <img
          className="w-full h-full object-cover"
          src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
          alt="Personnes pratiquant une activité saine en plein air"
        />
      </div>

      {/* Content */}
      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div className="text-center">
          <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
            Ma Santé, <span className="text-primary-200">Ma responsabilité</span>
          </h1>
          
          <div className="max-w-4xl mx-auto">
            <p className="text-xl md:text-2xl text-white mb-8 leading-relaxed">
              Saviez-vous que vos habitudes de vie représentent 40 % de ce qui détermine votre santé ? 
              C'est un fait fondamental en promotion de la santé.
            </p>
            
            <p className="text-lg md:text-xl text-primary-100 mb-12 leading-relaxed max-w-3xl mx-auto">
              À travers ce blog, je vous invite à explorer des informations essentielles qui vous permettront 
              de prendre des décisions éclairées et de regagner le contrôle sur les domaines que vous pouvez 
              influencer en matière de santé. Mon objectif est de vous guider à travers des domaines clés tels 
              que la nutrition, les habitudes sportives, la santé mentale, et l'hygiène de vie.
            </p>
            
            <p className="text-lg text-primary-200 mb-12 max-w-2xl mx-auto">
              Ce sont des astuces simples, souvent sous-estimées, mais capables de faire une réelle différence 
              sur votre santé au quotidien et sur le long terme.
            </p>
          </div>

          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <button className="btn-primary bg-white text-primary-600 hover:bg-primary-50 border-2 border-white">
              Explorer les rubriques
            </button>
            <button className="bg-transparent border-2 border-white text-white hover:bg-white hover:text-primary-600 font-medium py-3 px-6 rounded-lg transition-colors duration-200">
              Lire le dernier article
            </button>
          </div>
        </div>
      </div>

      {/* Wave separator */}
      <div className="absolute bottom-0 left-0 right-0">
        <svg className="w-full h-12 fill-current text-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
          <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
      </div>
    </div>
  );
};

export default HeroSection;
