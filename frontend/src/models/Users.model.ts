export interface Cart {
  id: number;
  created_at: string | null;
  items_count: number;
  total: number;
}

export interface Review {
  id: number;
  product_id: number;
  user_id: number;
  rating: number;
  comment: string;
  is_approved: boolean;
}

export interface Order {
  id: number;
  user_id: number;
  cart_id: number;
  status: string;
  notes: string | null;
}

export interface User {
  id: number;
  name: string;
  email: string;
  is_active: boolean;
  total_carts: number;
  total_orders: number;
  total_reviews: number;
  total_cart_value: number;
  total_cart_items: number;
  user_roles: string;
  carts: Cart[];
  orders: Order[];
  reviews: Review[];
}

export interface SimpleUser {
  id: number;
  name: string;
  email: string;
  is_active: boolean;
}
