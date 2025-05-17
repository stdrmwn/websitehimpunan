// ContactPage.jsx
import emailjs from "emailjs-com";
import { AnimatePresence, motion } from "framer-motion";
import { useEffect, useRef, useState } from "react";
import {
  FaArrowLeft,
  FaArrowRight,
  FaEnvelope,
  FaInstagram,
  FaLinkedin,
  FaRegCommentDots,
  FaUser,
  FaWhatsapp,
  FaYoutube,
} from "react-icons/fa";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";
import Footer from "../pageSection/footer.jsx";

// Import logo media partner
import AseanLogo from "../assets/aseandata.png";
import DididikLogo from "../assets/dididik.png";
import HIMSIUMNLogo from "../assets/himsiumn.jpg";
import InfoLombaLogo from "../assets/infolomba.png";
import KreenLogo from "../assets/kreen.jpg";
import LombasmaLogo from "../assets/lombasma.png";
import MaxyLogo from "../assets/maxy.png";
import PlanetLombaLogo from "../assets/planetlomba.png";

const mediaPartners = [
  { logo: HIMSIUMNLogo, name: "HIMSI UMN" },
  { logo: LombasmaLogo, name: "Lombasma" },
  { logo: PlanetLombaLogo, name: "PlanetLomba" },
  { logo: MaxyLogo, name: "Maxy Academy" },
  { logo: InfoLombaLogo, name: "InfoLomba" },
      { logo: KreenLogo, name: "Kreen Indonesia" },
          { logo: DididikLogo, name: "Dididik Indonesia" },
                  { logo: AseanLogo, name: "Asean Data Science" },
];

const ContactPage = () => {
  const form = useRef();
  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 4;
  const totalPages = Math.ceil(mediaPartners.length / itemsPerPage);
  const [direction, setDirection] = useState(0);
  const autoSlideRef = useRef(null);

  const sendEmail = (e) => {
    e.preventDefault();
    emailjs
      .sendForm("service_xxx", "template_xxx", form.current, "public_xxx")
      .then(() => {
        alert("Pesan berhasil dikirim ke HIMSI Pradita!");
        e.target.reset();
      }, () => {
        alert("Gagal mengirim. Coba lagi ya!");
      });
  };

  const handlePrev = () => {
    setDirection(-1);
    setCurrentPage((prev) => (prev > 0 ? prev - 1 : totalPages - 1));
    resetAutoSlide();
  };

  const handleNext = () => {
    setDirection(1);
    setCurrentPage((prev) => (prev + 1) % totalPages);
    resetAutoSlide();
  };

  const paginatedPartners = mediaPartners.slice(
    currentPage * itemsPerPage,
    currentPage * itemsPerPage + itemsPerPage
  );

  // Auto slide every 5 seconds
  useEffect(() => {
    startAutoSlide();
    return () => clearInterval(autoSlideRef.current);
  }, [currentPage]);

  const startAutoSlide = () => {
    clearInterval(autoSlideRef.current);
    autoSlideRef.current = setInterval(() => {
      setDirection(1);
      setCurrentPage((prev) => (prev + 1) % totalPages);
    }, 5000); // ganti slide setiap 5 detik
  };

  const resetAutoSlide = () => {
    clearInterval(autoSlideRef.current);
    startAutoSlide();
  };

  return (
    <>
      <NavbarWhite />
      <div className="bg-white px-4 md:px-20 py-12 pt-28 min-h-screen overflow-x-hidden">
        {/* Title */}
        <motion.div
          className="text-center mb-12"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
        >
          <h1 className="text-5xl font-bold tracking-tight text-[#861B58]">Contact Us</h1>
          <p className="text-lg mt-4 text-gray-700">
            Hubungi kami untuk kolaborasi, pertanyaan, atau informasi lainnya melalui platform di bawah ini.
          </p>
        </motion.div>

        {/* Sosial Media */}
        <motion.div
          className="bg-[#800040] rounded-2xl p-6 flex flex-wrap justify-center gap-4 text-white shadow-lg"
          initial={{ opacity: 0, scale: 0.95 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.6, delay: 0.2 }}
        >
          {[{
            icon: <FaInstagram className="text-pink-600 text-2xl" />,
            text: "@himsi.pradita",
            link: "https://www.instagram.com/himsi.pradita",
          }, {
            icon: <FaLinkedin className="text-blue-700 text-2xl" />,
            text: "@himsi.pradita",
            link: "https://www.linkedin.com/in/himsi-pradita",
          }, {
            icon: <FaWhatsapp className="text-green-500 text-2xl" />,
            text: "@himsi.pradita",
            link: "https://wa.me/6285933235262?text=Hai,%20saya%20mau%20bertanya%20terkait%20himpunan.",
          }, {
            icon: <FaYoutube className="text-red-600 text-2xl" />,
            text: "@himsi.pradita",
            link: "https://youtube.com/@himsipradita?si=JpvMC_Dth5PyD7zY",
          }].map((item, index) => (
            <a
              key={index}
              href={item.link}
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-3 bg-white text-black px-5 py-3 rounded-lg shadow-md transition transform hover:scale-105 hover:shadow-xl"
            >
              {item.icon}
              <span className="font-semibold">{item.text}</span>
            </a>
          ))}
        </motion.div>

        {/* Media Partner */}
        <motion.div
          className="mt-20 text-center max-w-6xl mx-auto"
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.25 }}
        >
          <h2 className="text-3xl font-bold text-[#861B58] mb-4">Media Partner Kami</h2>
          <p className="text-lg text-gray-700 mb-6">
            HIMSI Pradita telah menjalin kerja sama dengan berbagai media partner, tidak hanya dalam mendukung publikasi dan promosi kegiatan kami, tetapi juga dalam penyelenggaraan berbagai kegiatan secara langsung.
          </p>

          <div className="relative">
            <div className="flex justify-between items-center mb-4 px-4">
              <button onClick={handlePrev} className="text-[#861B58] p-2 text-2xl">
                <FaArrowLeft />
              </button>
              <button onClick={handleNext} className="text-[#861B58] p-2 text-2xl">
                <FaArrowRight />
              </button>
            </div>

            <div className="relative overflow-hidden min-h-[200px] px-2">
              <AnimatePresence mode="wait">
                <motion.div
                  key={currentPage}
                  initial={{ x: direction > 0 ? 300 : -300, opacity: 0 }}
                  animate={{ x: 0, opacity: 1 }}
                  exit={{ x: direction > 0 ? -300 : 300, opacity: 0 }}
                  transition={{ duration: 0.5 }}
                  className="grid grid-cols-2 md:grid-cols-4 gap-4 w-full justify-center"
                >
                  {paginatedPartners.map((item, index) => (
                    <div
                      key={index}
                      className="flex flex-col items-center bg-white shadow-md rounded-lg p-4"
                    >
                      <img src={item.logo} alt={item.name} className="h-16 object-contain" />
                      <span className="mt-2 text-sm text-gray-600">{item.name}</span>
                    </div>
                  ))}
                </motion.div>
              </AnimatePresence>
            </div>
          </div>

          <p className="mt-6 text-gray-700 px-4">
            Kami terbuka untuk kolaborasi baru demi memperluas dampak kegiatan HIMSI Pradita. Jika kamu tertarik untuk menjadi media partner kami, silakan hubungi melalui formulir di bawah ini.
          </p>
        </motion.div>

        {/* Formulir */}
{/* Formulir */}
<motion.div
  className="mt-20 text-center"
  initial={{ opacity: 0, y: 30 }}
  animate={{ opacity: 1, y: 0 }}
  transition={{ duration: 0.6, delay: 0.3 }}
>
  <h2 className="text-3xl font-bold text-[#861B58] mb-4">Kirim Pesan Langsung</h2>
  <p className="mt-2 text-lg text-gray-600">Isi formulir di bawah untuk menghubungi kami via email</p>
</motion.div>

<motion.form
  ref={form}
  onSubmit={sendEmail}
  className="max-w-2xl mx-auto mt-10 space-y-6 bg-white p-6 rounded-xl shadow-lg"
  initial={{ opacity: 0 }}
  animate={{ opacity: 1 }}
  transition={{ duration: 0.6, delay: 0.5 }}
>
  <div className="relative">
    <FaUser className="absolute top-4 left-3 text-gray-400" />
    <input
      type="text"
      name="user_name"
      required
      placeholder="Nama"
      className="w-full pl-10 border border-gray-200 p-3 rounded-md outline-none transition duration-200 ease-in-out focus:ring-2 focus:ring-[#861B58] focus:border-[#861B58]"
    />
  </div>
  <div className="relative">
    <FaEnvelope className="absolute top-4 left-3 text-gray-400" />
    <input
      type="email"
      name="user_email"
      required
      placeholder="Email"
      className="w-full pl-10 border border-gray-200 p-3 rounded-md outline-none transition duration-200 ease-in-out focus:ring-2 focus:ring-[#861B58] focus:border-[#861B58]"
    />
  </div>
  <div className="relative">
    <FaRegCommentDots className="absolute top-4 left-3 text-gray-400" />
    <textarea
      name="message"
      rows="5"
      required
      placeholder="Keperluan / Pertanyaan"
      className="w-full pl-10 border border-gray-200 p-3 rounded-md outline-none transition duration-200 ease-in-out focus:ring-2 focus:ring-[#861B58] focus:border-[#861B58]"
    />
  </div>
  <div className="text-center">
    <button
      type="submit"
      className="bg-[#861B58] text-white px-8 py-3 rounded-lg hover:bg-[#861B58] transition shadow-md hover:shadow-lg"
    >
      Kirim Pesan
    </button>
  </div>
</motion.form>

      </div>
      <Footer />
    </>
  );
};

export default ContactPage;
