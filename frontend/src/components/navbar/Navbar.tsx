// src/components/Navbar.tsx
import { NavLink } from "react-router";
import { Home, User, ShoppingBagIcon } from "lucide-react";
import { type ReactNode } from "react";
import "./Navbar.css";

type NavItem = {
  label: string;
  to: string;
  icon: ReactNode;
};

const navItems: NavItem[] = [
  { label: "Home", to: "/", icon: <Home size={20} /> },
  { label: "Products", to: "/products", icon: <ShoppingBagIcon size={20} /> },
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
