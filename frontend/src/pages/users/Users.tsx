import { useEffect, useState } from "react";
import DataTableWrapper from "../../components/table/DataTableWrapper";
import { type User } from "../../models/Users.model";
import './Users.css'
import axios from "axios";

const columns = [
  {
    name: "ID",
    selector: (row: User) => row.id,
    sortable: true,
    width: "70px",
  },
  {
    name: "Nombre",
    selector: (row: User) => row.name,
    sortable: true,
    width: "200px",
  },
  {
    name: "Email",
    selector: (row: User) => row.email,
    sortable: true,
    width: "250px",
    wrap: true,
  },
  {
    name: "Roles",
    selector: (row: User) => row.user_roles,
    sortable: false,
    width: "200px",
    wrap: true,
  },
  {
    name: "Act.",
    cell: (row: User) =>
      row.is_active ? (
        <span className="status active">Sí</span>
      ) : (
        <span className="status inactive">No</span>
      ),
    sortable: true,
    width: "80px",
  },
  {
    name: "Carts",
    selector: (row: User) => row.total_carts,
    sortable: true,
    width: "80px",
  },
  {
    name: "Órdenes",
    selector: (row: User) => row.total_orders,
    sortable: true,
    width: "90px",
  },
  {
    name: "Reviews",
    selector: (row: User) => row.total_reviews,
    sortable: true,
    width: "100px",
  },
  {
    name: "Valor Total",
    selector: (row: User) => `$${row.total_cart_value.toFixed(2)}`,
    sortable: true,
    width: "130px",
  },
];

const ExpandedRow: React.FC<{ data: User }> = ({ data }) => (
  <div style={{ padding: "12px 16px" }}>
    <div style={{ marginBottom: "16px" }}>
      <strong>🛒 Carritos:</strong>
      {data.carts.length > 0 ? (
        <ul style={{ margin: "6px 0", paddingLeft: "20px" }}>
          {data.carts.map((cart) => (
            <li key={cart.id}>
              ID #{cart.id} - {cart.items_count} item(s) - Total: $
              {cart.total.toFixed(2)}
            </li>
          ))}
        </ul>
      ) : (
        <p>Sin carritos.</p>
      )}
    </div>

    <div style={{ marginBottom: "16px" }}>
      <strong>📦 Órdenes:</strong>
      {data.orders.length > 0 ? (
        <ul style={{ margin: "6px 0", paddingLeft: "20px" }}>
          {data.orders.map((order) => (
            <li key={order.id}>
              Orden #{order.id} - Estado: <em>{order.status}</em> - Cart ID:{" "}
              {order.cart_id}
              {order.notes ? ` - Notas: ${order.notes}` : ""}
            </li>
          ))}
        </ul>
      ) : (
        <p>Sin órdenes.</p>
      )}
    </div>

    <div>
      <strong>📝 Reviews:</strong>
      {data.reviews.length > 0 ? (
        <ul style={{ margin: "6px 0", paddingLeft: "20px" }}>
          {data.reviews.map((review) => (
            <li key={review.id}>
              Producto #{review.product_id} - {review.rating}⭐ -{" "}
              {review.comment.slice(0, 50)}...
            </li>
          ))}
        </ul>
      ) : (
        <p>Sin reviews.</p>
      )}
    </div>
  </div>
);

const Users = () => {
  const [users, setUsers] = useState<User[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/users")
      .then((res) => {
        setUsers(res.data.data);
      })
      .catch((err) => console.error("API error:", err))
      .finally(() => setLoading(false));
  }, []);

  return (
    <div>
      <h1>Usuarios</h1>
      <DataTableWrapper<User>
        title="Lista de usuarios"
        columns={columns}
        data={users}
        loading={loading}
        expandableRowsComponent={ExpandedRow}
      />
    </div>
  );
};

export default Users;
