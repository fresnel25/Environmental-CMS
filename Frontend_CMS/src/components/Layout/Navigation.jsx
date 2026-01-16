import { NavLink } from "react-router-dom";

const Navigation = ({ list }) => {
  return (
    <nav className="flex flex-col gap-4">
      {list.map((item) =>
        item.to ? (
          // Lien normal
          <NavLink
            key={item.key}
            to={item.to}
            end={item.key === "dashboard"}  // ⚡ seulement pour Dashboard
            className={({ isActive }) =>
              `flex items-center gap-3 p-2 rounded-md transition 
    ${isActive ? "bg-white text-green-800 font-bold" : "hover:bg-base-200"}`
            }
          >
            {item.icon}
            <span>{item.label}</span>
          </NavLink>
        ) : (
          // Bouton avec action
          <button
            key={item.key}
            onClick={item.onClick}
            className="flex items-center gap-3 p-2 rounded-md hover:bg-base-200 transition text-left w-full"
          >
            {item.icon}
            <span>{item.label}</span>
          </button>
        )
      )}
    </nav>
  );
};

export default Navigation;
