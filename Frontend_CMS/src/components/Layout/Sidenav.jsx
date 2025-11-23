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
} from "lucide-react";

const menuTop = [
  {
    label: "Tableau de bord",
    key: "dashboard",
    icon: <LayoutDashboard size={20} />,
    to: "/",
  },
  {
    label: "Articles",
    key: "articles",
    icon: <Newspaper size={20} />,
    to: "/articles",
  },
  {
    label: "Apparences",
    key: "apparence",
    icon: <Paintbrush size={20} />,
    to: "/apparences",
  },
  {
    label: "Medias",
    key: "media",
    icon: <Image size={20} />,
    to: "/medias",
  },
  {
    label: "Utilisateurs",
    key: "utilisateur",
    icon: <Users size={20} />,
    to: "/utilisateurs",
  },
];

const menuBottom = [
  {
    label: "Paramètre",
    key: "parametre",
    icon: <Settings size={20} />,
    to: "/parametres",
  },
  {
    label: "Aide et Support",
    key: "support",
    icon: <MessageCircleQuestionMark size={20} />,
    to: "/supports",
  },
  {
    label: "Déconnexion",
    key: "deconnexion",
    icon: <LogOut size={20} />,
    to: "/deconnexion",
  },
];

const Sidenav = () => {
  return (
    <div className="flex flex-col w-70 p-3 text-white gap-6">
      <div className="flex gap-2 justify-center px-1 py-3">
        <Leaf className="font-bold" />
        <h3 className="text-2xl font-bold text-amber-100">
          Environ<span className="text-white">_Data</span>
        </h3>
      </div>
      <div className="flex-1 py-8 flex flex-col">
        <Navigation list={menuTop} />
      </div>
      <div className="flex-1 py-8 flex flex-col pt-2 border-t">
        <Navigation list={menuBottom} />
      </div>
    </div>
  );
};

export default Sidenav;
