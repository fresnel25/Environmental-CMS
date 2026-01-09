import React from "react";

const CardTable = ({ columns = [], data = [] }) => {
  return (
    <div className="card">
      <div className="overflow-x-auto card-body">
        <table className="table">
          {/* Table Header */}
          <thead className="dark:bg-cyan-950">
            <tr>
              {columns.map((col) => (
                <th key={col.key}>{col.label}</th>
              ))}
            </tr>
          </thead>

          {/* Table Body */}
          <tbody>
            {data.map((row, index) => (
              <tr key={row.id || index}>
                {columns.map((col) => (
                  <td key={col.key}>
                    {col.render ? col.render(row[col.key], row) : row[col.key]}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default CardTable;
