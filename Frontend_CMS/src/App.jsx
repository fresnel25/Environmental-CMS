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
import CreateUser from "./components/Utilisateur/CreateUser";

function App() {
  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/dashboard" element={<Layout />}>
            <Route index element={<Dashboard />} />
            <Route path="articles" element={<Article />} />
            <Route path="create_article" element={<CreateArticle />} />
            <Route path="apparences" element={<Apparence />} />
            <Route path="utilisateurs" element={<Utilisateur />} />
            <Route path="create_user" element={<CreateUser/>}/>
            <Route path="medias" element={<Media />} />
            <Route path="parametres" element={<Parametre />} />
            <Route path="supports" element={<Support />} />
          </Route>
        </Routes>
      </BrowserRouter>
    </>
  );
}

export default App;
