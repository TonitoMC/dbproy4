// src/routes.tsx
import { type RouteObject, useRoutes } from "react-router";
import Homepage from "../pages/homepage/Homepage";
import Products from "../pages/products/Products";
import Users from "../pages/users/Users";

const routes: RouteObject[] = [
  {
    path: "/",
    element: <Homepage />,
  },
  {
    path: "/users",
    element: <Users />,
  },
  {
    path: "/products",
    element: <Products />,
  },
];

export function AppRoutes() {
  const element = useRoutes(routes);
  return element;
}



