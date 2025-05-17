import axios from "axios";
import { motion } from "framer-motion";
import { useEffect, useState } from "react";
import CountUp from "react-countup";
import { useNavigate } from "react-router-dom";

export default function AchievementStats() {
  const [kabinet, setKabinet] = useState(null);
  const [achievements, setAchievements] = useState([]);
  const [informasi, setInformasi] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost/WEBSITEHIMPUNAN/backend/get_kabinet.php")
      .then((res) => setKabinet(res.data))
      .catch((err) => console.error("Gagal fetch data kabinet:", err));

    axios
      .get("http://localhost/WEBSITEHIMPUNAN/backend/get_achievement.php")
      .then((res) => setAchievements(res.data))
      .catch((err) => console.error("Gagal fetch pencapaian:", err));

    axios
      .get("http://localhost/WEBSITEHIMPUNAN/backend/get_artikell.php")
      .then((res) => setInformasi(res.data.slice(0, 4))) // ambil 4 informasi teratas
      .catch((err) => console.error("Gagal fetch informasi:", err));
  }, []);

  return (
    <>
      {/* Section Pencapaian */}
      <motion.div
        className="px-[8%] py-16 flex justify-center items-center bg-white"
        initial={{ opacity: 0, y: 100 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true, amount: 0.2 }}
        transition={{ duration: 1 }}
      >
        <div className="flex flex-col items-center w-full text-center">
          <div className="w-full grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
            {achievements.map((stat, index) => (
              <motion.div
                key={index}
                className="flex flex-col items-center"
                initial={{ opacity: 0, y: 40 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 1, delay: index * 0.2 }}
              >
                <p className="text-3xl font-bold text-[#1E64C8]">
                  <CountUp
                    end={parseFloat(stat.angka)}
                    duration={8}
                    suffix={
                      stat.pencapaian === "Program Kerja Terlaksana"
                        ? "+"
                        : stat.pencapaian === "Impact ke Masyarakat"
                        ? "%"
                        : ""
                    }
                  />
                </p>
                <p className="text-base text-gray-700 mt-2">
                  {stat.pencapaian}
                </p>
              </motion.div>
            ))}
          </div>

          {/* Logo Kabinet */}
          {kabinet?.logo ? (
            <motion.img
              src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${kabinet.logo}`}
              alt={kabinet.nama_kabinet}
              className="w-[300px] mb-6"
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
            className="mt-4 text-base md:text-lg text-gray-700 max-w-3xl"
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
        </div>
      </motion.div>

      {/* Informasi Himpunan */}
      <motion.div
        className="bg-white py-20 px-[8%]"
        initial={{ opacity: 0 }}
        whileInView={{ opacity: 1 }}
        viewport={{ once: true, amount: 0.3 }}
        transition={{ duration: 1 }}
      >
        <h2 className="text-3xl md:text-4xl font-bold text-center">
          <span className="text-[#800040]">Informasi </span>
          <span className="text-[#800040]">Himpunan</span>
        </h2>
        <p className="text-lg text-gray-700 mt-3 text-center mb-6">
          Informasi Terkini Seputar Himpunan Mahasiswa
        </p>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
          {informasi.map((item, index) => (
            <motion.div
              key={index}
              className="group bg-white rounded-xl shadow-lg overflow-hidden flex flex-col cursor-pointer transition-transform transform hover:scale-[1.03] hover:shadow-xl relative"
              onClick={() => navigate(`/informasi/${item.slug}`)}
              whileHover={{ y: -5 }}
              transition={{ duration: 0.3 }}
            >
              <div className="p-5 flex-grow flex flex-col">
                <h3 className="text-xl font-bold mb-2 text-[#7A2048]">
                  {item.judul}
                </h3>
                <div
                  className="text-gray-700 text-sm flex-grow"
                  dangerouslySetInnerHTML={{
                    __html:
                      item.informasi.length > 120
                        ? item.informasi.substring(0, 120) + "..."
                        : item.informasi,
                  }}
                />
                <p className="text-xs text-gray-500 mt-2">
                  {new Date(item.tanggal_input).toLocaleDateString("id-ID")}
                </p>
              </div>
              <div className="absolute bottom-3 right-3 text-[#800040] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                ➜
              </div>
            </motion.div>
          ))}
        </div>

        <div className="flex justify-center mt-12">
          <button
            onClick={() => navigate("/informasi")}
            className="mt-8 px-12 py-4 w-[250px] md:w-[300px] text-[#660033] text-lg md:text-xl font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none"
          >
            Lihat Semua Informasi
          </button>
        </div>
      </motion.div>
    </>
  );
}
