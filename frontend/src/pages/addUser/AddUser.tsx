import { useState } from "react";
import axios from "axios";
import "./AddUser.css";

const AddUser = () => {
  const [form, setForm] = useState({
    name: "",
    email: "",
    phone: "",
    is_active: true,
  });
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState("");

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    const target = e.target as HTMLInputElement | HTMLSelectElement;
    const { name, value, type } = target;
    const finalValue =
      type === "checkbox" ? (target as HTMLInputElement).checked : value;
    setForm({ ...form, [name]: finalValue });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setMessage("");
    try {
      const response = await axios.post("http://localhost:8000/api/users", {
        name: form.name,
        email: form.email,
        phone: form.phone || null,
        is_active: form.is_active,
      });
      setMessage("Usuario creado exitosamente");

      // Reinicia el formulario
      setForm({
        name: "",
        email: "",
        phone: "",
        is_active: true,
      });
    } catch (err: any) {
      setMessage(err.response?.data?.message || "Error al crear el usuario");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <h1>Agregar Usuario</h1>
      <form className="add-user-form" onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          placeholder="Nombre"
          value={form.name}
          onChange={handleChange}
          required
        />
        <input
          type="email"
          name="email"
          placeholder="Correo electrónico"
          value={form.email}
          onChange={handleChange}
          required
        />
        <input
          type="text"
          name="phone"
          placeholder="Teléfono (opcional)"
          value={form.phone}
          onChange={handleChange}
        />
        <label className="toggle-switch">
          <input
            type="checkbox"
            name="is_active"
            checked={form.is_active}
            onChange={handleChange}
          />
          <span className="slider"></span>
          <span className="label-text">Usuario activo</span>
        </label>
        <button type="submit" disabled={loading}>
          {loading ? "Agregando..." : "Agregar"}
        </button>
        {message && <p>{message}</p>}
      </form>
    </div>
  );
};

export default AddUser;