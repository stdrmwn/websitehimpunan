import { AnimatePresence, motion } from "framer-motion";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";
import Footer from "../pageSection/footer.jsx";

const InformasiPage = () => {
  const [artikels, setArtikels] = useState([]);
  const [filterKategori, setFilterKategori] = useState("Semua");
  const [searchQuery, setSearchQuery] = useState("");
  const [visibleItems, setVisibleItems] = useState(getInitialItemsPerPage());

  const navigate = useNavigate();

  useEffect(() => {
    fetch("http://localhost/WEBSITEHIMPUNAN/backend/get_artikell.php")
      .then((res) => res.json())
      .then((data) => setArtikels(data))
      .catch((err) => console.error("Gagal fetch artikel:", err));
  }, []);

  useEffect(() => {
    const handleResize = () => {
      setVisibleItems(getInitialItemsPerPage());
    };
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  function getInitialItemsPerPage() {
    return window.innerWidth < 768 ? 3 : 6;
  }

  const kategoriList = [
    "Semua",
    "Lomba",
    "After Events",
    "Prestasi",
    "Dana Usaha",
  ];

  const filteredArtikels = artikels.filter((item) => {
    const matchesKategori =
      filterKategori === "Semua" ||
      (item.kategori &&
        item.kategori.toLowerCase() === filterKategori.toLowerCase());
    const matchesSearch =
      item.judul &&
      item.judul.toLowerCase().includes(searchQuery.toLowerCase());
    return matchesKategori && matchesSearch;
  });

  const currentItems = filteredArtikels.slice(0, visibleItems);

  const handleLoadMore = () => {
    setVisibleItems((prev) => prev + getInitialItemsPerPage());
  };

  const handleKategoriChange = (kategori) => {
    setFilterKategori(kategori);
    setVisibleItems(getInitialItemsPerPage());
  };

  const handleSearchChange = (e) => {
    setSearchQuery(e.target.value);
    setVisibleItems(getInitialItemsPerPage());
  };

  return (
    <div className="flex flex-col min-h-screen bg-white font-[Poppins] text-gray-800">
      <NavbarWhite />
      <main className="flex-grow">
        <section className="text-center pt-32 mb-10 px-4">
          <h1 className="text-4xl font-extrabold text-[#7A1E5D]">Informasi</h1>
          <p className="text-gray-600 mt-3 text-lg">
            Informasi Terkini Seputar Himpunan Mahasiswa
          </p>
        </section>

        <section className="px-6 md:px-16 lg:px-24 mb-20">
          <div className="flex items-center justify-between mb-6 flex-wrap gap-4">
            <h2 className="text-2xl font-semibold border-b-4 border-[#7A1E5D] pb-1">
              Daftar Artikel
            </h2>
            <input
              type="text"
              placeholder="Cari artikel..."
              value={searchQuery}
              onChange={handleSearchChange}
              className="border border-gray-300 rounded-md px-4 py-2 text-sm w-full md:w-72 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#7A1E5D]"
            />
          </div>

          {/* Filter Kategori */}
          <div className="flex gap-3 flex-wrap mb-8 justify-center md:justify-start">
            {kategoriList.map((kategori) => (
              <button
                key={kategori}
                onClick={() => handleKategoriChange(kategori)}
                className={`px-6 py-2 rounded-full border transition-all duration-300 text-sm font-medium tracking-wide shadow-sm ${
                  filterKategori === kategori
                    ? "bg-[#7A1E5D] text-white"
                    : "bg-white border-gray-300 text-gray-700 hover:bg-[#f9f9f9]"
                }`}
              >
                {kategori}
              </button>
            ))}
          </div>

          {/* Grid Artikel */}
          <AnimatePresence mode="wait">
            <motion.div
              key={filterKategori + searchQuery + visibleItems}
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -10 }}
              transition={{ duration: 0.3 }}
              className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"
            >
              {currentItems.length > 0 ? (
                currentItems.map((item, index) => (
                  <motion.div
                    key={item.id || index}
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    transition={{ duration: 0.3, delay: index * 0.05 }}
                    className="bg-white border rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 flex flex-col h-[500px] overflow-hidden"
                  >
                    {item.foto && (
                      <img
                        src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${item.foto}`}
                        alt={item.judul}
                        className="h-52 w-full object-cover"
                      />
                    )}
                    <div className="p-5 flex flex-col flex-grow">
                      <h3 className="font-semibold text-lg mb-2 text-[#7A1E5D] leading-snug">
                        {item.judul}
                      </h3>
                      <div
                        className="text-sm text-gray-700 overflow-hidden flex-grow"
                        dangerouslySetInnerHTML={{
                          __html:
                            item.informasi.length > 120
                              ? item.informasi.substring(0, 120) + "..."
                              : item.informasi,
                        }}
                      />
                      <p className="text-xs text-gray-500 mt-3">
                        {new Date(item.tanggal_input).toLocaleDateString(
                          "id-ID"
                        )}
                      </p>
                      <button
                        onClick={() => navigate(`/informasi/${item.slug}`)}
                        className="mt-4 text-sm font-semibold text-[#7A1E5D] hover:underline self-start"
                      >
                        Selengkapnya →
                      </button>
                    </div>
                  </motion.div>
                ))
              ) : (
                <p className="col-span-full text-center text-gray-500">
                  Tidak ada informasi yang sesuai.
                </p>
              )}
            </motion.div>
          </AnimatePresence>

          {/* Tombol Load More TANPA animasi */}
          {visibleItems < filteredArtikels.length && (
            <div className="mt-12 flex justify-center">
              <button
                onClick={handleLoadMore}
                className="mt-8 px-12 py-4 w-[320px] text-[#660033] text-base md:text-lg font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none whitespace-nowrap"
              >
                Load More
              </button>
            </div>
          )}
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default InformasiPage;
