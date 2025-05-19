import { AnimatePresence, motion } from "framer-motion";
import { X } from "lucide-react";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import 'swiper/css';
import { Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';
import Footer from "../pageSection/footer.jsx";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";

const VisionMissionPage = () => {
  const navigate = useNavigate();

  const [activeSlide, setActiveSlide] = useState(0);
  const [direction, setDirection] = useState(1);
  const [visionText, setVisionText] = useState("");
  const [missionText, setMissionText] = useState("");
  const [kabinet, setKabinet] = useState(null);
  const [histories, setHistories] = useState([]);
  const [selectedHistory, setSelectedHistory] = useState(null);

  useEffect(() => {
    fetch("http://localhost/WEBSITEHIMPUNAN/backend/getvisimisi.php")
      .then((res) => res.json())
      .then((data) => {
        setVisionText(data.vision);
        setMissionText(data.mission);
      })
      .catch((err) => console.error("Gagal mengambil visi & misi:", err));

    fetch("http://localhost/WEBSITEHIMPUNAN/backend/get_kabinet.php")
      .then((res) => res.json())
      .then((data) => setKabinet(data))
      .catch((err) => console.error("Gagal mengambil kabinet:", err));

    fetch("http://localhost/WEBSITEHIMPUNAN/backend/get_history.php")
      .then((res) => res.json())
      .then((data) => setHistories(data))
      .catch((err) => console.error("Gagal mengambil sejarah:", err));
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      setDirection(activeSlide === 0 ? 1 : -1);
      setActiveSlide(activeSlide === 0 ? 1 : 0);
    }, 7000);
    return () => clearInterval(interval);
  }, [activeSlide]);

  const handleNext = () => {
    setDirection(1);
    setActiveSlide((prev) => (prev === 1 ? 0 : prev + 1));
  };

  const handlePrev = () => {
    setDirection(-1);
    setActiveSlide((prev) => (prev === 0 ? 1 : prev - 1));
  };

  const variants = {
    enter: (direction) => ({
      x: direction > 0 ? 200 : -200,
      opacity: 0,
    }),
    center: {
      x: 0,
      opacity: 1,
    },
    exit: (direction) => ({
      x: direction < 0 ? 200 : -200,
      opacity: 0,
    }),
  };

  return (
    <>
      <NavbarWhite />

{/* Visi & Misi */}
<section className="bg-white dark:bg-gray-900 pt-[120px] pb-24 px-6 md:px-24 min-h-screen transition-colors duration-300">
  <div className="text-center mb-12">
    <h2 className="text-4xl font-bold text-gray-900 dark:text-white">
      <span className="text-[#861B58]">Our </span>
      <span className="text-[#861B58]">
        {activeSlide === 0 ? "Vision" : "Mission"}
      </span>
    </h2>
    <p className="text-gray-600 dark:text-gray-300 mt-4 max-w-xl mx-auto text-base md:text-lg">
      Pelajari tujuan utama dan semangat kami sebagai HIMSI Universitas Pradita.
    </p>
  </div>

  <div className="max-w-3xl mx-auto relative">
    <div className="relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 p-8 md:p-10 rounded-3xl shadow-2xl transition-all duration-500 min-h-[320px] h-auto overflow-hidden">
      <AnimatePresence custom={direction} mode="wait">
        <motion.div
          key={activeSlide}
          custom={direction}
          variants={variants}
          initial="enter"
          animate="center"
          exit="exit"
          transition={{ duration: 0.6 }}
          className="absolute inset-0 px-2 text-lg md:text-xl text-gray-700 dark:text-gray-200 text-center whitespace-pre-line leading-relaxed font-medium flex items-center justify-center"
        >
          {activeSlide === 0 ? visionText : missionText}
        </motion.div>
      </AnimatePresence>
    </div>

    {/* Navigasi Slide */}
    <div className="flex justify-center gap-4 mt-8">
      {[0, 1].map((index) => (
        <button
          key={index}
          onClick={() => setActiveSlide(index)}
          className={`w-4 h-4 rounded-full transition-all duration-300 ${
            activeSlide === index
              ? "bg-[#861B58] scale-110"
              : "bg-gray-300 dark:bg-gray-600 hover:bg-[#861B58]/50"
          }`}
          aria-label={index === 0 ? "Vision" : "Mission"}
        ></button>
      ))}
    </div>
  </div>
</section>


{/* Sejarah HIMSI */}
<section className="bg-white px-6 md:px-24 pb-24">
  <div className="text-center mb-12">
    <h2 className="text-4xl font-bold text-gray-900">
      <span className="text-[#861B58]">Our </span>
      <span className="text-[#861B58]">History</span>
    </h2>
    <p className="text-gray-600 mt-4 max-w-xl mx-auto text-base md:text-lg">
      Mengenal lebih jauh perjalanan HIMSI dan kontribusinya dari masa ke masa.
    </p>
  </div>

  <div>
    {histories.length > 0 ? (
      <Swiper
        modules={[Autoplay]}
        autoplay={{ delay: 6000, disableOnInteraction: false }}
        loop={true}
        slidesPerView={1}
        spaceBetween={30}
      >
        {histories.map((item) => (
  <SwiperSlide key={item.id}>
  <div className="w-full max-w-[460px] mx-auto relative rounded-3xl shadow-xl bg-white hover:shadow-2xl transition duration-300 overflow-hidden border border-gray-200 group min-h-[460px] flex flex-col">
    <div className="relative h-[280px]">
      <img
        src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${item.foto_profil}`}
        alt={item.tahun_jabatan}
        className="w-full h-full object-cover rounded-t-3xl transition-transform duration-300 group-hover:scale-105"
      />
      <div className="absolute top-4 left-4 bg-[#861B58] text-white text-xs font-semibold px-4 py-1 rounded-full shadow">
        Periode {item.tahun_jabatan}
      </div>
      <div className="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
        <button
          onClick={() => setSelectedHistory(item)}
          className="bg-white text-[#861B58] font-semibold py-2 px-5 rounded-full shadow-md hover:bg-[#861B58] hover:text-white transition"
        >
          Lihat Detail
        </button>
      </div>
    </div>

    <div className="p-4 text-center">
      <h3 className="text-lg font-bold text-[#861B58] mb-1">
        HIMSI {item.tahun_jabatan}
      </h3>
      <div className="flex flex-wrap justify-center gap-2 text-sm mb-2">
        <span className="bg-[#fce9f1] text-[#861B58] px-3 py-1 rounded-full">
          Ketua: {item.nama_ketua}
        </span>
        <span className="bg-[#fce9f1] text-[#861B58] px-3 py-1 rounded-full">
          Wakil: {item.nama_wakil}
        </span>
      </div>
      <p className="text-gray-600 text-sm line-clamp-3">
        {item.deskripsi_singkat}
      </p>
    </div>
  </div>
</SwiperSlide>

        ))}
      </Swiper>
    ) : (
      <p className="text-center text-gray-500 w-full">Data sejarah belum tersedia.</p>
    )}
  </div>
  
 {selectedHistory && (
  <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
    {/* Tombol Close */}
    <button
      onClick={() => setSelectedHistory(null)}
      className="absolute top-4 right-4 z-50 text-white hover:text-gray-200 bg-[#861B58] hover:bg-[#a23873] p-2 rounded-full shadow-lg transition"
    >
      <X size={20} />
    </button>

{/* Tombol Navigasi Kiri */}
<div className="absolute top-1/2 left-2 -translate-y-1/2 z-40">
  <button
    onClick={() => {
      const currentIndex = histories.findIndex(h => h.id === selectedHistory.id);
      const prevIndex = (currentIndex - 1 + histories.length) % histories.length;
      setSelectedHistory(histories[prevIndex]);
    }}
    className="text-[#861B58] hover:text-[#6c1548] transition"
  >
    <svg className="w-7 h-7 sm:w-9 sm:h-9" fill="currentColor" viewBox="0 0 20 20">
      <path d="M12.293 15.707a1 1 0 010-1.414L8.414 10l3.879-4.293a1 1 0 00-1.414-1.414l-4.586 5a1 1 0 000 1.414l4.586 5a1 1 0 001.414 0z" />
    </svg>
  </button>
</div>

{/* Tombol Navigasi Kanan */}
<div className="absolute top-1/2 right-2 -translate-y-1/2 z-40">
  <button
    onClick={() => {
      const currentIndex = histories.findIndex(h => h.id === selectedHistory.id);
      const nextIndex = (currentIndex + 1) % histories.length;
      setSelectedHistory(histories[nextIndex]);
    }}
    className="text-[#861B58] hover:text-[#6c1548] transition"
  >
    <svg className="w-7 h-7 sm:w-9 sm:h-9" fill="currentColor" viewBox="0 0 20 20">
      <path d="M7.707 4.293a1 1 0 010 1.414L11.586 10l-3.879 4.293a1 1 0 001.414 1.414l4.586-5a1 1 0 000-1.414l-4.586-5a1 1 0 00-1.414 0z" />
    </svg>
  </button>
</div>


    {/* Konten Modal */}
    <div className="relative bg-white rounded-3xl shadow-2xl w-[95%] max-w-5xl p-6 md:p-10 overflow-y-auto max-h-[90vh] z-30 scrollbar-thin scrollbar-thumb-[#861B58]/60 scrollbar-track-gray-100">
      <div className="flex flex-col md:flex-row gap-8">
        <div className="flex-shrink-0 w-full md:w-1/2">
          <img
            src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${selectedHistory.foto_profil}`}
            alt={selectedHistory.tahun_jabatan}
            className="w-full rounded-2xl object-cover shadow-md"
          />
        </div>
        <div className="flex-1">
          <h2 className="text-3xl font-bold text-[#861B58] mb-3">
            HIMSI Periode {selectedHistory.tahun_jabatan}
          </h2>
          <p className="text-gray-700 mb-3 leading-relaxed">
            Dipimpin oleh <strong>{selectedHistory.nama_ketua}</strong> sebagai Ketua dan <strong>{selectedHistory.nama_wakil}</strong> sebagai Wakil Ketua.
          </p>
          <p className="text-gray-700 mb-6 leading-relaxed">{selectedHistory.deskripsi}</p>
          <h3 className="font-semibold text-xl text-gray-800 mb-4">
            Kegiatan yang Telah Dilakukan
          </h3>
          <div className="space-y-3 max-h-52 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-[#861B58]/60 scrollbar-track-gray-100">
            {selectedHistory.daftar_kegiatan.split("\n").map((kegiatan, idx) => (
              <div
                key={idx}
                className="flex items-start gap-3 p-3 rounded-xl bg-[#F9F9F9] shadow-sm border border-gray-200 hover:bg-[#f3e9ef] transition"
              >
                <div className="mt-1">
                  <svg
                    className="w-4 h-4 text-[#861B58]"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z" />
                  </svg>
                </div>
                <p className="text-sm text-gray-700">{kegiatan}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  </div>
)}


</section>

      {/* Kabinet Saat Ini */}
      <section className="bg-white px-6 md:px-24 pb-24 pt-12 text-center">
        <div className="mb-10">
          <h2 className="text-4xl font-bold text-gray-900">
            <span className="text-[#861B58]">Kabinet </span>
            <span className="text-[#861B58]">yang Sedang Berjalan</span>
          </h2>
          <p className="text-gray-600 mt-4 max-w-xl mx-auto text-base md:text-lg">
            Simbol dan filosofi dari kepengurusan HIMSI Universitas Pradita saat ini.
          </p>
        </div>

        {kabinet?.logo ? (
          <motion.img
            src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${kabinet.logo}`}
            alt={kabinet.nama_kabinet}
            className="w-[300px] mb-6 mx-auto"
            initial={{ opacity: 0, scale: 0.9 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
          />
        ) : (
          <p className="text-sm text-gray-500">Logo belum dimuat...</p>
        )}

        <motion.p
          className="text-xl md:text-2xl font-semibold"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.6 }}
          viewport={{ once: true }}
        >
          <span className="text-[#1E64C8]">Kabinet</span>{" "}
          <span className="text-[#800040] font-bold">
            #{kabinet ? kabinet.nama_kabinet : "Loading..."}
          </span>
        </motion.p>

        <motion.p
          className="mt-4 text-base md:text-lg text-gray-700 max-w-3xl mx-auto"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.8 }}
          viewport={{ once: true }}
        >
          {kabinet ? kabinet.deskripsi : "Memuat deskripsi kabinet..."}
        </motion.p>

        <motion.button
          onClick={() => navigate("/divisi")}
          className="mt-8 px-12 py-4 w-[320px] text-[#660033] text-base md:text-lg font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none whitespace-nowrap"
          whileHover={{ scale: 1.05 }}
          whileTap={{ scale: 0.98 }}
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 1.2, delay: 0.6 }}
          viewport={{ once: true }}
        >
          Kenali Kepengurusan
        </motion.button>
      </section>

      <Footer />
    </>
  );
};

export default VisionMissionPage;
