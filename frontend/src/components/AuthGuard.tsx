import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

interface AuthGuardProps {
  children: React.ReactNode;
}

const AuthGuard = ({ children }: AuthGuardProps) => {
  const navigate = useNavigate();

  useEffect(() => {
    const checkAuth = () => {
      const token = localStorage.getItem('admin_token');
      const user = localStorage.getItem('admin_user');
      
      if (!token || !user) {
        navigate('/login');
        return false;
      }
      
      return true;
    };

    const isAuthenticated = checkAuth();
    
    // Check token expiration (optional: if you have expiration)
    if (isAuthenticated) {
      try {
        const userData = JSON.parse(localStorage.getItem('admin_user') || '{}');
        if (!userData.email) {
          navigate('/login');
        }
      } catch (error) {
        console.error('Invalid user data in localStorage');
        navigate('/login');
      }
    }
  }, [navigate]);

  return <>{children}</>;
};

export default AuthGuard;
