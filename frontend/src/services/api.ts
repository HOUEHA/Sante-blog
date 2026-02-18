const API_BASE_URL = 'http://127.0.0.1:8002/api';

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
  category?: Category;
  author?: {
    id: number;
    name: string;
    email: string;
  };
  formatted_date?: string;
  reading_time?: string;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  description: string;
  color: string;
  icon?: string;
  is_active: boolean;
  sort_order: number;
  articles_count?: number;
  articles?: Article[];
}

export interface FAQ {
  id: number;
  question: string;
  answer: string;
  category: string;
  sort_order: number;
  is_active: boolean;
}

export interface PaginatedResponse<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
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

  // Articles
  async getArticles(params?: {
    page?: number;
    per_page?: number;
    category?: string;
    search?: string;
  }): Promise<PaginatedResponse<Article>> {
    return this.request<PaginatedResponse<Article>>('/articles', {
      method: 'POST',
      body: JSON.stringify(params || {}),
    });
  }

  async getRecentArticles(): Promise<Article[]> {
    return this.request<Article[]>('/articles/recent', {
      method: 'POST',
    });
  }

  async getArticle(slug: string): Promise<Article> {
    return this.request<Article>(`/articles/${slug}`, {
      method: 'POST',
    });
  }

  async getRelatedArticles(slug: string): Promise<Article[]> {
    return this.request<Article[]>(`/articles/${slug}/related`, {
      method: 'POST',
    });
  }

  async createArticle(articleData: Partial<Article>): Promise<Article> {
    return this.request<Article>('/articles', {
      method: 'POST',
      body: JSON.stringify(articleData),
    });
  }

  async updateArticle(slug: string, articleData: Partial<Article>): Promise<Article> {
    return this.request<Article>(`/articles/${slug}/update`, {
      method: 'POST',
      body: JSON.stringify(articleData),
    });
  }

  async deleteArticle(slug: string): Promise<void> {
    await this.request<void>(`/articles/${slug}/delete`, {
      method: 'POST',
    });
  }

  // Categories
  async getCategories(): Promise<Category[]> {
    return this.request<Category[]>('/categories', {
      method: 'POST',
    });
  }

  async getCategory(slug: string): Promise<Category> {
    return this.request<Category>(`/categories/${slug}`, {
      method: 'POST',
    });
  }

  async createCategory(categoryData: Partial<Category>): Promise<Category> {
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
  async getFAQ(params?: { category?: string }): Promise<Record<string, FAQ[]>> {
    return this.request<Record<string, FAQ[]>>('/faq', {
      method: 'POST',
      body: JSON.stringify(params || {}),
    });
  }

  async getFAQCategories(): Promise<string[]> {
    return this.request<string[]>('/faq/categories', {
      method: 'POST',
    });
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

  async updateFAQ(id: number, faqData: {
    question?: string;
    answer?: string;
    category?: string;
    sort_order?: number;
    is_active?: boolean;
  }): Promise<FAQ> {
    return this.request<FAQ>(`/faq/${id}/update`, {
      method: 'POST',
      body: JSON.stringify(faqData),
    });
  }

  async deleteFAQ(id: number): Promise<void> {
    await this.request<void>(`/faq/${id}/delete`, {
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

  // Users
  async getUsers(params?: {
    page?: number;
    per_page?: number;
    search?: string;
    role?: string;
    is_active?: boolean;
  }): Promise<any> {
    return this.request<any>('/users', {
      method: 'POST',
      body: JSON.stringify(params || {}),
    });
  }

  async createUser(userData: {
    name: string;
    email: string;
    password: string;
    role?: string;
    is_active?: boolean;
  }): Promise<any> {
    return this.request<any>('/users/create', {
      method: 'POST',
      body: JSON.stringify(userData),
    });
  }

  async updateUser(id: number, userData: {
    name?: string;
    email?: string;
    password?: string;
    role?: string;
    is_active?: boolean;
  }): Promise<any> {
    return this.request<any>(`/users/${id}/update`, {
      method: 'POST',
      body: JSON.stringify(userData),
    });
  }

  async deleteUser(id: number): Promise<void> {
    await this.request<void>(`/users/${id}/delete`, {
      method: 'POST',
    });
  }
}

export const apiService = new ApiService();
