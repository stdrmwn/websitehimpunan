import { CalendarDays } from "lucide-react";
import { useEffect, useState } from "react";
import { Link, useNavigate, useParams } from "react-router-dom";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";
import Footer from "../pageSection/footer.jsx";

const DetailArtikel = () => {
  const { slug } = useParams();
  const navigate = useNavigate();
  const [artikel, setArtikel] = useState(null);
  const [artikelLain, setArtikelLain] = useState([]);
  const [showImageModal, setShowImageModal] = useState(false);

  useEffect(() => {
    setArtikel(null);
    fetch(`http://localhost/WEBSITEHIMPUNAN/backend/get_artikel_detail.php?slug=${slug}`)
      .then((res) => {
        if (!res.ok) throw new Error("Gagal mengambil artikel");
        return res.json();
      })
      .then((data) => {
        if (data && !data.error) {
          setArtikel(data);
        } else {
          navigate("/informasi");
        }
      })
      .catch(() => navigate("/informasi"));
  }, [slug, navigate]);

  useEffect(() => {
    fetch(`http://localhost/WEBSITEHIMPUNAN/backend/get_artikell.php`)
      .then((res) => res.json())
      .then((data) => {
        const filtered = Array.isArray(data)
          ? data.filter((item) => item.slug !== slug).slice(0, 4)
          : [];
        setArtikelLain(filtered);
      })
      .catch((err) => console.error("Gagal fetch artikel lain:", err));
  }, [slug]);

  if (!artikel) {
    return (
      <div className="min-h-screen bg-white flex justify-center items-center">
        <p className="text-[#7A1E5D] font-semibold">Memuat artikel...</p>
      </div>
    );
  }

  return (
    <div className="flex flex-col min-h-screen bg-white">
      <NavbarWhite />

      <main className="flex-grow pt-28 px-4 md:px-16 lg:px-24 pb-16 text-black">
        <div className="max-w-5xl mx-auto">
          <div className="text-sm text-gray-600 mb-4">
            <Link to="/informasi" className="hover:underline text-[#7A1E5D] font-medium">
              Informasi
            </Link>{" "}
            &gt;{" "}
            <span className="font-semibold text-gray-900">{artikel.judul}</span>
          </div>

          {artikel.foto && (
            <>
              <div
                className="relative group w-full h-64 md:h-80 mb-6 rounded-xl overflow-hidden shadow-lg cursor-pointer"
                onClick={() => setShowImageModal(true)}
              >
                <img
                  src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${artikel.foto}`}
                  alt={artikel.judul}
                  className="w-full h-full object-cover group-hover:opacity-80 transition duration-300"
                />
                <div className="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-40 transition duration-300">
                  <span className="text-white text-lg font-semibold opacity-0 group-hover:opacity-100 transition duration-300">
                    Klik untuk perbesar
                  </span>
                </div>
              </div>

              {showImageModal && (
                <div className="fixed inset-0 bg-black bg-opacity-70 z-50 flex justify-center items-center">
                  <div className="relative max-w-4xl w-full mx-4">
                    <button
                      className="absolute top-4 right-4 text-white text-2xl font-bold bg-[#7A1E5D] rounded-full px-3 py-1 hover:bg-[#5e1647] transition"
                      onClick={() => setShowImageModal(false)}
                    >
                      ×
                    </button>
                    <img
                      src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${artikel.foto}`}
                      alt={artikel.judul}
                      className="w-full max-h-[80vh] object-contain rounded-lg"
                    />
                  </div>
                </div>
              )}
            </>
          )}

          {artikel.kategori && (
            <span className="inline-block bg-[#f5e6ef] text-[#7A1E5D] text-sm font-semibold px-3 py-1 rounded-full mb-4">
              {artikel.kategori}
            </span>
          )}

          <h1 className="text-3xl font-bold text-[#7A1E5D] mb-3">
            {artikel.judul}
          </h1>

          <div className="flex items-center text-sm text-gray-600 mb-6">
            <span className="inline-flex items-center gap-1 bg-[#f3f3f3] text-[#7A1E5D] font-medium px-3 py-1 rounded-full">
              <CalendarDays className="w-4 h-4" />
              {new Date(artikel.tanggal_input).toLocaleDateString("id-ID", {
                day: "numeric",
                month: "short",
                year: "numeric",
              })}
            </span>
          </div>

          <div
            className="text-gray-800 leading-relaxed"
            dangerouslySetInnerHTML={{ __html: artikel.informasi }}
          />
        </div>

        {/* Artikel Lainnya */}
        {artikelLain.length > 0 && (
          <div className="max-w-5xl mx-auto mt-16">
            <h2 className="text-xl font-bold mb-4 text-[#7A1E5D]">Artikel Lainnya</h2>
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
              {artikelLain.map((item) => (
                <Link
                  to={`/informasi/${item.slug}`}
                  key={item.slug}
                  className="border border-gray-200 rounded-lg p-4 hover:shadow-md transition bg-white hover:bg-[#fef7fb] group"
                >
                  <p className="text-xs text-[#7A1E5D] font-semibold mb-1">
                    {new Date(item.tanggal_input).toLocaleDateString("id-ID", {
                      day: "numeric",
                      month: "short",
                      year: "numeric",
                    })}
                  </p>
                  <h3 className="text-md font-bold text-gray-800 mb-1 group-hover:text-[#7A1E5D] transition duration-200">
                    {item.judul}
                  </h3>
                  <p className="text-sm text-gray-600 line-clamp-2">
                    {item.informasi.replace(/<[^>]+>/g, "").slice(0, 100)}...
                  </p>
                </Link>
              ))}
            </div>
          </div>
        )}
      </main>

      <Footer />
    </div>
  );
};

export default DetailArtikel;
