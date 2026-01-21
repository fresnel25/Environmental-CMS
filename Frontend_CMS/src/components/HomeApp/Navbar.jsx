import React, { useState, useEffect } from "react";
import { NavLink, useNavigate } from "react-router-dom";
import logo from "../../../public/assets/img_app/logo.png";

export default function Navbar() {
  const [open, setOpen] = useState(false);
  const [theme, setTheme] = useState(localStorage.getItem("theme") || "light");
  const navigate = useNavigate();

  useEffect(() => {
    document.documentElement.setAttribute("data-theme", theme);
    localStorage.setItem("theme", theme);
  }, [theme]);

  const linkClass = "hover:text-white transition";

  return (
    <nav
      className="
       sticky top-0 z-50
        w-full shadow-md transition-colors duration-300
        bg-gradient-to-r
        from-[rgb(var(--navbar-from))]
        to-[rgb(var(--navbar-to))]
      "
    >
      <div className="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        {/* Logo */}
        <div
          className="flex items-center gap-3 cursor-pointer"
          onClick={() => navigate("/")}
        >
          <img src={logo} alt="Dev4Earth Logo" className="h-14 w-auto" />
          <span className="text-2xl font-bold text-white">Dev4Earth</span>
        </div>

        {/* Desktop Links */}
        <div className="hidden md:flex items-center gap-8 text-white/90 font-medium">
          <NavLink to="/" className={linkClass}>
            Accueil
          </NavLink>

          <NavLink to="/features" className={linkClass}>
            Fonctionnalités
          </NavLink>

          <NavLink to="/pricing" className={linkClass}>
            Tarifs
          </NavLink>

          {/* Toggle Theme */}
          <button
            onClick={() => setTheme(theme === "light" ? "dark" : "light")}
            className="px-3 py-2 rounded-lg bg-white/20 hover:bg-white/30 transition"
            aria-label="Changer de thème"
          >
            {theme === "light" ? "🌙" : "🌞"}
          </button>

          {/* Connexion / Inscription */}
          <button
            onClick={() => navigate("/login")}
            className="px-4 py-2 rounded-lg bg-white/20 hover:bg-white/30 transition text-white"
          >
            Connexion
          </button>

          <button
            onClick={() => navigate("/signup")}
            className="bg-accent text-[rgb(var(--primary))] px-4 py-2 rounded-lg hover:bg-gray-100 transition"
          >
            Inscription
          </button>
        </div>

        {/* Mobile Burger */}
        <button
          className="md:hidden text-white text-3xl"
          onClick={() => setOpen(!open)}
        >
          {open ? "×" : "☰"}
        </button>
      </div>

      {/* Mobile Menu */}
      {open && (
        <div className="md:hidden px-6 py-4 bg-[rgb(var(--navbar-to))]">
          <button
            onClick={() => {
              navigate("/");
              setOpen(false);
            }}
            className="block py-2 text-white w-full text-left"
          >
            Accueil
          </button>

          <button
            onClick={() => {
              navigate("/features");
              setOpen(false);
            }}
            className="block py-2 text-white w-full text-left"
          >
            Fonctionnalités
          </button>

          <button
            onClick={() => {
              navigate("/pricing");
              setOpen(false);
            }}
            className="block py-2 text-white w-full text-left"
          >
            Tarifs
          </button>

          <button
            onClick={() => setTheme(theme === "light" ? "dark" : "light")}
            className="mt-4 w-full bg-white/20 text-white px-4 py-2 rounded-lg"
          >
            {theme === "light" ? "🌙 Mode sombre" : "🌞 Mode clair"}
          </button>

          <button
            onClick={() => {
              navigate("/login");
              setOpen(false);
            }}
            className="mt-3 w-full bg-white/20 text-white px-4 py-2 rounded-lg"
          >
            Connexion
          </button>

          <button
            onClick={() => {
              navigate("/signup");
              setOpen(false);
            }}
            className="mt-3 w-full bg-white text-[rgb(var(--primary))] px-4 py-2 rounded-lg"
          >
            Inscription
          </button>
        </div>
      )}
    </nav>
  );
}
