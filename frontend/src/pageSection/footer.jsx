import { Link } from 'react-router-dom';
import IconInstagram from '../assets/icon-instagram.png';
import IconLinkedIn from '../assets/icon-linkedin.png';
import IconYouTube from '../assets/icon-youtube.png';
import LogoHIMSI from '../assets/logo-himsi.png';

export default function Footer() {
  return (
    <footer className="bg-[#800040] text-white px-6 md:px-20 py-10">
      <div className="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-6 gap-10">
        {/* Kolom 1: HIMSI dan Sosial Media */}
        <div className="md:col-span-3">
          <img src={LogoHIMSI} alt="Logo HIMSI" className="w-36 mb-4" />
          <p className="text-sm leading-relaxed max-w-sm">
            Himpunan Mahasiswa Jurusan yang mewadahi Program Studi Sistem Informasi.
            Memiliki tujuan untuk berkarya bersama, tumbuh bersama, berikan dampak bersama.
          </p>

          {/* Ikon Sosial Media */}
          <div className="flex gap-4 mt-6">
            <a href="https://youtube.com/@himsipradita?si=AKMVjgRvibr8Z5PS" target="_blank" rel="noopener noreferrer">
              <img src={IconYouTube} alt="YouTube" className="w-8 h-8 hover:scale-110 transition-transform duration-200" />
            </a>
            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer">
              <img src={IconLinkedIn} alt="LinkedIn" className="w-8 h-8 hover:scale-110 transition-transform duration-200" />
            </a>
            <a href="https://www.instagram.com/himsi.pradita?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer">
              <img src={IconInstagram} alt="Instagram" className="w-8 h-8 hover:scale-110 transition-transform duration-200" />
            </a>
          </div>
        </div>

        {/* Kolom 2: Navigasi */}
        <div className="md:col-span-1">
          <h3 className="text-lg font-bold mb-4">Navigasi</h3>
          <ul className="space-y-2 text-sm">
            <li><a href="/" className="hover:underline hover:text-gray-200 transition">Beranda</a></li>
            <li><a href="/visimisi" className="hover:underline hover:text-gray-200 transition">Tentang Kami</a></li>
            <li><a href="/informasi" className="hover:underline hover:text-gray-200 transition">Informasi</a></li>
            <li><a href="/faq" className="hover:underline hover:text-gray-200 transition">FAQ</a></li>
            <li><a href="/contact" className="hover:underline hover:text-gray-200 transition">Kontak</a></li>
            <li>  <Link to="/prodi" className="hover:underline hover:text-gray-200 transition">
    Website Prodi
  </Link></li>
          </ul>
        </div>

        {/* Kolom 3: Divisi */}
        <div className="md:col-span-2">
          <h3 className="text-lg font-bold mb-4">Divisi</h3>
          <ul className="space-y-2 text-sm">
            <li><a href="/divisi#badan-pengurus-harian" className="hover:underline hover:text-gray-200 transition">BPH</a></li>
            <li><a href="/divisi#divisi-akademik" className="hover:underline hover:text-gray-200 transition">Divisi Akademik</a></li>
            <li><a href="/divisi#divisi-non-akademik" className="hover:underline hover:text-gray-200 transition">Divisi Non Akademik</a></li>
            <li><a href="/divisi#divisi-humas-acara" className="hover:underline hover:text-gray-200 transition">Divisi Humas Acara</a></li>
            <li><a href="/divisi#divisi-humas-media-sosial" className="hover:underline hover:text-gray-200 transition">Divisi Humas Media Sosial</a></li>
          </ul>
        </div>
      </div>

      {/* Footer Bottom */}
      <div className="mt-10 border-t border-white/20 pt-4 text-center text-sm text-white/80">
        © 2025 HIMSI Pradita — All Rights Reserved <br />
      </div>
    </footer>
  );
}
