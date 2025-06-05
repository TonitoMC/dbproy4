import { useEffect, useState } from "react";
import DataTableWrapper from "../../components/table/DataTableWrapper";
import { type Product } from "../../models/Products.model";
import axios from "axios";
import './Products.css'

const columns = [
  {
    name: "ID",
    selector: (row: Product) => row.id,
    sortable: true,
    width: "70px",
  },
  {
    name: "Nombre",
    selector: (row: Product) => row.name,
    sortable: true,
    width: "250px",
  },
  {
    name: "Categorías",
    cell: (row:Product) => (
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
    wrap: true
  },
  {
    name: "Precio",
    selector: (row: Product) => row.price,
    sortable: true,
    width: "150px",
  },
  { name: "Marca", 
    selector: (row: Product) => row.brand.name, 
    sortable: true,
    width: "250px",
  },
];

const ExpandedRow: React.FC<{ data: Product }> = ({ data }) => (
  <div style={{ padding: "12px 16px" }}>
    <strong>Descripción:</strong>
    <p style={{ marginTop: "4px" }}>{data.description}</p>
  </div>
);

const Products = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);

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
  return (
    <div>
      <h1>Productos</h1>
      <DataTableWrapper<Product>
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
