import Login from "./components/formulaire/Login";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Register from "./components/formulaire/Register";
import Layout from "./components/Layout/Layout";
import Dashboard from "./components/Dashboard/Dashboard";
import Article from "./components/Article/Article";
import Apparence from "./components/Apparence/Apparence";
import Utilisateur from "./components/Utilisateur/Utilisateur";
import Media from "./components/Media/Media";
import Support from "./components/Support/Support";
import Parametre from "./components/Parametre/Parametre";
import CreateArticle from "./components/Article/CreateArticle";
import DetailArticle from "./components/Article/DetailArticle";
import CreateUser from "./components/Utilisateur/CreateUser";
import { AuthProvider } from "./Auth/AuthProvider";
import { ProtectedRoute } from "./Auth/ProtectedRoute";
import Unauthorized from "./components/Page404/Unauthorized";
import Bloc from "./components/Blocs/Bloc";
import EditUser from "./components/Utilisateur/EditUser";
import Dataset from "./components/Dataset/Dataset";
import CreateDataset from "./components/Dataset/CreateDataset";
import DetailDataset from "./components/Dataset/DetailDataset";

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          {/* Routes publiques */}
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/unauthorized" element={<Unauthorized />} />

          {/*  Dashboard protégé */}
          <Route
            path="/dashboard/:tenantSlug"
            element={
              <ProtectedRoute>
                <Layout />
              </ProtectedRoute>
            }
          >
            {/* Accessible à tout utilisateur connecté */}
            <Route index element={<Dashboard />} />

            {/*  Auteurs, éditeurs, admins */}
            <Route
              path="articles"
              element={
                <ProtectedRoute
                  roles={["ROLE_AUTEUR", "ROLE_EDITEUR", "ROLE_ADMINISTRATEUR"]}
                >
                  <Article />
                </ProtectedRoute>
              }
            />

            <Route
              path="article/create"
              element={
                <ProtectedRoute
                  roles={["ROLE_AUTEUR", "ROLE_EDITEUR", "ROLE_ADMINISTRATEUR"]}
                >
                  <CreateArticle />
                </ProtectedRoute>
              }
            />

            <Route
              path="articles/:id"
              element={
                <ProtectedRoute
                  roles={["ROLE_AUTEUR", "ROLE_EDITEUR", "ROLE_ADMINISTRATEUR"]}
                >
                  <DetailArticle />
                </ProtectedRoute>
              }
            />

            {/*  Auteurs, éditeurs, admins */}
            <Route
              path="blocs"
              element={
                <ProtectedRoute
                  roles={["ROLE_AUTEUR", "ROLE_EDITEUR", "ROLE_ADMINISTRATEUR"]}
                >
                  <Bloc />
                </ProtectedRoute>
              }
            />

            {/*  Designer / Admin */}
            <Route
              path="apparences"
              element={
                <ProtectedRoute
                  roles={["ROLE_DESIGNER", "ROLE_ADMINISTRATEUR"]}
                >
                  <Apparence />
                </ProtectedRoute>
              }
            />

            <Route
              path="datasets"
              element={
                <ProtectedRoute
                  roles={["ROLE_DESIGNER", "ROLE_ADMINISTRATEUR"]}
                >
                  <Dataset />
                </ProtectedRoute>
              }
            />

            <Route
              path="datasets/:id"
              element={
                <ProtectedRoute
                  roles={["ROLE_DESIGNER", "ROLE_ADMINISTRATEUR"]}
                >
                  <DetailDataset />
                </ProtectedRoute>
              }
            />

            <Route
              path="datasets/create"
              element={
                <ProtectedRoute
                  roles={["ROLE_DESIGNER", "ROLE_ADMINISTRATEUR"]}
                >
                  <CreateDataset />
                </ProtectedRoute>
              }
            />

            {/*  Admin uniquement */}
            <Route
              path="utilisateurs"
              element={
                <ProtectedRoute roles={["ROLE_ADMINISTRATEUR"]}>
                  <Utilisateur />
                </ProtectedRoute>
              }
            />

            <Route
              path="utilisateurs/create"
              element={
                <ProtectedRoute roles={["ROLE_ADMINISTRATEUR"]}>
                  <CreateUser />
                </ProtectedRoute>
              }
            />
            <Route
              path="utilisateurs/edit/:id"
              element={
                <ProtectedRoute roles={["ROLE_ADMINISTRATEUR"]}>
                  <EditUser />
                </ProtectedRoute>
              }
            />

            {/*  Abonné / Admin */}
            <Route
              path="medias"
              element={
                <ProtectedRoute roles={["ROLE_ABONNE", "ROLE_ADMINISTRATEUR"]}>
                  <Media />
                </ProtectedRoute>
              }
            />

            {/*  Admin */}
            <Route
              path="parametres"
              element={
                <ProtectedRoute roles={["ROLE_ADMINISTRATEUR"]}>
                  <Parametre />
                </ProtectedRoute>
              }
            />

            {/*  Support : tout utilisateur connecté */}
            <Route path="supports" element={<Support />} />
          </Route>
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}

export default App;
