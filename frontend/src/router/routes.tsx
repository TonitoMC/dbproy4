// src/routes.tsx
import { type RouteObject, useRoutes } from "react-router";
import Add from "../pages/addproduct/Add";
import Homepage from "../pages/homepage/Homepage";
import Manage from "../pages/manageproduct/Manage";
import Products from "../pages/products/Products";
import Users from "../pages/users/Users";
import AddUser from "../pages/addUser/addUser"
import ManageUser from "../pages/manageUser/ManageUser"

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
  {
    path: "/manageproduct",
    element: <Manage />,
  },
  {
    path: "/addproduct",
    element: <Add />,
  },
  {
    path: "/adduser",
    element: <AddUser/>,
  },
  {
    path: "/manageuser",
    element: <ManageUser/>,
  }
];

export function AppRoutes() {
  const element = useRoutes(routes);
  return element;
}

