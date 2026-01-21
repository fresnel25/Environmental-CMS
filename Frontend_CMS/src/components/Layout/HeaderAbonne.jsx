import { LogOut } from "lucide-react";
import { useAuth } from "../../Auth/AuthProvider";
import { useNavigate, useParams } from "react-router-dom";

const HeaderAbonne = ({ name, prenom, nomTenant }) => {
  const { logout, user } = useAuth();
  const navigate = useNavigate();
  const { tenantSlug } = useParams();

  const handleLogout = () => {
    logout();
    navigate(`/${tenantSlug}`);
  };

  const isAuthenticated = !!user;
  const abonneConnected = user?.roles.includes("ROLE_ABONNE");

  return (
    <>
      {abonneConnected ? (
        <div className="navbar bg-base-100 shadow-sm">
          <div className="flex-1">
            <div className="text-xl text-white font-bold">{nomTenant}</div>
          </div>
          <div className="flex gap-2">
            <div className="dropdown dropdown-end">
              <div
                tabIndex={0}
                role="button"
                className="btn btn-ghost btn-circle avatar"
              >
                <span className="w-8 h-8 rounded-full bg-white flex text-base items-center justify-center font-bold">
                  {name}
                  {prenom}
                </span>
              </div>
              <ul
                tabIndex="-1"
                className="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow"
              >
                <li className="flex">
                  <button
                    className="btn btn-error btn-soft btn-sm"
                    onClick={handleLogout}
                  >
                    <LogOut size={16} /> Logout
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      ) : (
        <div className="navbar bg-base-100 shadow-sm">
          <div className="flex-1">
            <div className="text-xl text-white font-bold">{nomTenant}</div>
          </div>
          <div className="flex gap-2">
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
        </div>
      )}
    </>
  );
};

export default HeaderAbonne;
