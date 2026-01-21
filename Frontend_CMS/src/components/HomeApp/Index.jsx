import { Outlet } from "react-router-dom";
import Navbar from "./Navbar";

const Index = () => {
  return (
    <div>
      <div>
        <Navbar />
      </div>
      <div>
        <Outlet />
      </div>
    </div>
  );
};

export default Index;
