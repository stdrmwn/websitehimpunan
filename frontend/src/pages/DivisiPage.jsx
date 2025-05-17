import { motion } from "framer-motion";
import { useEffect, useState } from "react";
import Footer from "../pageSection/footer.jsx";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";

// Fungsi slug
function slugify(text) {
  return text
    .toString()
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-")
    .replace(/^-+/, "")
    .replace(/-+$/, "");
}

export default function DivisiPage() {
  const [divisiData, setDivisiData] = useState([]);
  const [selectedIndex, setSelectedIndex] = useState(null);

  useEffect(() => {
    fetch("http://localhost/WEBSITEHIMPUNAN/backend/divisi.php")
      .then((res) => res.json())
      .then((data) => {
        const formatted = data.map((divisi) => ({
          ...divisi,
          programs: divisi.program_kerja
            ? divisi.program_kerja.split(/\r\n|\n|\r/).map((item) => item.trim())
            : [],
        }));
        setDivisiData(formatted);
      })
      .catch((error) => {
        console.error("Gagal mengambil data divisi:", error);
      });
  }, []);

  useEffect(() => {
    if (divisiData.length > 0) {
      const hash = window.location.hash;
      if (hash) {
        const target = document.querySelector(hash);
        if (target) {
          setTimeout(() => {
            target.scrollIntoView({ behavior: "smooth" });
          }, 200);
        }
      }
    }
  }, [divisiData]);

  const openModal = (index) => setSelectedIndex(index);
  const closeModal = () => setSelectedIndex(null);

  const nextDivisi = () =>
    setSelectedIndex((prev) => (prev + 1) % divisiData.length);
  const prevDivisi = () =>
    setSelectedIndex((prev) =>
      prev === 0 ? divisiData.length - 1 : prev - 1
    );

  return (
    <div className="bg-white text-[#3C2A21] font-sans min-h-screen">
      <NavbarWhite />

      <section className="pt-28 px-4 text-center">
        <motion.h2
          className="text-sm tracking-wide uppercase text-gray-500"
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
        >
          Divisi Kami
        </motion.h2>
        <motion.h1
          className="text-3xl md:text-4xl font-extrabold text-[#8E3E63] mt-2"
          initial={{ opacity: 0, y: -10 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.2, duration: 0.6 }}
        >
          Struktur Divisi Himpunan Mahasiswa Sistem Informasi
        </motion.h1>
      </section>

      <div className="mt-16 space-y-28 px-4 md:px-16">
        {divisiData.map((divisi, index) => {
          const sectionId = slugify(divisi.nama_divisi);
          return (
            <motion.div
              key={index}
              id={sectionId}
              className="bg-white shadow-xl rounded-3xl p-8 md:p-12 text-center md:text-left"
              initial={{ opacity: 0, y: 50 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.8, delay: index * 0.2 }}
            >
              <div className="grid md:grid-cols-2 gap-10 items-center">
                <motion.div
                  whileHover={{ scale: 1.02 }}
                  transition={{ duration: 0.3 }}
                  className="p-2 rounded-2xl cursor-pointer"
                  onClick={() => openModal(index)}
                >
                  <img
                    src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${divisi.foto}`}
                    alt={divisi.nama_divisi}
                    className="rounded-2xl w-full h-64 object-cover shadow-lg"
                  />
                </motion.div>

                <div>
                  <h3 className="text-2xl md:text-3xl font-bold mb-4 text-[#8E3E63]">
                    {divisi.nama_divisi}
                  </h3>
                  <p className="text-base text-gray-700 mb-6">{divisi.deskripsi}</p>

                  <h4 className="font-semibold text-sm text-[#8E3E63] mb-3 uppercase tracking-wide">
                    Program Kerja
                  </h4>
                  <div className="flex flex-wrap gap-3 justify-center md:justify-start">
                    {divisi.programs.map((program, i) => (
                      <motion.span
                        key={i}
                        className="px-4 py-2 bg-[#FAFAFA] border border-[#ddd] rounded-full text-sm text-gray-800 hover:bg-[#8E3E63] hover:text-white transition duration-300 shadow-sm"
                        whileHover={{ scale: 1.05 }}
                      >
                        {program}
                      </motion.span>
                    ))}
                  </div>
                </div>
              </div>
            </motion.div>
          );
        })}
      </div>

      {/* Modal */}
      {selectedIndex !== null && (
        <div className="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center">
          <div className="relative bg-white rounded-2xl shadow-2xl p-6 md:p-10 max-w-3xl w-[90%] text-center">
            <button
              onClick={closeModal}
              className="absolute top-4 right-5 text-gray-500 hover:text-red-600 text-xl font-bold"
            >
              &times;
            </button>

            <img
              src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${divisiData[selectedIndex].foto}`}
              alt={divisiData[selectedIndex].nama_divisi}
              className="w-full h-64 object-cover rounded-xl mb-5"
            />

            <h2 className="text-2xl font-bold text-[#8E3E63] mb-2">
              {divisiData[selectedIndex].nama_divisi}
            </h2>
            <p className="text-gray-700 mb-6">{divisiData[selectedIndex].deskripsi}</p>

            <div className="flex justify-between mt-4">
              <button
                onClick={prevDivisi}
                className="text-[#8E3E63] hover:text-white hover:bg-[#8E3E63] border border-[#8E3E63] px-4 py-2 rounded-lg transition duration-300"
              >
                &#8592; Sebelumnya
              </button>
              <button
                onClick={nextDivisi}
                className="text-[#8E3E63] hover:text-white hover:bg-[#8E3E63] border border-[#8E3E63] px-4 py-2 rounded-lg transition duration-300"
              >
                Selanjutnya &#8594;
              </button>
            </div>
          </div>
        </div>
      )}

      <div className="mt-24">
        <Footer />
      </div>
    </div>
  );
}
