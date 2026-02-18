// API Service pour le Blog Santé - Version Corrigée

const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8002/api';

export interface Article {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  content: string;
  featured_image_url: string;
  category_id: number;
  author_id: number;
  published_date: string;
  is_published: boolean;
  read_time: number;
  created_at?: string;
  updated_at?: string;
  category?: Category;
  author?: User;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  description: string;
  color: string;
  icon: string;
  is_active: boolean;
  sort_order: number;
  created_at?: string;
  updated_at?: string;
}

export interface User {
  id: number;
  name: string;
  email: string;
  role: string;
  is_active: boolean;
  created_at?: string;
  updated_at?: string;
}

export interface FAQ {
  id: number;
  question: string;
  answer: string;
  category: string;
  sort_order: number;
  is_active: boolean;
  created_at?: string;
  updated_at?: string;
}

export interface Newsletter {
  id: number;
  email: string;
  is_active: boolean;
  subscribed_at?: string;
  created_at?: string;
  updated_at?: string;
}

class ApiService {
  private async request<T>(endpoint: string, options?: RequestInit): Promise<T> {
    const url = `${API_BASE_URL}${endpoint}`;
    
    // Get auth token from localStorage
    const token = localStorage.getItem('admin_token');
    
    const response = await fetch(url, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(token && { 'Authorization': `Bearer ${token}` }),
        ...options?.headers,
      },
      ...options,
    });

    if (!response.ok) {
      let errorMessage = `API Error: ${response.status} ${response.statusText}`;
      
      try {
        const errorData = await response.json();
        if (errorData.message) {
          errorMessage = errorData.message;
        }
        if (errorData.errors) {
          errorMessage = Object.values(errorData.errors).flat().join(', ');
        }
      } catch (e) {
        // If we can't parse JSON, use the default error message
      }
      
      throw new Error(errorMessage);
    }

    // Handle 204 No Content responses (like delete operations)
    if (response.status === 204) {
      return null as T;
    }

    return response.json();
  }

  // Authentication
  async login(email: string, password: string): Promise<{ token: string; user: User }> {
    return this.request<{ token: string; user: User }>('/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
  }

  async logout(): Promise<void> {
    return this.request<void>('/logout', {
      method: 'POST',
    });
  }

  // Articles
  async getArticles(): Promise<Article[]> {
    return this.request<Article[]>('/articles');
  }

  async getRecentArticles(): Promise<Article[]> {
    return this.request<Article[]>('/articles/recent');
  }

  async getArticle(slug: string): Promise<Article> {
    return this.request<Article>(`/articles/${slug}`);
  }

  async getArticlesByCategory(categorySlug: string): Promise<Article[]> {
    // Route corrigée - utiliser le paramètre correct
    return this.request<Article[]>(`/articles?category_slug=${categorySlug}`);
  }

  async createArticle(articleData: {
    title: string;
    excerpt: string;
    content: string;
    featured_image_url: string;
    category_id: number;
    author_id: number;
    published_date: string;
    is_published: boolean;
    read_time: number;
  }): Promise<Article> {
    // Format corrigé des données
    const formattedData = {
      ...articleData,
      category_id: parseInt(articleData.category_id.toString()),
      author_id: parseInt(articleData.author_id.toString()),
      published_date: articleData.published_date, // Garder le format YYYY-MM-DD
      is_published: articleData.is_published,
      read_time: parseInt(articleData.read_time.toString())
    };

    console.log('Creating article with data:', formattedData);
    
    return this.request<Article>('/articles/create', {
      method: 'POST',
      body: JSON.stringify(formattedData),
    });
  }

  async updateArticle(slug: string, articleData: Partial<Article>): Promise<Article> {
    return this.request<Article>(`/articles/${slug}/update`, {
      method: 'POST',
      body: JSON.stringify(articleData),
    });
  }

  async deleteArticle(slug: string): Promise<void> {
    return this.request<void>(`/articles/${slug}/delete`, {
      method: 'POST',
    });
  }

  // Categories
  async getCategories(): Promise<Category[]> {
    return this.request<Category[]>('/categories');
  }

  async getCategory(slug: string): Promise<Category> {
    return this.request<Category>(`/categories/${slug}`);
  }

  async createCategory(categoryData: {
    name: string;
    slug: string;
    description: string;
    color: string;
    icon: string;
    sort_order: number;
    is_active: boolean;
  }): Promise<Category> {
    return this.request<Category>('/categories/create', {
      method: 'POST',
      body: JSON.stringify(categoryData),
    });
  }

  async updateCategory(slug: string, categoryData: Partial<Category>): Promise<Category> {
    return this.request<Category>(`/categories/${slug}/update`, {
      method: 'POST',
      body: JSON.stringify(categoryData),
    });
  }

  async deleteCategory(slug: string): Promise<void> {
    return this.request<void>(`/categories/${slug}/delete`, {
      method: 'POST',
    });
  }

  // FAQ
  async getFAQ(): Promise<FAQ[]> {
    return this.request<FAQ[]>('/faq');
  }

  async getFAQByCategory(category: string): Promise<FAQ[]> {
    return this.request<FAQ[]>(`/faq?category=${category}`);
  }

  async createFAQ(faqData: {
    question: string;
    answer: string;
    category: string;
    sort_order?: number;
    is_active?: boolean;
  }): Promise<FAQ> {
    return this.request<FAQ>('/faq/create', {
      method: 'POST',
      body: JSON.stringify(faqData),
    });
  }

  async updateFAQ(id: number, faqData: Partial<FAQ>): Promise<FAQ> {
    return this.request<FAQ>(`/faq/${id}/update`, {
      method: 'POST',
      body: JSON.stringify(faqData),
    });
  }

  async deleteFAQ(id: number): Promise<void> {
    return this.request<void>(`/faq/${id}/delete`, {
      method: 'POST',
    });
  }

  // Newsletter
  async subscribeNewsletter(email: string): Promise<void> {
    return this.request<void>('/newsletter/subscribe', {
      method: 'POST',
      body: JSON.stringify({ email }),
    });
  }

  async unsubscribeNewsletter(email: string): Promise<void> {
    return this.request<void>('/newsletter/unsubscribe', {
      method: 'POST',
      body: JSON.stringify({ email }),
    });
  }

  async getNewsletterSubscribers(): Promise<Newsletter[]> {
    return this.request<Newsletter[]>('/newsletter/subscribers');
  }

  // Users
  async getUsers(): Promise<User[]> {
    return this.request<User[]>('/users');
  }

  async getUser(id: number): Promise<User> {
    return this.request<User>(`/users/${id}`);
  }

  async createUser(userData: {
    name: string;
    email: string;
    password: string;
    role: string;
    is_active?: boolean;
  }): Promise<User> {
    return this.request<User>('/users/create', {
      method: 'POST',
      body: JSON.stringify(userData),
    });
  }

  async updateUser(id: number, userData: Partial<User>): Promise<User> {
    return this.request<User>(`/users/${id}/update`, {
      method: 'POST',
      body: JSON.stringify(userData),
    });
  }

  async deleteUser(id: number): Promise<void> {
    return this.request<void>(`/users/${id}/delete`, {
      method: 'POST',
    });
  }
}

export const apiService = new ApiService();
