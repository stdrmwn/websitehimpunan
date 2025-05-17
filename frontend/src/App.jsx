import { Route, Routes } from "react-router-dom";
import ContactPage from "./pages/ContactPage.jsx";
import DashboardBackend from "./pages/dashboardBackend.jsx";
import DetailArtikel from "./pages/DetailArtikel";
import DivisiPage from "./pages/DivisiPage.jsx";
import FaqPage from "./pages/faqPage.jsx";
import Homepage from "./pages/Homepage.jsx";
import InformasiPage from './pages/Informasi.jsx';
import LoginPage from "./pages/Loginpage.jsx";
import MainEvents from "./pages/MainEvents.jsx";
import Signup from "./pages/signUp.jsx";
import VisionMissionPage from './pages/VisionMissionpage.jsx';
import WebsiteProdi from "./pages/WebsiteProdi";


function App() {
  return (
    <Routes>
      <Route path="/" element={<Homepage />} />
      <Route path="/Loginpage" element={<LoginPage />} />
      <Route path="/Faq" element={<FaqPage />} />
      <Route path="/visimisi" element={<VisionMissionPage />} /> 
      <Route path="/divisi" element={<DivisiPage />} /> 
      <Route path="/events" element={<MainEvents />} /> 
      <Route path="/contact" element={<ContactPage />} /> 
      <Route path="/informasi" element={<InformasiPage />} /> 
      <Route path="/signup" element={<Signup />} /> 
      <Route path="/dashboardBackend" element={<DashboardBackend />} /> 
              <Route path="/informasi/:slug" element={<DetailArtikel />} />
              <Route path="/prodi" element={<WebsiteProdi />} />
    </Routes>
  );
}

export default App;