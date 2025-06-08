import axios from "axios";
import { Check, Edit, Trash } from "lucide-react";
import { useEffect, useState } from "react";
import DataTableWrapper from "../../components/table/DataTableWrapper";
import type { SimpleUser } from "../../models/Users.model";
import "./ManageUser.css";

const Users = () => {
  const [users, setUsers] = useState<SimpleUser[]>([]);
  const [loading, setLoading] = useState(true);
  const [editingId, setEditingId] = useState<number | null>(null);
  const [editForm, setEditForm] = useState<Partial<SimpleUser> | null>(null);

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/users")
      .then((res) => setUsers(res.data.data))
      .catch((err) => console.error("Error loading users:", err))
      .finally(() => setLoading(false));
  }, []);

  const handleEdit = (user: SimpleUser) => {
    setEditingId(user.id);
    setEditForm({ ...user });
  };

  const handleInputChange = (
    field: keyof SimpleUser,
    value: string | boolean
  ) => {
    if (editForm) {
      setEditForm({ ...editForm, [field]: value });
    }
  };

  const handleSave = async (id: number) => {
    if (!editForm?.name || !editForm?.email) {
      alert("Nombre y correo son obligatorios.");
      return;
    }

    try {
      await axios.put(`http://localhost:8000/api/users/${id}`, editForm);
      setUsers((prev) =>
        prev.map((u) => (u.id === id ? { ...u, ...editForm } : u))
      );
      setEditingId(null);
      setEditForm(null);
    } catch (err) {
      console.error("Error al guardar el usuario:", err);
      alert("Error al guardar.");
    }
  };

  const handleDelete = async (id: number) => {
    if (window.confirm("¿Estás seguro de eliminar este usuario?")) {
      try {
        await axios.delete(`http://localhost:8000/api/users/${id}`);
        setUsers((prev) => prev.filter((u) => u.id !== id));
      } catch (err) {
        console.error("Error al eliminar el usuario:", err);
        alert("Error al eliminar.");
      }
    }
  };

  const columns = [
    {
      name: "ID",
      selector: (row: SimpleUser) => row.id,
      width: "70px",
      sortable: true,
    },
    {
      name: "Nombre",
      cell: (row: SimpleUser) =>
        editingId === row.id ? (
          <input
            value={editForm?.name || ""}
            onChange={(e) => handleInputChange("name", e.target.value)}
          />
        ) : (
          row.name
        ),
      width: "200px",
      sortable: true,
    },
    {
      name: "Email",
      cell: (row: SimpleUser) =>
        editingId === row.id ? (
          <input
            value={editForm?.email || ""}
            onChange={(e) => handleInputChange("email", e.target.value)}
          />
        ) : (
          row.email
        ),
      width: "250px",
      sortable: true,
    },
    {
      name: "Activo",
      cell: (row: SimpleUser) =>
        editingId === row.id ? (
          <input
            type="checkbox"
            checked={!!editForm?.is_active}
            onChange={(e) =>
              handleInputChange("is_active", e.target.checked)
            }
          />
        ) : row.is_active ? (
          <span className="status active">Sí</span>
        ) : (
          <span className="status inactive">No</span>
        ),
      width: "100px",
    },
    {
      name: "Acciones",
      cell: (row: SimpleUser) =>
        editingId === row.id ? (
          <button onClick={() => handleSave(row.id)} title="Guardar">
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
      <h1>Administrar Usuarios</h1>
      <DataTableWrapper<SimpleUser>
        title="Usuarios registrados"
        columns={columns}
        data={users}
        loading={loading}
      />
    </div>
  );
};

export default Users;
