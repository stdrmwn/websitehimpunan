import { useEffect, useRef, useState } from "react";
import { useNavigate } from "react-router-dom";
import CardDua from "../assets/carddua.png";
import CardEmpat from "../assets/cardempat.png";
import CardSatu from "../assets/cardsatu.png";
import CardTiga from "../assets/cardtiga.png";

const eventData = [
  {
    img: CardSatu,
    title: "Lomba Tingkat Nasional",
    shortDesc: "Wadah kompetisi nasional untuk berprestasi.",
    fullDesc:
      "Kompetisi terbuka untuk seluruh mahasiswa di Indonesia dengan berbagai cabang lomba akademik dan non-akademik. Tujuan dari lomba ini adalah membentuk karakter kompetitif dan kreatif mahasiswa.",
  },
  {
    img: CardDua,
    title: "Information System Bootcamp",
    shortDesc: "Belajar, berkembang, dan mempererat kebersamaan.",
    fullDesc:
      "Bootcamp intensif yang dirancang untuk meningkatkan skill teknologi, kerja tim, dan leadership melalui berbagai aktivitas dan workshop selama beberapa hari.",
  },
  {
    img: CardTiga,
    title: "Pengenalan Prodi PKKMB",
    shortDesc:
      "Awal perjalanan mahasiswa baru untuk beradaptasi dan mengenal prodi.",
    fullDesc:
      "PKKMB memperkenalkan mahasiswa baru pada kurikulum, dosen, budaya kampus, dan kegiatan akademik. Ini adalah tahap awal adaptasi menuju kehidupan perkuliahan.",
  },
  {
    img: CardEmpat,
    title: "Charity",
    shortDesc: "Menebar kebaikan melalui aksi nyata.",
    fullDesc:
      "Kegiatan sosial untuk membantu masyarakat sekitar, melatih empati, solidaritas, dan semangat gotong royong melalui program donasi, bakti sosial, dan penggalangan dana.",
  },
];

export default function QnA() {
  const [flippedCard, setFlippedCard] = useState(null);
  const navigate = useNavigate();
  const headingRef = useRef(null);
  const cardsRef = useRef([]);
  const [headingVisible, setHeadingVisible] = useState(false);
  const [visibleCards, setVisibleCards] = useState([]);

  useEffect(() => {
    const headingObserver = new IntersectionObserver(
      ([entry]) => {
        setHeadingVisible(entry.isIntersecting);
      },
      { threshold: 0.2 }
    );

    if (headingRef.current) {
      headingObserver.observe(headingRef.current);
    }

    return () => {
      headingObserver.disconnect();
    };
  }, []);

  useEffect(() => {
    const cardObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry, index) => {
          if (entry.isIntersecting) {
            setTimeout(() => {
              setVisibleCards((prev) => [...new Set([...prev, index])]);
            }, index * 200);
          } else {
            setVisibleCards((prev) => prev.filter((i) => i !== index));
          }
        });
      },
      { threshold: 0.3 }
    );

    cardsRef.current.forEach((ref) => {
      if (ref) cardObserver.observe(ref);
    });

    return () => {
      cardsRef.current.forEach((ref) => {
        if (ref) cardObserver.unobserve(ref);
      });
    };
  }, []);

  const handleFlip = (index) => {
    setFlippedCard(flippedCard === index ? null : index);
  };

  return (
    <div id="qnA" className="px-6 md:px-[10%] py-24 bg-white text-center">
      <div
        ref={headingRef}
        className={`transition-all duration-1000 ${
          headingVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-6"
        }`}
      >
        <h2 className="text-3xl md:text-4xl font-bold text-[#800040]">
          Our Main Events
        </h2>
        <p className="text-lg text-gray-700 mt-3 max-w-xl mx-auto">
          Acara utama yang mencerminkan semangat dan kontribusi kami.
        </p>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mt-16">
        {eventData.map((event, index) => (
          <div
            key={index}
            ref={(el) => (cardsRef.current[index] = el)}
            className={`relative w-full h-[350px] perspective group cursor-pointer transition duration-500 ${
              visibleCards.includes(index)
                ? "scale-100 opacity-100"
                : "scale-90 opacity-0"
            }`}
            onClick={() => handleFlip(index)}
          >
            <div
              className={`relative w-full h-full transition-transform duration-700 transform-style preserve-3d ${
                flippedCard === index ? "rotate-y-180" : ""
              }`}
            >
              {/* Front Side */}
              <div className="absolute w-full h-full backface-hidden rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow z-20">
                <img
                  src={event.img}
                  alt={event.title}
                  className="w-full h-full object-cover"
                />
                <div className="absolute bottom-0 w-full bg-gradient-to-t from-black via-black/40 to-transparent text-white p-4 flex flex-col justify-end">
                  <h3 className="font-semibold text-lg">{event.title}</h3>
                  <p className="text-sm opacity-80">{event.shortDesc}</p>
                </div>

                {/* Hover Icon */}
                <div className="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-30">
                  <span className="text-white text-4xl">🔍</span>
                </div>
              </div>

              {/* Back Side */}
              <div className="absolute w-full h-full backface-hidden rotate-y-180 rounded-2xl overflow-hidden shadow-md bg-[#1a1a1a] text-white z-10">
                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    setFlippedCard(null);
                  }}
                  className="absolute top-2 right-3 text-white text-xl font-bold hover:text-gray-300 z-30"
                >
                  ✕
                </button>
                <img
                  src={event.img}
                  alt={event.title}
                  className="w-full h-full object-cover brightness-50 absolute inset-0"
                />
                <div className="relative z-20 h-full p-4 flex flex-col justify-center backdrop-blur-sm bg-black/60 rounded-2xl">
                  <h3 className="font-semibold text-xl mb-3">{event.title}</h3>
                  <p className="text-sm overflow-y-auto max-h-[200px] pr-2">
                    {event.fullDesc}
                  </p>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>

      <button
        onClick={() => navigate("/events")}
        className="mt-12 px-8 py-3 w-[240px] md:w-[280px] text-[#660033] text-base md:text-lg font-semibold border-2 border-[#660033] bg-white hover:bg-[#660033] hover:text-white transition-all duration-300 rounded-xl shadow-sm hover:shadow-md active:shadow-[0_0_20px_4px_#660033] focus:outline-none"
      >
        Lihat Event Lainnya
      </button>

      <style jsx>{`
        .perspective {
          perspective: 1200px;
        }
        .transform-style {
          transform-style: preserve-3d;
        }
        .rotate-y-180 {
          transform: rotateY(180deg);
        }
        .backface-hidden {
          backface-visibility: hidden;
        }
      `}</style>
    </div>
  );
}
