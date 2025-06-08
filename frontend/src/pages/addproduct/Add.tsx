import { useState } from "react";

type Category = { id: number; name: string };

const categories: Category[] = [
  { id: 1, name: "Board Games" },
  { id: 2, name: "Toys & Games" },
  { id: 3, name: "Puzzles" },
  // ...agrega todas las categorías que tienes en la base de datos
];

const AddProduct = () => {
  const [form, setForm] = useState({
    name: "",
    description: "",
    price: "",
    brand_id: "",
    category1: "",
    category2: "",
    category3: "",
  });
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState("");

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setMessage("");
    try {
      const response = await axios.post("http://localhost:8000/api/products", {
        name: form.name,
        description: form.description,
        price: form.price,
        brand_id: form.brand_id,
      });
      const productId = response.data.id;

      // Filtra categorías seleccionadas, elimina vacíos y duplicados
      const selectedCategories = [form.category1, form.category2, form.category3]
        .filter((id, idx, arr) => id && arr.indexOf(id) === idx)
        .map(Number);

      if (selectedCategories.length > 0) {
        await axios.post(`http://localhost:8000/api/products/${productId}/categories`, {
          categories: selectedCategories,
        });
      }

      setMessage("Producto agregado correctamente");
      setForm({
        name: "",
        description: "",
        price: "",
        brand_id: "",
        category1: "",
        category2: "",
        category3: "",
      });
    } catch (err: any) {
      setMessage(
        err.response?.data?.message || "Error al agregar producto"
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <h1>Agregar Producto</h1>
      <form className="add-product-form" onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          placeholder="Nombre"
          value={form.name}
          onChange={handleChange}
          required
        />
        <textarea
          name="description"
          placeholder="Descripción"
          value={form.description}
          onChange={handleChange}
          required
        />
        <input
          type="text"
          name="price"
          placeholder="Precio"
          value={form.price}
          onChange={handleChange}
          required
        />
        <input
          type="text"
          name="brand_id"
          placeholder="ID de Marca"
          value={form.brand_id}
          onChange={handleChange}
          required
        />
        <label>Categoría 1 (requerida):</label>
        <select
          name="category1"
          value={form.category1}
          onChange={handleChange}
          required
        >
          <option value="">Selecciona una categoría</option>
          {categories.map((cat) => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>
        <label>Categoría 2 (opcional):</label>
        <select
          name="category2"
          value={form.category2}
          onChange={handleChange}
        >
          <option value="">Selecciona una categoría</option>
          {categories.map((cat) => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>
        <label>Categoría 3 (opcional):</label>
        <select
          name="category3"
          value={form.category3}
          onChange={handleChange}
        >
          <option value="">Selecciona una categoría</option>
          {categories.map((cat) => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>
        <button type="submit" disabled={loading}>
          {loading ? "Agregando..." : "Agregar"}
        </button>
        {message && <p>{message}</p>}
      </form>
    </div>
  );
};

export default AddProduct;