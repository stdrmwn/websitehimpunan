import { motion } from 'framer-motion';
import { useNavigate } from 'react-router-dom';
import bannerImage from '../assets/fotohome.png'; // Ganti sesuai path kamu

export default function GetStarted() {
  const navigate = useNavigate();

  const handleNavigate = () => {
    navigate('/visimisi');
  };

  return (
    <div id="getStarted" className="relative min-h-screen font-poppins">
      <div className="relative w-full h-screen overflow-hidden">
        {/* Background image */}
        <img
          src={bannerImage}
          alt="HIMSI Universitas Pradita"
          className="w-full h-full object-cover"
        />

        {/* Overlay hitam */}
        <div className="absolute inset-0 bg-black bg-opacity-90 z-10" />

        {/* Konten */}
        <motion.div
          className="absolute inset-0 flex flex-col items-center justify-center text-center px-4 z-20"
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, ease: 'easeOut' }}
        >
          {/* Judul */}
          <h1 className="text-3xl sm:text-4xl md:text-5xl font-bold text-white drop-shadow-lg leading-tight tracking-tight">
            <span className="text-[#66A2EF] drop-shadow-md block sm:inline">
              Himpunan Mahasiswa Sistem Informasi
            </span>{' '}
            <span className="text-[#FF4500] block sm:inline">
              Universitas Pradita
            </span>
          </h1>

          {/* Deskripsi */}
          <motion.p
            className="mt-4 text-base sm:text-lg md:text-xl text-white max-w-3xl drop-shadow-md"
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 1, delay: 0.3 }}
          >
            Himpunan Mahasiswa Jurusan yang Mewadahi Program Studi Sistem Informasi. Memiliki
            Tujuan Untuk Berkarya Bersama, Tumbuh Bersama Berikan Dampak Bersama
          </motion.p>

          {/* Tombol */}
          <motion.button
            onClick={handleNavigate}
            className="mt-8 px-8 py-3 w-[220px] sm:w-[250px] md:w-[300px] text-white text-base sm:text-lg md:text-xl font-semibold border-2 border-white bg-transparent hover:bg-[#660033] hover:border-[#660033] transition-all duration-300 rounded-md active:shadow-[0_0_15px_3px_#660033] focus:outline-none"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.98 }}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 1.2, delay: 0.6 }}
          >
            Selengkapnya
          </motion.button>
        </motion.div>
      </div>
    </div>
  );
}
