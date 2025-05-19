import axios from "axios";
import { motion } from "framer-motion";
import { useEffect, useState } from "react";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import { Navigation, Pagination } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";
import Footer from "../pageSection/footer.jsx";

const MainEvents = () => {
  const [events, setEvents] = useState([]);
  const [selectedIndex, setSelectedIndex] = useState(null);

  useEffect(() => {
    axios
      .get("http://localhost/WEBSITEHIMPUNAN/backend/get_events.php")
      .then((response) => {
        setEvents(response.data);
      })
      .catch((error) => {
        console.error("Error fetching events:", error);
      });
  }, []);

  const openModal = (index) => {
    setSelectedIndex(index);
  };

  const closeModal = () => {
    setSelectedIndex(null);
  };

  const goToPrevious = () => {
    setSelectedIndex((prev) => (prev === 0 ? events.length - 1 : prev - 1));
  };

  const goToNext = () => {
    setSelectedIndex((prev) => (prev === events.length - 1 ? 0 : prev + 1));
  };

  return (
    <>
      <NavbarWhite />
      <div className="bg-white min-h-screen">
        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, ease: "easeOut" }}
          className="text-center pt-28 mb-10"
        >
          <h2 className="text-4xl md:text-5xl font-extrabold text-gray-400">
            <span className="text-[#861B58]">Our </span>
            <span className="text-[#861B58]">Events</span>
          </h2>
          <p className="text-lg text-gray-600 mt-3 max-w-2xl mx-auto">
            Acara utama yang mencerminkan semangat dan kontribusi kami untuk masa depan yang lebih baik.
          </p>
        </motion.div>

        {/* Mobile View: Carousel */}
        <div className="md:hidden px-4 pb-20 relative">
          <Swiper
            spaceBetween={16}
            slidesPerView={1}
            pagination={{ clickable: true }}
            navigation={true}
            modules={[Pagination, Navigation]}
            className="relative"
          >
            {events.map((event, idx) => (
              <SwiperSlide key={event.id}>
                <motion.div
                  className="relative h-[320px] rounded-xl overflow-hidden shadow-xl group cursor-pointer"
                  initial={{ opacity: 0, y: 40 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.6, delay: idx * 0.1 }}
                  viewport={{ once: true }}
                  onClick={() => openModal(idx)}
                >
                  <img
                    src={`http://localhost/WEBSITEHIMPUNAN/backend/${event.image}`}
                    alt={event.title}
                    className="w-full h-full object-cover"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent" />
                  <div className="absolute bottom-5 left-5 right-5 text-white z-10">
                    <h3 className="text-xl font-bold">{event.title}</h3>
                    <p className="text-sm mt-1">{event.description}</p>
                  </div>
                  <div className="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/50">
                    <span className="text-white text-lg font-semibold bg-[#861B58] px-4 py-2 rounded-full shadow-lg">
                      Lihat Detail
                    </span>
                  </div>
                </motion.div>
              </SwiperSlide>
            ))}
          </Swiper>

          <style jsx>{`
            :global(.swiper-button-prev),
            :global(.swiper-button-next) {
              color: #861B58;
              top: 40%;
              width: 36px;
              height: 36px;
              background-color: white;
              border-radius: 9999px;
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            :global(.swiper-button-prev::after),
            :global(.swiper-button-next::after) {
              font-size: 16px;
              font-weight: bold;
            }
            :global(.swiper-pagination-bullet) {
              background-color: #c4c4c4;
              opacity: 1;
              margin: 0 6px !important;
            }
            :global(.swiper-pagination-bullet-active) {
              background-color: #861B58;
            }
          `}</style>
        </div>

        {/* Desktop View: Grid */}
        <div className="hidden md:grid max-w-6xl mx-auto px-6 grid-cols-2 lg:grid-cols-3 gap-8 pb-20">
          {events.map((event, idx) => (
            <motion.div
              key={event.id}
              className="relative h-[320px] rounded-xl overflow-hidden shadow-lg group cursor-pointer"
              initial={{ opacity: 0, y: 40 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: idx * 0.1 }}
              viewport={{ once: true }}
              onClick={() => openModal(idx)}
            >
              <img
                src={`http://localhost/WEBSITEHIMPUNAN/backend/${event.image}`}
                alt={event.title}
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent" />
              <div className="absolute bottom-5 left-5 right-5 text-white z-10">
                <h3 className="text-xl font-semibold">{event.title}</h3>
                <p className="text-sm mt-1">{event.description}</p>
              </div>
              <div className="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/50">
                <span className="text-white text-lg font-semibold bg-[#861B58] px-4 py-2 rounded-full shadow-lg">
                  Lihat Detail
                </span>
              </div>
            </motion.div>
          ))}
        </div>
      </div>

      {/* Modal Pop-up */}
      {selectedIndex !== null && (
        <div className="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
          <div className="relative bg-white rounded-lg max-w-3xl w-full overflow-hidden shadow-2xl">
            <button
              onClick={closeModal}
              className="absolute top-3 right-3 text-black text-2xl font-bold z-10"
            >
              &times;
            </button>
            <div className="relative">
              <img
                src={`http://localhost/WEBSITEHIMPUNAN/backend/${events[selectedIndex].image}`}
                alt={events[selectedIndex].title}
                className="w-full max-h-[400px] object-cover"
              />
              <div className="p-6 text-center">
                <h3 className="text-2xl font-bold text-[#861B58] mb-2">
                  {events[selectedIndex].title}
                </h3>
                <p className="text-gray-700">{events[selectedIndex].description}</p>
              </div>
              <button
                onClick={goToPrevious}
                className="absolute top-1/2 left-3 transform -translate-y-1/2 bg-[#861B58] text-white w-10 h-10 rounded-full shadow-md hover:bg-[#6c1646]"
              >
                &#8592;
              </button>
              <button
                onClick={goToNext}
                className="absolute top-1/2 right-3 transform -translate-y-1/2 bg-[#861B58] text-white w-10 h-10 rounded-full shadow-md hover:bg-[#6c1646]"
              >
                &#8594;
              </button>
            </div>
          </div>
        </div>
      )}

      <Footer />
    </>
  );
};

export default MainEvents;
