import { ChevronDown, ChevronUp } from "lucide-react";
import { useState } from "react";
import Footer from "../pageSection/footer.jsx";
import NavbarWhite from "../pageSection/NavbarWhite.jsx";

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
  {
    question: "Apakah pengurus HIMSI mendapatkan sertifikat?",
    answer: "Ya, pengurus HIMSI akan mendapatkan sertifikat di akhir masa jabatan.",
  },
  {
    question: "Apakah HIMSI hanya untuk mahasiswa Sistem Informasi?",
    answer:
      "Ya, HIMSI adalah Himpunan Mahasiswa Sistem Informasi dan hanya untuk mahasiswa aktif dari program studi tersebut.",
  },
];

export default function FaqPage() {
  const [openIndex, setOpenIndex] = useState(null);

  const toggleFAQ = (index) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  return (
    <>
      <NavbarWhite />

      <section className="min-h-screen px-6 md:px-24 py-20 bg-white">
        <div className="text-center mb-12">
          <h1 className="text-3xl md:text-4xl font-extrabold text-[#861B58]">
            Frequently Asked Questions
          </h1>
          <p className="text-lg md:text-xl text-gray-600 mt-4 max-w-2xl mx-auto">
            Temukan jawaban atas pertanyaan umum seputar HIMSI di sini.
          </p>
        </div>

        <div className="space-y-5 max-w-3xl mx-auto">
          {faqData.map((faq, index) => (
            <div
              key={index}
              className={`transition-all duration-300 p-5 rounded-2xl border shadow-md ${
                openIndex === index
                  ? "bg-[#FFF1F6] border-[#7A1E52]"
                  : "bg-white hover:bg-[#FDF6F9] border-gray-200"
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
      </section>

      <Footer />
    </>
  );
}
