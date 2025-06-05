interface Category {
  id: number;
  name: string;
  description: string;
  parent_id: number | null;
  is_active: boolean;
}

interface Brand {
  id: number;
  name: string;
  description: string;
  is_active: boolean;
}

export interface Product {
  id: number;
  name: string;
  description: string;
  price: string;
  is_active: boolean;
  brand: Brand;
  categories: Category[];
}
