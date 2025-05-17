// src/components/GalleryOfEvents.jsx
import axios from "axios";
import { motion } from "framer-motion";
import { useEffect, useState } from "react";

const GalleryOfEvents = () => {
  const [topImages, setTopImages] = useState([]);
  const [bottomImages, setBottomImages] = useState([]);

  useEffect(() => {
    const fetchImages = async () => {
      try {
        const response = await axios.get("http://localhost/WEBSITEHIMPUNAN/backend/get_gallery.php");
        const images = response.data;

        // Pisahkan berdasarkan foto_ke
        const top = images.filter((img) => img.foto_ke >= 1 && img.foto_ke <= 7);
        const bottom = images.filter((img) => img.foto_ke >= 8 && img.foto_ke <= 14);

        setTopImages(top);
        setBottomImages(bottom);
      } catch (error) {
        console.error("Error fetching gallery images:", error);
      }
    };

    fetchImages();
  }, []);

  return (
    <div className="px-0 py-16 bg-white text-center overflow-hidden">
      <h2 className="text-3xl md:text-4xl font-bold">
        <span className="text-[#800040]">Gallery of</span>{" "}
        <span className="text-[#800040]">Events</span>
      </h2>
      <p className="text-lg text-gray-700 mt-4 mb-10">
        Kilasan momen terbaik dari setiap langkah dan cerita kami.
      </p>

      {/* Top Row */}
      <div className="overflow-hidden whitespace-nowrap mb-6">
        <motion.div
          className="flex w-max"
          animate={{ x: ["0%", "-50%"] }}
          transition={{ repeat: Infinity, duration: 60, ease: "linear" }}
        >
          {[...topImages, ...topImages].map((img, index) => (
            <img
              key={index}
              src={`http://localhost/WEBSITEHIMPUNAN/backend/${img.url}`}
              className="w-[300px] h-[200px] object-cover flex-shrink-0"
              alt={`top-${img.foto_ke}`}
            />
          ))}
        </motion.div>
      </div>

      {/* Bottom Row */}
      <div className="overflow-hidden whitespace-nowrap">
        <motion.div
          className="flex w-max"
          animate={{ x: ["-50%", "0%"] }}
          transition={{ repeat: Infinity, duration: 60, ease: "linear" }}
        >
          {[...bottomImages, ...bottomImages].map((img, index) => (
            <img
              key={index}
              src={`http://localhost/WEBSITEHIMPUNAN/backend/${img.url}`}
              className="w-[300px] h-[200px] object-cover flex-shrink-0"
              alt={`bottom-${img.foto_ke}`}
            />
          ))}
        </motion.div>
      </div>
    </div>
  );
};

export default GalleryOfEvents;
