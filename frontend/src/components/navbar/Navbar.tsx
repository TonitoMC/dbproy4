// src/components/Navbar.tsx
import { Edit, Home, Plus, ShoppingBagIcon, User } from "lucide-react";
import { type ReactNode } from "react";
import { NavLink } from "react-router";
import "./Navbar.css";

type NavItem = {
  label: string;
  to: string;
  icon: ReactNode;
};

const navItems: NavItem[] = [
  { label: "Home", to: "/", icon: <Home size={20} /> },
  { label: "Products", to: "/products", icon: <ShoppingBagIcon size={20} /> },
  { label: "Add Products", to: "/addproduct", icon: <Plus size={20} /> },
  { label: "Manage Products", to: "/manageproduct", icon: <Edit size={20} /> },
  { label: "Users", to: "/users", icon: <User size={20} /> },
];

export const Navbar = () => {
  return (
    <nav className="navbar">
      <ul className="navbar-list">
        {navItems.map(({ label, to, icon }) => (
          <li key={to}>
            <NavLink
              to={to}
              className={({ isActive }) =>
                isActive ? "nav-link active" : "nav-link"
              }
            >
              {icon}
              <span>{label}</span>
            </NavLink>
          </li>
        ))}
      </ul>
    </nav>
  );
};
