import { motion } from "framer-motion";
import { ChevronDown, ChevronUp } from "lucide-react";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

import AseanLogo from "../assets/aseandata.png";
import DididikLogo from "../assets/dididik.png";
import HIMSIUMNLogo from "../assets/himsiumn.jpg";
import InfoLombaLogo from "../assets/infolomba.png";
import KreenLogo from "../assets/kreen.jpg";
import LombasmaLogo from "../assets/lombasma.png";
import MaxyLogo from "../assets/maxy.png";
import PlanetLombaLogo from "../assets/planetlomba.png";

const faqData = [
  {
    question: "Berapa lama masa jabatan pengurus HIMSI?",
    answer: "Masa jabatan pengurus HIMSI adalah selama satu tahun kepengurusan.",
  },
  {
    question: "Apa saja keuntungan menjadi pengurus HIMSI?",
    answer:
      "Keuntungan menjadi pengurus HIMSI antara lain mendapatkan pengalaman organisasi, memperluas relasi, dan pengembangan soft skill.",
  },
  {
    question: "Apa saja syarat yang perlu dipenuhi untuk mendaftar kepengurusan HIMSI?",
    answer:
      "Syaratnya meliputi mahasiswa aktif, memiliki komitmen, dan lulus seleksi administrasi serta wawancara.",
  },
  {
    question: "Apa diperkenankan jika ingin ganti divisi di tengah periode kepengurusan?",
    answer:
      "Pergantian divisi bisa dilakukan dengan persetujuan pengurus inti dan alasan yang kuat.",
  },
  {
    question:
      "Apakah diperbolehkan menjadi pengurus di organisasi lain ketika sudah diterima di kepengurusan HIMSI?",
    answer:
      "Diperbolehkan selama tidak mengganggu komitmen dan tanggung jawab di HIMSI.",
  },
];

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

export default function Faq() {
  const [openIndex, setOpenIndex] = useState(null);
  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 4;
  const navigate = useNavigate();

  const totalPages = Math.ceil(mediaPartners.length / itemsPerPage);

  const handleNext = () => {
    if (currentPage < totalPages - 1) setCurrentPage((prev) => prev + 1);
  };

  const handlePrev = () => {
    if (currentPage > 0) setCurrentPage((prev) => prev - 1);
  };

  const toggleFAQ = (index) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  const paginatedPartners = mediaPartners.slice(
    currentPage * itemsPerPage,
    (currentPage + 1) * itemsPerPage
  );

return (
  <section className="px-6 md:px-24 py-16 bg-white">
    {/* Media Partner Section */}
    <motion.div
      className="text-center max-w-6xl mx-auto mb-24"
      initial={{ opacity: 0, y: 30 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.6, delay: 0.25 }}
    >
      <h2 className="text-3xl font-bold text-[#861B58] mb-4">Media Partner Kami</h2>
      <p className="text-lg text-gray-700 mb-6">
        HIMSI Pradita telah menjalin kerja sama dengan berbagai media partner dalam mendukung publikasi dan promosi kegiatan kami.
      </p>

      <div className="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
        {mediaPartners.slice(0, 8).map((item, index) => (
          <div
            key={index}
            className="flex flex-col items-center bg-white shadow-md rounded-lg p-4"
          >
            <img src={item.logo} alt={item.name} className="h-16 object-contain" />
            <span className="mt-2 text-sm text-gray-600">{item.name}</span>
          </div>
        ))}
      </div>

      <p className="mt-6 text-gray-700">
        Kami terbuka untuk kolaborasi baru demi memperluas dampak kegiatan HIMSI Pradita. Jika kamu tertarik untuk menjadi media partner kami, silakan hubungi melalui formulir di bawah ini.
      </p>

      <button
        onClick={() => navigate("/contact")}
        className="mt-6 px-12 py-3 w-[250px] text-[#660033] text-base md:text-lg font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none"
      >
        Selengkapnya
      </button>
    </motion.div>

    {/* FAQ Section */}
    <div className="text-center flex flex-col items-center justify-center mt-10 mb-6">
      <h2 className="text-3xl md:text-4xl font-extrabold text-[#7A1E52]">
        Frequently Asked <span className="text-[#7A1E52]">Questions</span>
      </h2>
      <p className="text-lg text-gray-700 mt-3 max-w-xl text-center">
        Temukan jawaban atas pertanyaan umum seputar HIMSI di sini.
      </p>
    </div>

    <div className="space-y-5 mt-10">
      {faqData.slice(0, 3).map((faq, index) => (
        <div
          key={index}
          className={`transition-all duration-300 ease-in-out p-5 rounded-2xl border shadow-md ${
            openIndex === index
              ? "bg-[#FFF1F6] border-[#7A1E52]"
              : "bg-white hover:bg-[#F9FAFB] border-gray-200"
          }`}
        >
          <button
            onClick={() => toggleFAQ(index)}
            className="w-full flex justify-between items-center text-left"
          >
            <span
              className={`text-base md:text-lg font-semibold transition-colors ${
                openIndex === index ? "text-[#7A1E52]" : "text-gray-800"
              }`}
            >
              {faq.question}
            </span>
            <span
              className={`transition-transform ${
                openIndex === index ? "rotate-180 text-[#7A1E52]" : "text-gray-500"
              }`}
            >
              {openIndex === index ? <ChevronUp size={22} /> : <ChevronDown size={22} />}
            </span>
          </button>
          <div
            className={`transition-all duration-500 ease-in-out overflow-hidden ${
              openIndex === index ? "max-h-40 mt-3 opacity-100" : "max-h-0 opacity-0"
            }`}
          >
            <p className="text-gray-700 text-sm md:text-base leading-relaxed">
              {faq.answer}
            </p>
          </div>
        </div>
      ))}
    </div>

    <div className="flex justify-center mt-10">
      <button
        onClick={() => navigate("/Faq")}
        className="mt-8 px-12 py-4 w-[250px] md:w-[300px] text-[#660033] text-base md:text-lg font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none whitespace-nowrap"
      >
        Lihat Selengkapnya
      </button>
    </div>
  </section>
);

}
