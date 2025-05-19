import axios from "axios";
import { motion } from "framer-motion";
import { useEffect, useState } from "react";
import CountUp from "react-countup";
import { useNavigate } from "react-router-dom";

export default function AchievementStats() {
  const [kabinet, setKabinet] = useState(null);
  const [achievements, setAchievements] = useState([]);
  const [informasi, setInformasi] = useState([]);
  const [eventList, setEventList] = useState([]);
  const [modalImage, setModalImage] = useState(null);
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
      .then((res) => setInformasi(res.data.slice(0, 6)))
      .catch((err) => console.error("Gagal fetch informasi:", err));

    axios
      .get("http://localhost/WEBSITEHIMPUNAN/backend/get_eventshimpunan.php")
      .then((res) => setEventList(res.data.slice(0, 3)))
      .catch((err) => console.error("Gagal fetch event:", err));
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

          <div className="text-center mb-12">
  <h2 className="text-3xl md:text-4xl font-bold text-[#800040]">
    Kabinet Saat Ini
  </h2>
  <p className="text-lg text-gray-700 mt-3 mb-6">
    Simbol dan filosofi dari kepengurusan HIMSI Universitas Pradita saat ini.
  </p>
</div>

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
            className="mt-8 px-12 py-4 w-[320px] text-[#660033] text-base md:text-lg font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none"
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

{/* Section Event Himpunan */}
<motion.div
  className="bg-white py-20 px-[8%]"
  initial={{ opacity: 0 }}
  whileInView={{ opacity: 1 }}
  viewport={{ once: true, amount: 0.3 }}
  transition={{ duration: 1 }}
>
  <h2 className="text-3xl md:text-4xl font-bold text-center text-[#800040]">
    Event Himpunan
  </h2>
  <p className="text-lg text-gray-600 mt-3 text-center mb-10 max-w-2xl mx-auto">
    Ikuti beragam kegiatan menarik yang diselenggarakan oleh Himpunan Mahasiswa kami.
  </p>

  <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 max-w-7xl mx-auto">
    {eventList.map((item, index) => (
      <motion.div
        key={index}
        className="group bg-white rounded-2xl shadow-md hover:shadow-2xl border border-gray-200 hover:border-[#800040] transition-all duration-300 overflow-hidden flex flex-col relative cursor-pointer"
        whileHover={{ y: -4 }}
        transition={{ duration: 0.3 }}
      >
        <div className="relative">
          {item.foto_event && (
            <div
              className="relative group"
              onClick={() =>
                setModalImage(`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${item.foto_event}`)
              }
            >
              <img
                src={`http://localhost/WEBSITEHIMPUNAN/backend/uploads/${item.foto_event}`}
                alt={item.nama_event}
                className="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white font-semibold text-sm">
                Lihat Detail
              </div>
            </div>
          )}
          <div className="absolute top-3 right-3 bg-[#800040] text-white text-xs px-3 py-1 rounded-full flex items-center gap-1 shadow-md">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-4 w-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            {new Date(item.tanggal_event).toLocaleDateString("id-ID", {
              day: "numeric",
              month: "short",
              year: "numeric",
            })}
          </div>
        </div>

        <div className="p-5 flex flex-col flex-grow" onClick={() => navigate(`/events/${item.slug}`)}>
          <h3 className="text-lg md:text-xl font-semibold text-[#7A2048] mb-2">
            {item.nama_event}
          </h3>
          <div
            className="text-gray-700 text-sm mb-4 flex-grow"
            dangerouslySetInnerHTML={{
              __html:
                item.deskripsi_event.length > 120
                  ? item.deskripsi_event.substring(0, 120) + "..."
                  : item.deskripsi_event,
            }}
          />
          <div className="mt-auto flex justify-end">
            <span className="text-[#800040] text-sm font-semibold group-hover:underline">
              Selengkapnya →
            </span>
          </div>
        </div>
      </motion.div>
    ))}
  </div>

  {/* Modal Foto Detail */}
  {modalImage && (
    <div
      className="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
      onClick={() => setModalImage(null)}
    >
      <div
        className="relative max-w-full max-h-screen"
        onClick={(e) => e.stopPropagation()} // supaya klik di dalam modal gak close
      >
        {/* Tombol Close */}
        <button
          onClick={() => setModalImage(null)}
          className="absolute top-3 right-3 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-80 transition"
          aria-label="Close modal"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            strokeWidth={2}
          >
            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <img
          src={modalImage}
          alt="Detail Event"
          className="max-w-full max-h-screen object-contain rounded-lg"
        />
      </div>
    </div>
  )}

        <div className="flex justify-center mt-12">
          <button
            onClick={() => navigate("/eventshimpunan")}
            className="mt-8 px-12 py-4 w-[250px] md:w-[300px] text-[#660033] text-lg md:text-xl font-semibold border-2 border-[#660033] bg-transparent hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none"
          >
            Lihat Semua Event
          </button>
        </div>
      </motion.div>

 {/* Informasi Himpunan */}
<motion.div
  className="bg-gradient-to-b from-white to-gray-50 py-20 px-[8%]"
  initial={{ opacity: 0 }}
  whileInView={{ opacity: 1 }}
  viewport={{ once: true, amount: 0.3 }}
  transition={{ duration: 1 }}
>
  <h2 className="text-3xl md:text-4xl font-extrabold text-center text-[#800040] tracking-tight">
    Informasi Himpunan
  </h2>
  <p className="text-lg text-gray-600 mt-3 text-center mb-10 max-w-2xl mx-auto">
    Dapatkan informasi terbaru seputar kegiatan dan kabar dari Himpunan Mahasiswa.
  </p>

  <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 max-w-7xl mx-auto">
    {informasi.map((item, index) => (
      <motion.div
        key={index}
        className="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer relative border border-gray-100 hover:border-[#800040]/40"
        onClick={() => navigate(`/informasi/${item.slug}`)}
        whileHover={{ y: -4 }}
        transition={{ duration: 0.3 }}
      >
        <div className="p-6 flex flex-col h-full">
          {/* Badge tanggal */}
          <div className="flex items-center gap-2 mb-3 text-xs font-medium text-[#800040] bg-[#800040]/10 px-3 py-1 rounded-full w-fit">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-4 w-4 text-[#800040]"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            {new Date(item.tanggal_input).toLocaleDateString("id-ID", {
              day: "numeric",
              month: "long",
              year: "numeric",
            })}
          </div>

          <h3 className="text-lg md:text-xl font-semibold text-[#7A2048] mb-2 group-hover:text-[#800040] transition-colors duration-300 line-clamp-2">
            {item.judul}
          </h3>

          <div
            className="text-gray-600 text-sm leading-relaxed mb-4 flex-grow line-clamp-4"
            dangerouslySetInnerHTML={{
              __html:
                item.informasi.length > 120
                  ? item.informasi.substring(0, 120) + "..."
                  : item.informasi,
            }}
          />

          <div className="flex items-center justify-between mt-auto pt-2">
            <div className="text-[#800040] text-sm font-medium flex items-center gap-1">
              Selengkapnya
              <span className="text-lg">➜</span>
            </div>
          </div>
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
