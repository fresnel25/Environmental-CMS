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
import CreateVisual from "./components/Visualisation/CreateVisualisation";
import { ToastContainer } from "react-toastify";
import GetAllVisualisation from "./components/Visualisation/GetAllVisualisation";
import VisualisationRenderer from "./components/Visualisation/VisualisationRenderer";
import Visualisation from "./components/Visualisation/Visualisation";
import Page404 from "./components/Page404/Page404";
import ArticlesNotes from "./components/Article/ArticlesNotes";
import AbonneLayout from "./components/Layout/AbonneLayout";
import PublicTenantLayout from "./components/Layout/PublicTenantLayout";
import ThemeEditor from "./components/Apparence/ThemeEditor";
import Index from "./components/HomeApp/Index";
import Home from "./components/HomeApp/Home";
import Features from "./components/HomeApp/Features";
import PricingSection from "./components/HomeApp/PricingSection";
import Signup from "./components/HomeApp/Signup";

function App() {
  return (
    <div>
      <AuthProvider>
        <BrowserRouter>
          <ToastContainer />
          <Routes>
            <Route path="/" element={<Index />}>
              <Route index element={<Home />} />
              <Route path="/features" element={<Features />} />
              <Route path="/pricing" element={<PricingSection />} />
              <Route path="/signup" element={<Signup />} />
            </Route>

            {/* Routes publiques */}
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />

            {/* PUBLIC TENANT */}
            <Route path="/:tenantSlug" element={<PublicTenantLayout />}>
              <Route index element={<ArticlesNotes />} />
            </Route>

            {/* Abonné TENANT */}
            <Route
              path="/articles/:tenantSlug"
              element={
                <ProtectedRoute roles={["ROLE_ABONNE"]}>
                  <AbonneLayout />
                </ProtectedRoute>
              }
            >
              <Route index element={<ArticlesNotes />} />
            </Route>

            {/*  Dashboard protégé TENANT */}
            <Route
              path="/dashboard/:tenantSlug"
              element={
                <ProtectedRoute>
                  <Layout />
                </ProtectedRoute>
              }
            >
              <Route path="unauthorized" element={<Unauthorized />} />
              <Route path="*" element={<Page404 />} />
              <Route index element={<Dashboard />} />

              <Route
                path="articles"
                element={
                  <ProtectedRoute
                    roles={[
                      "ROLE_AUTEUR",
                      "ROLE_EDITEUR",
                      "ROLE_ADMINISTRATEUR",
                    ]}
                  >
                    <Article />
                  </ProtectedRoute>
                }
              />

              <Route
                path="article/create"
                element={
                  <ProtectedRoute
                    roles={[
                      "ROLE_AUTEUR",
                      "ROLE_EDITEUR",
                      "ROLE_ADMINISTRATEUR",
                    ]}
                  >
                    <CreateArticle />
                  </ProtectedRoute>
                }
              />

              <Route
                path="articles/:id"
                element={
                  <ProtectedRoute
                    roles={[
                      "ROLE_AUTEUR",
                      "ROLE_EDITEUR",
                      "ROLE_ADMINISTRATEUR",
                    ]}
                  >
                    <DetailArticle />
                  </ProtectedRoute>
                }
              />

              <Route
                path="designer/article/:id"
                element={
                  <ProtectedRoute
                    roles={[
                      "ROLE_DESIGNER",
                      "ROLE_EDITEUR",
                      "ROLE_ADMINISTRATEUR",
                    ]}
                  >
                    <ThemeEditor scope="article" />
                  </ProtectedRoute>
                }
              />

              <Route
                path="designer/bloc/:id"
                element={<ThemeEditor scope="bloc" />}
              />

              {/*  Auteurs, éditeurs, admins */}
              {/*   <Route
              path="blocs"
              element={
                <ProtectedRoute
                  roles={["ROLE_AUTEUR", "ROLE_EDITEUR", "ROLE_ADMINISTRATEUR"]}
                >
                  <Bloc />
                </ProtectedRoute>
              }
            /> */}

              {/*  Auteurs, éditeurs, admins */}
              <Route
                path="Visualisations/create"
                element={
                  <ProtectedRoute
                    roles={["ROLE_FOURNISSEUR_DONNEES", "ROLE_ADMINISTRATEUR"]}
                  >
                    <CreateVisual />
                  </ProtectedRoute>
                }
              />

              <Route
                path="Visualisations"
                element={
                  <ProtectedRoute
                    roles={[
                      "ROLE_AUTEUR",
                      "ROLE_FOURNISSEUR_DONNEES",
                      "ROLE_EDITEUR",
                      "ROLE_ADMINISTRATEUR",
                    ]}
                  >
                    <Visualisation />
                  </ProtectedRoute>
                }
              />

              <Route
                path="Visualisations/:id"
                element={
                  <ProtectedRoute
                    roles={[
                      "ROLE_AUTEUR",
                      "ROLE_EDITEUR",
                      "ROLE_FOURNISSEUR_DONNEES",
                      "ROLE_ADMINISTRATEUR",
                    ]}
                  >
                    <VisualisationRenderer />
                  </ProtectedRoute>
                }
              />

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
                    roles={["ROLE_DESIGNER", "ROLE_FOURNISSEUR_DONNEES","ROLE_ADMINISTRATEUR"]}
                  >
                    <DetailDataset />
                  </ProtectedRoute>
                }
              />

              <Route
                path="datasets/create"
                element={
                  <ProtectedRoute
                    roles={["ROLE_DESIGNER", "ROLE_FOURNISSEUR_DONNEES","ROLE_ADMINISTRATEUR"]}
                  >
                    <CreateDataset />
                  </ProtectedRoute>
                }
              />

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

              <Route
                path="medias"
                element={
                  <ProtectedRoute
                    roles={["ROLE_ABONNE", "ROLE_ADMINISTRATEUR"]}
                  >
                    <Media />
                  </ProtectedRoute>
                }
              />

              <Route
                path="parametres"
                element={
                  <ProtectedRoute roles={["ROLE_ADMINISTRATEUR"]}>
                    <Parametre />
                  </ProtectedRoute>
                }
              />

              <Route path="supports" element={<Support />} />
            </Route>
          </Routes>
        </BrowserRouter>
      </AuthProvider>
    </div>
  );
}

export default App;
