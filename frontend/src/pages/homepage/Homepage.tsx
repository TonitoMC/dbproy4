import "./Homepage.css";
import { Database, Users, PackageCheck } from "lucide-react";

const Homepage = () => {
  return (
    <main className="home-container">
      <div className="home-card">
        <div className="home-icon">
          <Database size={40} />
        </div>
        <h1 className="home-title">Sistema de gestión de E-comerce</h1>
        <p className="home-description">
          Este proyecto fue desarrollado como parte del curso de{" "}
          <strong>Bases de Datos I</strong>. Incluye funciones CRUD para
          productos y usuarios, integrando una API RESTful hecha con Laravel y
          Elocuent con una base de datos relacional en PostgreSQL.
        </p>
        <div className="home-participants">
          <h2>Realizado por:</h2>
          <ul>
            <li>Diego Flores</li>
            <li>Isabella Recinos</li>
            <li>José Mérida</li>
            <li>Luis Padilla</li>
            <li>Nils Muralles</li>
          </ul>
        </div>
        <div className="home-features">
          <div className="home-feature">
            <PackageCheck size={18} />
            <span>Gestión de productos</span>
          </div>
          <div className="home-feature">
            <Users size={18} />
            <span>Gestión de usuarios</span>
          </div>
        </div>
        <footer className="home-footer">
          © {new Date().getFullYear()} Proyecto académico
        </footer>
      </div>
    </main>
  );
};

export default Homepage;
