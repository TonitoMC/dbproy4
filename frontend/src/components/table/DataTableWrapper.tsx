import DataTable, { type TableColumn } from "react-data-table-component";
import './DataCustomTable.css'

interface DataTableWrapperProps<T> {
  title?: string;
  columns: TableColumn<T>[];
  data: T[];
  loading?: boolean;
  expandableRowsComponent?: React.FC<{ data: T }>;
}

function DataTableWrapper<T>({
  title,
  columns,
  data,
  loading = false,
  expandableRowsComponent,
}: DataTableWrapperProps<T>) {
  return (
    <div className="table-container">
      <DataTable
        title={title}
        columns={columns}
        data={data}
        progressPending={loading}
        pagination
        highlightOnHover
        responsive
        theme="dark"
        expandableRows={!!expandableRowsComponent}
        expandableRowsComponent={expandableRowsComponent}
      />
    </div>
  );
}

export default DataTableWrapper;
