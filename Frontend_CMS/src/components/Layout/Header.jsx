import { useContext } from "react";
import { Moon, Sun } from "lucide-react";
import { ThemeContext } from "../Context/ThemeContextProvider";
import Input from "../Utils/Input";

const Header = ({ name, prenom }) => {
  const { theme, toggleTheme } = useContext(ThemeContext);

  return (
    <div className="bg-white h-16 px-4 flex justify-between items-center">
      {/* <Input placeholder="Rechercher..." /> */}

      <div className="flex gap-3">
        <h2 className="text-xl">Bienvenue</h2>
        <span className="w-8 h-8 rounded-full bg-base-100 flex items-center text-white justify-center font-bold">
          {name}
          {prenom}
        </span>
      </div>

     {/*  <button className="text-2xl" onClick={toggleTheme}>
        {theme === "light" ? <Moon /> : <Sun />}
      </button> */}
    </div>
  );
};

export default Header;
