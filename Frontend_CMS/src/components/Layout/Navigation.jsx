import { NavLink } from "react-router-dom";

const Navigation = ({ list }) => {
  return (
    <nav className="flex flex-col gap-4">
      {list.map((item) => (
        <NavLink
          key={item.key}
          to={item.to}
          className={({ isActive }) =>
            `flex items-center gap-3 p-2 rounded-md transition 
            ${
              isActive
                ? "bg-white text-green-800 font-bold"
                : "hover:bg-base-200"
            }`
          }
        >
          {item.icon}
          <span>{item.label}</span>
        </NavLink>
      ))}
    </nav>
  );
};

export default Navigation;
