import React from "react";
import { Outlet } from "react-router-dom";
import Sidenav from "./Sidenav";
import Header from "./Header";

const Layout = () => {
  return (
    <div className="flex flex-row h-screen w-screen overflow-hidden">
      <Sidenav/>
      <div className="flex-1 bg-neutral-200 text-black">
        <Header/>
        <div className="p-4">{<Outlet />}</div>
      </div>
    </div>
  );
};

export default Layout;
