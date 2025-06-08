import axios from "axios";
import { useState } from "react";

type Category = { id: number; name: string };
type Brand = { id: number; name: string };

const mainCategories: Category[] = [
  { id: 1, name: "Electronics" },
  { id: 8, name: "Clothing" },
  { id: 15, name: "Home & Kitchen" },
  { id: 22, name: "Books" },
  { id: 29, name: "Sports & Outdoors" },
  { id: 36, name: "Health & Beauty" },
  { id: 42, name: "Automotive" },
  { id: 47, name: "Toys & Games" },
];

const subcategories: { [parentId: number]: Category[] } = {
  1: [
    { id: 2, name: "Smartphones" },
    { id: 3, name: "Laptops" },
    { id: 4, name: "Audio" },
    { id: 5, name: "Gaming" },
    { id: 6, name: "Wearables" },
    { id: 7, name: "Drones" },
  ],
  8: [
    { id: 9, name: "Menswear" },
    { id: 10, name: "Womenswear" },
    { id: 11, name: "Kids Apparel" },
    { id: 12, name: "Footwear" },
    { id: 13, name: "Outerwear" },
    { id: 14, name: "Activewear" },
  ],
  15: [
    { id: 16, name: "Cookware" },
    { id: 17, name: "Appliances" },
    { id: 18, name: "Decor" },
    { id: 19, name: "Furniture" },
    { id: 20, name: "Bedding" },
    { id: 21, name: "Storage" },
  ],
  22: [
    { id: 23, name: "Fiction" },
    { id: 24, name: "Non-Fiction" },
    { id: 25, name: "Childrens" },
    { id: 26, name: "Textbooks" },
    { id: 27, name: "Comics" },
    { id: 28, name: "Magazines" },
  ],
  29: [
    { id: 30, name: "Camping" },
    { id: 31, name: "Cycling" },
    { id: 32, name: "Fitness" },
    { id: 33, name: "Team Sports" },
    { id: 34, name: "Water Sports" },
    { id: 35, name: "Winter Sports" },
  ],
  36: [
    { id: 37, name: "Skincare" },
    { id: 38, name: "Haircare" },
    { id: 39, name: "Makeup" },
    { id: 40, name: "Fragrances" },
    { id: 41, name: "Supplements" },
  ],
  42: [
    { id: 43, name: "Exterior Parts" },
    { id: 44, name: "Interior Accessories" },
    { id: 45, name: "Tools & Equipment" },
    { id: 46, name: "Tires & Wheels" },
  ],
  47: [
    { id: 48, name: "Board Games" },
    { id: 49, name: "Action Figures" },
    { id: 50, name: "Puzzles" },
    { id: 51, name: "Building Blocks" },
    { id: 52, name: "Dolls & Playsets" },
  ],
};

const brands: Brand[] = [
  { id: 1, name: "TechNova" },
  { id: 2, name: "Aura Apparel" },
  { id: 3, name: "KitchenPro" },
  { id: 4, name: "Bookworm Press" },
  { id: 5, name: "GadgetGlide" },
  { id: 6, name: "EcoLiving" },
  { id: 7, name: "SonicSound" },
  { id: 8, name: "PureWater Filters" },
  { id: 9, name: "UrbanWear Co." },
  { id: 10, name: "GreenLeaf Organics" },
  { id: 11, name: "PowerFit Gear" },
  { id: 12, name: "CreativeCanvas" },
  { id: 13, name: "GloBright Lighting" },
  { id: 14, name: "QuickFix Tools" },
  { id: 15, name: "SleepHaven Mattresses" },
];

const AddProduct = () => {
  const [form, setForm] = useState({
    name: "",
    description: "",
    price: "",
    brand_id: "",
    category1: "",
    category2: "",
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
      const productId = response.data.data.id;

      // Solo dos categorías, elimina vacíos y duplicados
      const selectedCategories = [form.category1, form.category2]
        .filter((id, idx, arr) => id && arr.indexOf(id) === idx)
        .map(Number);

      if (selectedCategories.length > 0) {
        await axios.post(`http://localhost:8000/api/products/${productId}/categories`, {
          category_ids: selectedCategories, // <-- Cambia el nombre aquí si tu backend espera 'category_ids'
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
        <label>Categoría principal (requerida):</label>
        <select
          name="category1"
          value={form.category1}
          onChange={handleChange}
          required
        >
          <option value="">Selecciona una categoría principal</option>
          {mainCategories.map((cat) => (
            <option key={cat.id} value={cat.id}>{cat.name}</option>
          ))}
        </select>
        <label>Subcategoría (opcional):</label>
        <select
          name="category2"
          value={form.category2}
          onChange={handleChange}
          disabled={!form.category1}
        >
          <option value="">Selecciona una subcategoría</option>
          {form.category1 &&
            subcategories[Number(form.category1)]?.map((cat) => (
              <option key={cat.id} value={cat.id}>{cat.name}</option>
            ))}
        </select>
        <label>Marca:</label>
        <select
          name="brand_id"
          value={form.brand_id}
          onChange={handleChange}
          required
        >
          <option value="">Selecciona una marca</option>
          {brands.map((brand) => (
            <option key={brand.id} value={brand.id}>{brand.name}</option>
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