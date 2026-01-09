import { useContext } from "react";
import { Moon, Sun } from "lucide-react";
import { ThemeContext } from "../Context/ThemeContextProvider";
import Input from "../Utils/Input";

const Header = () => {
  const { theme, toggleTheme } = useContext(ThemeContext);

  return (
    <div className="bg-white h-16 px-4 flex justify-between items-center">
      <Input placeholder="Rechercher..." />

      <button className="text-2xl" onClick={toggleTheme}>
        {theme === "light" ? <Moon /> : <Sun />}
      </button>
    </div>
  );
};

export default Header;
