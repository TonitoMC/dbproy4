import axios from "axios";
import { Check, Edit, Trash } from "lucide-react";
import { useEffect, useState } from "react";
import DataTableWrapper from "../../components/table/DataTableWrapper";
import { type Manage } from "../../models/Products.model";
import './Manage.css';

const ExpandedRow: React.FC<{ data: Manage }> = ({ data }) => (
  <div style={{ padding: "12px 16px" }}>
    <strong>Descripción:</strong>
    <p style={{ marginTop: "4px" }}>{data.description}</p>
  </div>
);

const Products = () => {
  const [products, setProducts] = useState<Manage[]>([]);
  const [loading, setLoading] = useState(true);
  const [editingId, setEditingId] = useState<number | null>(null);
  const [editForm, setEditForm] = useState<Manage | null>(null);

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/products")
      .then((res) => {
        setProducts(res.data.data);
        console.log(res.data.data);
      })
      .catch((err) => console.error("API error:", err))
      .finally(() => setLoading(false));
  }, []);

  const handleEdit = (product: Manage) => {
    setEditingId(product.id);
    setEditForm({ ...product });
  };

  const handleSave = async (id: number) => {
    if (editForm) {
      try {
        await axios.put(`http://localhost:8000/api/products/${id}`, editForm);
        setProducts((prev) =>
          prev.map((p) => (p.id === id ? { ...p, ...editForm } : p))
        );
        setEditingId(null);
        setEditForm(null);
      } catch (err) {
        alert("Error al guardar el producto");
        console.error(err);
      }
    }
  };

  const handleDelete = async (id: number) => {
    if (window.confirm("¿Estás seguro de eliminar este producto?")) {
      try {
        await axios.delete(`http://localhost:8000/api/products/${id}`);
        setProducts((prev) => prev.filter((p) => p.id !== id));
      } catch (err) {
        alert("Error al eliminar el producto");
        console.error(err);
      }
    }
  };

  const columns = [
    {
      name: "ID",
      selector: (row: Manage) => row.id,
      sortable: true,
      width: "70px",
    },
    {
      name: "Nombre",
      cell: (row: Manage) =>
        editingId === row.id ? (
          <input
            value={editForm?.name}
            onChange={(e) => setEditForm({ ...editForm!, name: e.target.value })}
          />
        ) : (
          row.name
        ),
      sortable: true,
      width: "250px",
    },
    {
      name: "Categorías",
      cell: (row: Manage) => (
        <div style={{ display: "flex", gap: "4px", flexWrap: "wrap" }}>
          {row.categories.map((cat) => (
            <span
              key={cat.id}
              style={{
                padding: "5px 10px",
                borderRadius: "10px",
                backgroundColor: "#20232a",
                border: "1px solid rgb(158, 201, 236)",
                fontSize: "0.8rem",
                color: "rgb(158, 201, 236)",
              }}
            >
              {cat.name}
            </span>
          ))}
        </div>
      ),
      sortable: false,
      width: "350px",
      wrap: true,
    },
    {
      name: "Precio",
      selector: (row: Manage) => row.price,
      sortable: true,
      width: "150px",
    },
    {
      name: "Marca",
      selector: (row: Manage) => row.brand.name,
      sortable: true,
      width: "250px",
    },
    {
      name: "Acciones",
      cell: (row: Manage) =>
        editingId === row.id ? (
          <button onClick={() => handleSave(row.id)}>
            <Check size={18} />
          </button>
        ) : (
          <div style={{ display: "flex", gap: "8px" }}>
            <button
              className="btn-edit"
              onClick={() => handleEdit(row)}
              title="Editar"
            >
              <Edit size={18} />
            </button>
            <button
              className="btn-delete"
              onClick={() => handleDelete(row.id)}
              title="Eliminar"
            >
              <Trash size={18} />
            </button>
          </div>
        ),
      ignoreRowClick: true,
      allowOverflow: true,
      button: true,
    },
  ];

  return (
    <div>
      <h1>Editar productos</h1>
      <DataTableWrapper<Manage>
        title="Lista de productos"
        columns={columns}
        data={products}
        loading={loading}
        expandableRowsComponent={ExpandedRow}
      />
    </div>
  );
};

export default Products;
