import { useAuth } from "../../Auth/AuthProvider";
import { useNavigate } from "react-router-dom";
import Navigation from "./Navigation";
import {
  Leaf,
  LayoutDashboard,
  LogOut,
  Newspaper,
  Settings,
  MessageCircleQuestionMark,
  Users,
  Paintbrush,
  Image,
  Database,
  ChartNoAxesCombined,
} from "lucide-react";

const Sidenav = ({ tenantSlug }) => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    if (user?.roles.includes("ROLE_ABONNE")) {
      navigate("/");
    } else {
      navigate("/login");
    }
  };


  const menuTop = (tenantSlug) => [
    {
      label: "Tableau de bord",
      key: "dashboard",
      icon: <LayoutDashboard size={20} />,
      to: `/dashboard/${tenantSlug}`,
    },
    {
      label: "Articles",
      key: "articles",
      icon: <Newspaper size={20} />,
      to: `/dashboard/${tenantSlug}/articles`,
    },
    {
      label: "Visualisations",
      key: "Visualisation",
      icon: <ChartNoAxesCombined size={20} />,
      to: `/dashboard/${tenantSlug}/Visualisations`,
    },
 /*    {
      label: "Apparences",
      key: "apparence",
      icon: <Paintbrush size={20} />,
      to: `/dashboard/${tenantSlug}/apparences`,
    }, */
    {
      label: "Medias",
      key: "media",
      icon: <Image size={20} />,
      to: `/dashboard/${tenantSlug}/medias`,
    },
     {
      label: "Dataset",
      key: "dataset",
      icon: <Database size={20} />,
      to: `/dashboard/${tenantSlug}/datasets`,
    },
    {
      label: "Utilisateurs",
      key: "utilisateur",
      icon: <Users size={20} />,
      to: `/dashboard/${tenantSlug}/utilisateurs`,
    },
  ];

  const menuBottom = (tenantSlug) => [
    {
      label: "Paramètre",
      key: "parametre",
      icon: <Settings size={20} />,
      to: `/dashboard/${tenantSlug}/parametres`,
    },
    {
      label: "Aide et Support",
      key: "support",
      icon: <MessageCircleQuestionMark size={20} />,
      to: `/dashboard/${tenantSlug}/supports`,
    },
    {
      label: "Déconnexion",
      key: "deconnexion",
      icon: <LogOut size={20} />,
      onClick: handleLogout,
    },
  ];

  return (
    <div className="flex flex-col w-70 p-3 text-white gap-6">
      <div className="flex gap-2 justify-center px-1 py-3">
        <Leaf className="font-bold" />
        <h3 className="text-2xl font-bold text-amber-100">
          Dev<span className="text-white">4Earth</span>
        </h3>
      </div>

      {/*  On appelle les fonctions avec tenantSlug pour récupérer les tableaux */}
      <div className="flex-1 py-8 flex flex-col">
        <Navigation list={menuTop(tenantSlug)} />
      </div>
      <div className="flex-1 py-8 flex flex-col pt-2 border-t">
        <Navigation list={menuBottom(tenantSlug)} />
      </div>
    </div>
  );
};

export default Sidenav;
