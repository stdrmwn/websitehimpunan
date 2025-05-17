import { motion } from "framer-motion";

export default function WebsiteProdi() {
  return (
    <div className="min-h-screen bg-[#800040] text-white flex items-center justify-center px-4">
      <div className="text-center space-y-6">
        <motion.h1
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-5xl font-extrabold"
        >
          Website Program Studi Sistem Informasi Universitas Pradita
        </motion.h1>

        <motion.p
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.5, duration: 0.8, repeat: Infinity, repeatType: "reverse" }}
          className="text-xl font-medium opacity-80"
        >
          Coming Soon...
        </motion.p>
      </div>
    </div>
  );
}
