import { AnimatePresence, motion } from "framer-motion";
import { ArrowLeft, ArrowRight } from "lucide-react";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import himsiImg from "../assets/himsi202324.png";
import Footer from "../pageSection/footer.jsx";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";

const VisionMissionPage = () => {
  const navigate = useNavigate();

  const [activeSlide, setActiveSlide] = useState(0);
  const [direction, setDirection] = useState(1);
  const [visionText, setVisionText] = useState("");
  const [missionText, setMissionText] = useState("");
  const [kabinet, setKabinet] = useState(null);

  useEffect(() => {
    fetch("http://localhost/WEBSITEHIMPUNAN/backend/getvisimisi.php")
      .then((res) => res.json())
      .then((data) => {
        setVisionText(data.vision);
        setMissionText(data.mission);
      })
      .catch((err) => {
        console.error("Gagal mengambil visi dan misi:", err);
      });

    fetch("http://localhost/WEBSITEHIMPUNAN/backend/get_kabinet.php")
      .then((res) => res.json())
      .then((data) => {
        setKabinet(data);
      })
      .catch((err) => {
        console.error("Gagal mengambil data kabinet:", err);
      });
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
      <section className="bg-white pt-[120px] pb-24 px-6 md:px-24 min-h-screen">
        <div className="text-center mb-12">
          <h2 className="text-4xl font-bold text-gray-900">
            <span className="text-[#861B58]">Our </span>
            <span className="text-[#861B58]">
              {activeSlide === 0 ? "Vision" : "Mission"}
            </span>
          </h2>
          <p className="text-gray-600 mt-4 max-w-xl mx-auto text-base md:text-lg">
            Pelajari tujuan utama dan semangat kami sebagai HIMSI Universitas Pradita.
          </p>
        </div>

        <div className="max-w-3xl mx-auto relative">
          <div className="bg-white border border-gray-300 p-8 md:p-10 rounded-3xl shadow-xl transition-all duration-500">
            <AnimatePresence custom={direction} mode="wait">
              <motion.div
                key={activeSlide}
                custom={direction}
                variants={variants}
                initial="enter"
                animate="center"
                exit="exit"
                transition={{ duration: 0.6 }}
                className="text-lg md:text-xl text-gray-700 text-center whitespace-pre-line leading-relaxed font-medium"
              >
                {activeSlide === 0 ? visionText : missionText}
              </motion.div>
            </AnimatePresence>
          </div>

          <div className="flex justify-center gap-6 mt-10">
            <button
              onClick={handlePrev}
              className="bg-[#861B58] hover:bg-[#6e1749] text-white p-3 rounded-full shadow-lg transition transform hover:scale-110"
              aria-label="Previous"
            >
              <ArrowLeft size={22} />
            </button>
            <button
              onClick={handleNext}
              className="bg-[#861B58] hover:bg-[#6e1749] text-white p-3 rounded-full shadow-lg transition transform hover:scale-110"
              aria-label="Next"
            >
              <ArrowRight size={22} />
            </button>
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

        <div className="max-w-5xl mx-auto rounded-3xl shadow-2xl overflow-hidden relative group">
          <img
            src={himsiImg}
            alt="HIMSI 2023/2024"
            className="w-full h-[400px] object-cover brightness-75 transition duration-500 group-hover:brightness-90"
          />
          <div className="absolute bottom-0 w-full h-full bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white p-6 flex flex-col justify-end">
            <h3 className="text-2xl md:text-3xl font-semibold">HIMSI 2023/2024</h3>
            <p className="text-sm md:text-base mt-1 text-gray-200">
              Kabinet yang diketuai oleh <strong>Chelyne</strong>, dan <strong>Steven Dermawan</strong> sebagai wakil ketua.
            </p>
          </div>
        </div>
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
