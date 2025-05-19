-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Bulan Mei 2025 pada 23.08
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `himpunan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `pencapaian` enum('Periode Kepengurusan','Mahasiswa Pengurus','Program Kerja Terlaksana','Impact ke Masyarakat') NOT NULL,
  `angka` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `achievements`
--

INSERT INTO `achievements` (`id`, `pencapaian`, `angka`) VALUES
(1, 'Periode Kepengurusan', 4),
(2, 'Mahasiswa Pengurus', 80),
(3, 'Program Kerja Terlaksana', 10),
(4, 'Impact ke Masyarakat', 83);

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `informasi` text NOT NULL,
  `tanggal_input` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `kategori`, `judul`, `informasi`, `tanggal_input`, `foto`) VALUES
(1, 'Lomba', 'Bizznovation', 'Segera daftarkan dirimu di ', '2025-05-13', '1746942666_bootcamp.png'),
(2, 'After Events', 'LDK HIMSI 2024/2025: Pembekalan Kepemimpinan dengan Pemaparan Materi dan Sharing Session', '<p style=\"text-align: justify;\" data-start=\"155\" data-end=\"575\">LDK HIMSI (Latihan Dasar Kepemimpinan Himpunan Mahasiswa Sistem Informasi) 2024/2025 berlangsung dengan sukses, menghadirkan pengalaman berharga bagi peserta yang terdiri dari mahasiswa baru. Acara ini mengundang pembicara istimewa, yaitu Ketua HIMSI periode lalu, <strong>Chelyne</strong>, dan Wakil Ketua HIMSI periode lalu, <strong>Steven Dermawan</strong>, yang berbagi pengalaman dan pengetahuan mereka dalam kepemimpinan dan pengelolaan organisasi.</p>\r\n<p style=\"text-align: justify;\" data-start=\"155\" data-end=\"575\">&nbsp;</p>\r\n<p style=\"text-align: justify;\" data-start=\"577\" data-end=\"1139\">Acara dimulai dengan pemaparan materi yang sangat menarik. Chelyne membahas tentang pentingnya kepemimpinan yang adaptif dalam dunia yang terus berubah, dengan menekankan bagaimana pemimpin harus mampu berkolaborasi, berkomunikasi dengan efektif, dan mengambil keputusan yang bijak dalam menghadapi tantangan. Steven Dermawan melanjutkan dengan berbagi tentang pengelolaan tim dan peran penting komunikasi dalam organisasi. Keduanya memberikan wawasan tentang tantangan yang mereka hadapi selama menjabat dan bagaimana mereka mengatasi berbagai situasi di HIMSI.</p>\r\n<p style=\"text-align: justify;\" data-start=\"1141\" data-end=\"1538\">&nbsp;</p>\r\n<p style=\"text-align: justify;\" data-start=\"1141\" data-end=\"1538\">Setelah pemaparan materi, acara dilanjutkan dengan sesi sharing yang sangat interaktif. Peserta diberi kesempatan untuk mengajukan pertanyaan dan berdiskusi langsung dengan Chelyne dan Steven. Sharing session ini membuka ruang bagi mahasiswa untuk menggali lebih dalam mengenai pengembangan diri, pengalaman kepemimpinan, dan tips-tips praktis yang dapat diterapkan dalam organisasi kampus mereka.</p>\r\n<p style=\"text-align: justify;\" data-start=\"1540\" data-end=\"1807\" data-is-last-node=\"\" data-is-only-node=\"\">&nbsp;</p>\r\n<p style=\"text-align: justify;\" data-start=\"1540\" data-end=\"1807\" data-is-last-node=\"\" data-is-only-node=\"\">LDK HIMSI 2024/2025 tidak hanya memberikan pemahaman teoritis mengenai kepemimpinan, tetapi juga memfasilitasi peserta untuk belajar langsung dari pengalaman para pemimpin sebelumnya, mempersiapkan mereka untuk menjadi generasi pemimpin yang lebih baik di masa depan.</p>', '2025-05-05', '1746946622_ldk.png'),
(3, 'Prestasi', 'Menang Lagi! Pradita University Raih Juara 2 & 3 di Kompetisi Nasional Hackathon BAZNAS 2024', '<p style=\"text-align: justify;\">Pradita University kembali membuktikan komitmennya dalam menerapkan konsep pembelajaran \"Real Case Real Experience\" yang menekankan pentingnya belajar langsung dari dunia kerja nyata. Salah satu buktinya adalah partisipasi mahasiswa dalam berbagai kompetisi bergengsi, termasuk Hackathon BAZNAS 2024.</p>\r\n<p style=\"text-align: justify;\">Kabar gembira kali ini datang dari Program Studi Information Technology. Dua tim mahasiswa berbakat berhasil meraih prestasi gemilang di kompetisi Hackathon BAZNAS 2024, yaitu Juara 2 dan Juara 3. Tim yang meraih Juara 2 dalam Hackathon - Zakathon 2024 terdiri dari Ariya Panna dan Astria Febrian Anggraini, sementara Tim yang meraih Juara 3 beranggotakan Dason Tiovino, Devin Tan, dan Kenneth William Gunawan.</p>\r\n<p style=\"text-align: justify;\">Kompetisi Hackathon BAZNAS 2024 merupakan ajang nasional yang diselenggarakan oleh Badan Amil Zakat Nasional (BAZNAS) pada 19 September 2024 di Novotel Hotel, Jakarta. Lomba ini mempertemukan talenta terbaik dari berbagai universitas di Indonesia untuk bersaing dalam menciptakan solusi digital inovatif yang berfokus pada pengelolaan zakat berbasis teknologi.</p>\r\n<p style=\"text-align: justify;\">Keberhasilan tim mahasiswa Pradita University tidak diraih secara instan. Mereka melewati berbagai tahapan seleksi dan tantangan yang menuntut kreativitas, kerja sama tim, serta pemahaman mendalam tentang teknologi dan kebutuhan sosial. Dengan bimbingan dosen dan semangat belajar yang tinggi, mereka mampu mengembangkan solusi yang diakui oleh juri sebagai salah satu yang terbaik dalam ajang tersebut.</p>\r\n<p style=\"text-align: justify;\">Prestasi ini menjadi bukti nyata bahwa Pradita University tidak hanya mendorong mahasiswanya untuk unggul di ruang kelas, tetapi juga membekali mereka dengan pengalaman praktis yang relevan dengan dunia industri. Universitas terus berkomitmen untuk memfasilitasi mahasiswa dalam mengembangkan keterampilan, berinovasi, dan meraih prestasi di berbagai bidang.</p>\r\n<p style=\"text-align: justify;\">Sekali lagi, selamat kepada Ariya Panna, Astria Febrian Anggraini, Dason Tiovino, Devin Tan, dan Kenneth William Gunawan atas pencapaian luar biasa ini! Sweet Success!</p>', '2025-05-11', '1746968445_menang-lagi-pradita-university-raih-juara-2-3-di-kompetisi-nasional-hackathon-baznas-2024__hzfUA.jpg'),
(4, 'After Events', 'MultiVerse Conference 2025: Inovasi Teknologi dan Kolaborasi Industri-Akademisi', '<p>Pradita University sukses menggelar MultiVerse Conference 2025, konferensi teknologi yang berlangsung secara hybrid pada 15-23 Februari 2025. Acara ini merupakan hasil kolaborasi dengan Medusa Technology, menghadirkan pembahasan seputar metaverse, kecerdasan buatan (AI), dan Internet of Things (IoT). Para peserta dapat mengikuti sesi secara luring, daring, maupun melalui platform metaverse, dengan lebih dari 100 peserta per hari dan 10 narasumber kompeten.</p>\r\n<p>&nbsp;</p>\r\n<p>Dekan Pradita University, Dr. Eng. Handri Santoso, S.Si., M.Eng., menekankan bahwa konferensi ini menjadi peluang bagi akademisi dan industri untuk mendorong inovasi digital, khususnya dalam bidang pendidikan dan industri teknologi. Sementara itu, Maria Magdalena dari Medusa Technology menyatakan bahwa acara ini bertujuan memberikan manfaat nyata bagi mahasiswa, dosen, dan praktisi teknologi digital.</p>\r\n<p>&nbsp;</p>\r\n<p>Salah satu sorotan utama adalah Virtual World Innovation &amp; Creativity Award (Virwica) 2025, diikuti oleh 40 inovator muda. Tim dari Sekolah Aloysius Bandung meraih Gold Award dengan proyek \"Household Wastewater to Battery\", solusi pemanfaatan air buangan rumah tangga sebagai sumber energi. Kompetisi ini membuktikan bahwa inovasi berbasis teknologi dapat memberikan dampak positif bagi masyarakat.</p>\r\n<p>&nbsp;</p>\r\n<p>Rektor Pradita University, Prof. Dr. Ir. Richardus Eko Indrajit, menegaskan bahwa MultiVerse Conference akan menjadi acara tahunan yang semakin inklusif. Dengan format diskusi panel, lokakarya, dan demonstrasi teknologi, Pradita University terus berkomitmen menjadi pelopor dalam pendidikan berbasis teknologi dan kolaborasi industri-akademisi.</p>\r\n<p>&nbsp;</p>', '2025-05-11', '1746968961_multiverse-conference-2025-inovasi-teknologi-dan-kolaborasi-industri-akademisi__NQIWs.jpg'),
(5, 'After Events', 'Terra Act: Satu Langkah untuk Bumi, Sejuta Harapan untuk Masa Depan', '<p style=\"text-align: justify;\">Setiap tindakan kecil kita dapat membawa dampak besar, dan itulah yang kami lakukan dalam acara Terra Act. Bersama ibu-ibu PKK kami mengadakan workshop pembuatan pupuk dan penanaman bibit. Kegiatan ini mengajarkan kami pentingnya tindakan nyata untuk menjaga kelestarian alam, dan bagaimana langkah sederhana bisa membawa perubahan besar untuk masa depan Bumi.<br><br>Terra Act jadi pengalaman seru dan bermakna karena kami bisa langsung terjun ke lapangan untuk menanam dan membuat pupuk sebagai bentuk cinta nyata untuk bumi. Paling seru pas nyangkul bareng teman-teman dari jurusan lain&mdash;baru kenal, tapi langsung kerja bareng di tanah.<br><br>Selamat Yuk, intip momen spesialnya di postingan ini!</p>', '2025-05-06', NULL),
(6, 'After Events', 'SIGMA: Langkah Awal Perubahan HIMSI Pradita', '<p style=\"text-align: justify;\">Pada 21 Maret 2025, HIMSI Pradita mengadakan SIGMA (Sistem Informasi Gagasan Musyawarah Aspirasi), sebuah momen penting yang mengesahkan AD/ART HIMSI untuk pertama kalinya. Dalam acara ini, anggota HIMSI berdiskusi dan merumuskan dasar organisasi yang akan menjadi panduan kepengurusan ke depan.<br><br>Dengan menegaskan nilai-nilai seperti Pancasila, Kolaborasi, dan Profesionalisme, kami menyusun pondasi yang kuat untuk membangun HIMSI yang lebih inklusif dan berkembang. Ini adalah langkah pertama menuju masa depan HIMSI Pradita yang lebih solid dan adaptif.<br><br>Ikuti perjalanan kami dan lihat bagaimana langkah kecil ini akan berdampak besar bagi HIMSI Pradita ke depannya!</p>', '2025-05-05', '1746973098_original 2025-03-21 082145.874.jpg'),
(7, 'After Events', 'Together We Share & Care: Ramadan Helping Hands', '<p style=\"text-align: justify;\">Charity ini bukan sekadar tentang berbagi, tetapi juga membangun kebersamaan dan memberikan pengalaman berharga. Dalam postingan ini, kamu akan menemukan rangkuman perjalanan charity mulai dari latar belakang acara, pentingnya berbagi, hingga total donasi yang berhasil dikumpulkan.<br><br>Tidak hanya itu, ada juga cerita tentang kegiatan seru yang dilakukan bersama anak-anak panti, serta insight dari panitia yang terlibat langsung. Semua ini menjadi bukti bahwa sekecil apa pun kebaikan, pasti membawa dampak yang berarti. Swipe untuk melihat lebih lanjut!</p>', '2025-05-06', '1746973180_IMG_20250322_144454 (1).jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikelfix`
--

CREATE TABLE `artikelfix` (
  `id` int(11) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `informasi` text DEFAULT NULL,
  `tanggal_input` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikelfix`
--

INSERT INTO `artikelfix` (`id`, `kategori`, `judul`, `informasi`, `tanggal_input`, `foto`, `slug`) VALUES
(1, 'Dana Usaha', 'Pensi Mangan', '<p>📢 PENSI CLEAN &ndash; SEPATU KOTOR? KAMI BIKIN KINCLONG! 👟✨</p>\r\n<p>Sepatu kotor bikin gak pede? Jangan khawatir, PENSI CLEAN siap bikin sepatumu bersih lagi! 🚀</p>\r\n<p>🧼 JASA CUCI SEPATU &ndash; CUMA 25K!<br>🕒 Pengerjaan 3-4 hari<br>✅ Bersih ✅ Wangi ✅ Siap dipakai lagi!</p>\r\n<p>📍 ORDER SEKARANG!<br>📞 Lina: 0858-9342-5826<br>📞 Nanda: 0821-1215-2347</p>\r\n<p>Jangan tunggu makin kotor, langsung cuci di PENSI CLEAN! 👟✨🔥</p>', '2025-05-05', '1746987850_WhatsApp Image 2025-04-10 at 08.27.55.jpeg', 'pensi-mangan'),
(2, 'After Events', 'MultiVerse Conference 2025: Inovasi Teknologi dan Kolaborasi Industri-Akademisi', '<p style=\"text-align: left;\">Pradita University sukses menggelar MultiVerse Conference 2025, konferensi teknologi yang berlangsung secara hybrid pada 15-23 Februari 2025. Acara ini merupakan hasil kolaborasi dengan Medusa Technology, menghadirkan pembahasan seputar metaverse, kecerdasan buatan (AI), dan Internet of Things (IoT). Para peserta dapat mengikuti sesi secara luring, daring, maupun melalui platform metaverse, dengan lebih dari 100 peserta per hari dan 10 narasumber kompeten.</p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\">Dekan Pradita University, Dr. Eng. Handri Santoso, S.Si., M.Eng., menekankan bahwa konferensi ini menjadi peluang bagi akademisi dan industri untuk mendorong inovasi digital, khususnya dalam bidang pendidikan dan industri teknologi. Sementara itu, Maria Magdalena dari Medusa Technology menyatakan bahwa acara ini bertujuan memberikan manfaat nyata bagi mahasiswa, dosen, dan praktisi teknologi digital.</p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\">Salah satu sorotan utama adalah Virtual World Innovation &amp; Creativity Award (Virwica) 2025, diikuti oleh 40 inovator muda. Tim dari Sekolah Aloysius Bandung meraih Gold Award dengan proyek \"Household Wastewater to Battery\", solusi pemanfaatan air buangan rumah tangga sebagai sumber energi. Kompetisi ini membuktikan bahwa inovasi berbasis teknologi dapat memberikan dampak positif bagi masyarakat.</p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\">Rektor Pradita University, Prof. Dr. Ir. Richardus Eko Indrajit, menegaskan bahwa MultiVerse Conference akan menjadi acara tahunan yang semakin inklusif. Dengan format diskusi panel, lokakarya, dan demonstrasi teknologi, Pradita University terus berkomitmen menjadi pelopor dalam pendidikan berbasis teknologi dan kolaborasi industri-akademisi.</p>', '2025-05-12', '1746987285_multiverse-conference-2025-inovasi-teknologi-dan-kolaborasi-industri-akademisi__NQIWs.jpg', 'multiverse-conference-2025-inovasi-teknologi-dan-kolaborasi-industri-akademisi'),
(3, 'After Events', 'Terra Act: Satu Langkah untuk Bumi, Sejuta Harapan untuk Masa Depan', '<p style=\"text-align: left;\">Setiap tindakan kecil kita dapat membawa dampak besar, dan itulah yang kami lakukan dalam acara Terra Act. Bersama ibu-ibu PKK kami mengadakan workshop pembuatan pupuk dan penanaman bibit. Kegiatan ini mengajarkan kami pentingnya tindakan nyata untuk menjaga kelestarian alam, dan bagaimana langkah sederhana bisa membawa perubahan besar untuk masa depan Bumi.<br><br>Terra Act jadi pengalaman seru dan bermakna karena kami bisa langsung terjun ke lapangan untuk menanam dan membuat pupuk sebagai bentuk cinta nyata untuk bumi. Paling seru pas nyangkul bareng teman-teman dari jurusan lain&mdash;baru kenal, tapi langsung kerja bareng di tanah.<br><br>Selamat Yuk, intip momen spesialnya di postingan ini!</p>', '2025-05-06', '1746987756_IMG_3171 (1).JPG', 'terra-act-satu-langkah-untuk-bumi-sejuta-harapan-untuk-masa-depan'),
(4, 'After Events', 'SIGMA: Langkah Awal Perubahan HIMSI Pradita', '<p style=\"text-align: justify;\">Pada 21 Maret 2025, HIMSI Pradita mengadakan SIGMA (Sistem Informasi Gagasan Musyawarah Aspirasi), sebuah momen penting yang mengesahkan AD/ART HIMSI untuk pertama kalinya. Dalam acara ini, anggota HIMSI berdiskusi dan merumuskan dasar organisasi yang akan menjadi panduan kepengurusan ke depan.<br><br>Dengan menegaskan nilai-nilai seperti Pancasila, Kolaborasi, dan Profesionalisme, kami menyusun pondasi yang kuat untuk membangun HIMSI yang lebih inklusif dan berkembang. Ini adalah langkah pertama menuju masa depan HIMSI Pradita yang lebih solid dan adaptif.<br><br>Ikuti perjalanan kami dan lihat bagaimana langkah kecil ini akan berdampak besar bagi HIMSI Pradita ke depannya!</p>', '2025-05-06', '1746988879_original 2025-03-21 082145.874.jpg', 'sigma-langkah-awal-perubahan-himsi-pradita'),
(5, 'Prestasi', 'Menang Lagi! Pradita University Raih Juara 2 & 3 di Kompetisi Nasional Hackathon BAZNAS 2024', '<p style=\"text-align: justify;\">Pradita University kembali membuktikan komitmennya dalam menerapkan konsep pembelajaran \"Real Case Real Experience\" yang menekankan pentingnya belajar langsung dari dunia kerja nyata. Salah satu buktinya adalah partisipasi mahasiswa dalam berbagai kompetisi bergengsi, termasuk Hackathon BAZNAS 2024.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Kabar gembira kali ini datang dari Program Studi Information Technology. Dua tim mahasiswa berbakat berhasil meraih prestasi gemilang di kompetisi Hackathon BAZNAS 2024, yaitu Juara 2 dan Juara 3. Tim yang meraih Juara 2 dalam Hackathon - Zakathon 2024 terdiri dari Ariya Panna dan Astria Febrian Anggraini, sementara Tim yang meraih Juara 3 beranggotakan Dason Tiovino, Devin Tan, dan Kenneth William Gunawan.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Kompetisi Hackathon BAZNAS 2024 merupakan ajang nasional yang diselenggarakan oleh Badan Amil Zakat Nasional (BAZNAS) pada 19 September 2024 di Novotel Hotel, Jakarta. Lomba ini mempertemukan talenta terbaik dari berbagai universitas di Indonesia untuk bersaing dalam menciptakan solusi digital inovatif yang berfokus pada pengelolaan zakat berbasis teknologi.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Keberhasilan tim mahasiswa Pradita University tidak diraih secara instan. Mereka melewati berbagai tahapan seleksi dan tantangan yang menuntut kreativitas, kerja sama tim, serta pemahaman mendalam tentang teknologi dan kebutuhan sosial. Dengan bimbingan dosen dan semangat belajar yang tinggi, mereka mampu mengembangkan solusi yang diakui oleh juri sebagai salah satu yang terbaik dalam ajang tersebut.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Prestasi ini menjadi bukti nyata bahwa Pradita University tidak hanya mendorong mahasiswanya untuk unggul di ruang kelas, tetapi juga membekali mereka dengan pengalaman praktis yang relevan dengan dunia industri. Universitas terus berkomitmen untuk memfasilitasi mahasiswa dalam mengembangkan keterampilan, berinovasi, dan meraih prestasi di berbagai bidang.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Sekali lagi, selamat kepada Ariya Panna, Astria Febrian Anggraini, Dason Tiovino, Devin Tan, dan Kenneth William Gunawan atas pencapaian luar biasa ini! Sweet Success!</p>', '2025-05-11', '1746988926_menang-lagi-pradita-university-raih-juara-2-3-di-kompetisi-nasional-hackathon-baznas-2024__hzfUA.jpg', 'menang-lagi-pradita-university-raih-juara-2-3-di-kompetisi-nasional-hackathon-baznas-2024'),
(7, 'After Events', 'LDK HIMSI 2024/2025: Pembekalan Kepemimpinan dengan Pemaparan Materi dan Sharing Session', '<p style=\"text-align: left;\" data-start=\"155\" data-end=\"575\">LDK HIMSI (Latihan Dasar Kepemimpinan Himpunan Mahasiswa Sistem Informasi) 2024/2025 berlangsung dengan sukses, menghadirkan pengalaman berharga bagi peserta yang terdiri dari mahasiswa baru. Acara ini mengundang pembicara istimewa, yaitu Ketua HIMSI periode lalu,&nbsp;<strong>Chelyne</strong>, dan Wakil Ketua HIMSI periode lalu,&nbsp;<strong>Steven Dermawan</strong>, yang berbagi pengalaman dan pengetahuan mereka dalam kepemimpinan dan pengelolaan organisasi.</p>\r\n<p style=\"text-align: left;\" data-start=\"155\" data-end=\"575\">&nbsp;</p>\r\n<p style=\"text-align: left;\" data-start=\"577\" data-end=\"1139\">Acara dimulai dengan pemaparan materi yang sangat menarik. Chelyne membahas tentang pentingnya kepemimpinan yang adaptif dalam dunia yang terus berubah, dengan menekankan bagaimana pemimpin harus mampu berkolaborasi, berkomunikasi dengan efektif, dan mengambil keputusan yang bijak dalam menghadapi tantangan. Steven Dermawan melanjutkan dengan berbagi tentang pengelolaan tim dan peran penting komunikasi dalam organisasi. Keduanya memberikan wawasan tentang tantangan yang mereka hadapi selama menjabat dan bagaimana mereka mengatasi berbagai situasi di HIMSI.</p>\r\n<p style=\"text-align: left;\" data-start=\"1141\" data-end=\"1538\">&nbsp;</p>\r\n<p style=\"text-align: left;\" data-start=\"1141\" data-end=\"1538\">Setelah pemaparan materi, acara dilanjutkan dengan sesi sharing yang sangat interaktif. Peserta diberi kesempatan untuk mengajukan pertanyaan dan berdiskusi langsung dengan Chelyne dan Steven. Sharing session ini membuka ruang bagi mahasiswa untuk menggali lebih dalam mengenai pengembangan diri, pengalaman kepemimpinan, dan tips-tips praktis yang dapat diterapkan dalam organisasi kampus mereka.</p>\r\n<p style=\"text-align: left;\" data-start=\"1540\" data-end=\"1807\" data-is-last-node=\"\" data-is-only-node=\"\">&nbsp;</p>\r\n<p style=\"text-align: left;\" data-start=\"1540\" data-end=\"1807\" data-is-last-node=\"\" data-is-only-node=\"\">LDK HIMSI 2024/2025 tidak hanya memberikan pemahaman teoritis mengenai kepemimpinan, tetapi juga memfasilitasi peserta untuk belajar langsung dari pengalaman para pemimpin sebelumnya, mempersiapkan mereka untuk menjadi generasi pemimpin yang lebih baik di masa depan.</p>', '2025-05-11', '1746989070_ldk.png', 'ldk-himsi-2024-2025-pembekalan-kepemimpinan-dengan-pemaparan-materi-dan-sharing-session'),
(8, 'Lomba', 'ASEAN Data Science Explorers 2025 - Data Science Workshop', '<p>🚨 ATTENTION TO ALL DATA ENTHUSIASTS! 🚨<br>Get ready to dive into the world of data science &mdash; IN PERSON! 🌟</p>\r\n<p>🎓 ASEAN Data Science Explorers 2025 - Data Science Workshop<br>📍 Hosted by: HIMSI x HIMTIKA Universitas Pradita<br>🗓 Friday, May 9, 2025<br>⏰ 09.00-11.30 WIB<br>📍 Auditorium 2, Pradita University</p>\r\n<p>This event is open to students who want to explore the exciting world of data science and discover opportunities in ASEAN-level competitions! 📑🌏</p>\r\n<p>🔗 Join the WhatsApp group for updates:sss</p>\r\n<p><span style=\"color: rgb(224, 62, 45);\"><a style=\"color: rgb(224, 62, 45);\" href=\"https://chat.whatsapp.com/CY1dHls6AqnHlg8Bdm52vk\">Klik Here</a></span></p>', '2025-05-13', '1747071814_WhatsApp Image 2025-05-04 at 09.35.55.jpeg', 'asean-data-science-explorers-2025-data-science-workshop');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama_divisi` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `program_kerja` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `foto`, `nama_divisi`, `deskripsi`, `program_kerja`) VALUES
(1, 'WhatsApp Image 2025-04-13 at 15.05.02.jpeg', 'Badan Pengurus Harian', 'Bertugas merencanakan dan mengevaluasi seluruh kegiatan organisasi sesuai visi dan misi. Bertanggung jawab terhadap seluruh organisasi dan membantu seluruh divisi dalam setiap kegiatan.', 'Rapat Koordinasi Internal\r\nEvaluasi Tengah dan Akhir Periode\r\nPengawasan Program Kerja'),
(2, 'img2.JPG', 'Divisi Akademik', 'Bertugas menyusun dan melaksanakan program kerja yang menunjang peningkatan akademik mahasiswa. Juga berperan sebagai penghubung antara mahasiswa dan dosen dalam hal akademik.', 'Kelas Belajar Rutin\r\nPelatihan Excel dan SQL\r\nSesi Tanya Jawab dengan Dosen'),
(3, 'img3.JPG', 'Divisi Non Akademik', 'Mengelola kegiatan yang bersifat minat, bakat, serta pengembangan diri mahasiswa di luar akademik. Juga menyelenggarakan kegiatan hiburan, olahraga, dan seni.', 'Turnamen Futsal & Mobile Legends\r\nWorkshop Kesenian Digital\r\nTalent Show Mahasiswa'),
(4, 'img4.JPG', 'Divisi Humas Acara', 'Bertugas menjadi komunikator antara internal kegiatan dan mengatur pelaksanaan acara organisasi. Juga membantu kelancaran hubungan antara pihak luar secara langsung.', 'Koordinasi Acara Tahunan\r\nPartnership & Sponsorship\r\nPengelolaan Rundown Acara'),
(5, 'img12.jpg', 'Divisi Humas Media Sosial', 'Mengelola informasi dan publikasi kegiatan melalui sosial media organisasi. Bertanggung jawab atas desain, capture, dan daya unggah.', 'Kampanye Media Digital\r\nPosting Konten Harian\r\nLive Report Kegiatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nama_event` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `foto`, `nama_event`, `deskripsi`) VALUES
(3, 'lomba-nasional.png', 'Lomba Tingkat Nasional', 'Wadah kompetisi nasional untuk berprestasi, baik di ranah akademik maupun non-akademik.'),
(4, 'pkkmb.png', ' Pengenalan Prodi PKKMB', 'Awal perjalanan mahasiswa baru untuk beradaptasi dan mengenal lebih dekat dunia prodi.'),
(5, 'bootcamp.png', ' Information System Bootcamp', 'Belajar, berkembang, dan mempererat kebersamaan dalam satu rangkaian bootcamp.'),
(6, 'charity.png', 'Charity', 'Menebar kebaikan, mempererat kepedulian melalui aksi nyata.'),
(7, 'webinar.png', 'Webinar Tingkat Nasional', 'Wawasan luas dari para ahli, dalam satu panggung inspiratif berskala nasional.'),
(8, 'studi-banding.png', 'Studi Banding', 'Berbagi inspirasi dan membangun kolaborasi lintas himpunan untuk tumbuh bersama.'),
(9, 'ldk.png', 'Latihan Dasar Kepemimpinan', 'Membentuk jiwa kepemimpinan yang tangguh dan berintegritas sejak langkah pertama.'),
(10, 'musyawarah.png', 'Musyawarah Himpunan', 'Ruang demokrasi untuk menyuarakan aspirasi dan menetapkan arah organisasi ke depan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `eventshimpunan`
--

CREATE TABLE `eventshimpunan` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `kategori_event` varchar(50) NOT NULL,
  `deskripsi_event` text NOT NULL,
  `tanggal_event` date NOT NULL,
  `foto_event` varchar(255) DEFAULT NULL,
  `link_terkait` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `eventshimpunan`
--

INSERT INTO `eventshimpunan` (`id`, `nama_event`, `kategori_event`, `deskripsi_event`, `tanggal_event`, `foto_event`, `link_terkait`, `slug`, `tanggal_input`) VALUES
(3, 'Webinar Seru! Kota Cerdas: Analisa Penerapan E-Government dalam Memenuhi Kebutuhan Layanan Publik', 'AKADEMIK', '<p>Yuk, simak dan bahas bareng bagaimana teknologi E-Government di Indonesia dan luar negeri bisa bikin layanan publik lebih efisien! Cocok banget buat kamu yang tertarik di bidang Sistem Informasi, Smart City, dan Inovasi Digital.</p>\r\n<p>🎤 Dipandu oleh:<br>Muhammad Aghnat Mumtaz (Moderator)</p>\r\n<p>👥 Pembicara:<br>- Fransiska Eka Putri Wiriady<br>- ⁠Nadine Aurelia<br>- ⁠Kenneth Marchelino Subrata<br>- ⁠Marshanda Anabella<br>- ⁠Muhammad Iyad Irviansyah</p>\r\n<p>📅 Hari/Tanggal: Senin, 7 April 2025<br>⏰ Waktu: 10.15 - 13.00 WIB<br>📍 Tempat: Google Meet (Link: s.id/WebinarKotaCerdas)</p>\r\n<p>Jangan lewatkan kesempatan belajar dan diskusi seru ini, sampai jumpa di webinar nanti! 🚀</p>', '2025-05-12', '1747644040_WhatsApp Image 2025-04-06 at 10.55.01.jpeg', 'https://meet.google.com/uhr-yonk-cnq', 'webinar-seru-kota-cerdas-analisa-penerapan-e-government-dalam-memenuhi-kebutuhan-layanan-publik', '2025-05-17 07:36:48'),
(4, 'BIZZNOVATION 2025', 'LOMBA', '<p class=\"\" data-start=\"168\" data-end=\"405\">🚀 <strong data-start=\"171\" data-end=\"212\">BIZZNOVATION 2025 IS OFFICIALLY OPEN!</strong> 🌟<br data-start=\"215\" data-end=\"218\">Ajang Business Plan Competition terbesar dari Universitas Pradita kini hadir kembali! Siapkan ide terbaikmu untuk menjawab tantangan masa depan dan menangkan berbagai hadiah menarik! 💼💡</p>\r\n<p class=\"\" data-start=\"407\" data-end=\"487\">📍 <em data-start=\"410\" data-end=\"428\">Babak Penyisihan</em>: Online<br data-start=\"436\" data-end=\"439\">📍 <em data-start=\"442\" data-end=\"455\">Babak Final</em>: Offline di Universitas Pradita</p>\r\n<p class=\"\" data-start=\"489\" data-end=\"681\">🎯 <strong data-start=\"492\" data-end=\"510\">TIMELINE UTAMA</strong><br data-start=\"510\" data-end=\"513\">🔹 <em data-start=\"516\" data-end=\"528\">Early Bird</em> (Rp75.000): 1 Feb &ndash; 1 Mar 2025<br data-start=\"559\" data-end=\"562\">🔹 <em data-start=\"565\" data-end=\"574\">Reguler</em> (Rp100.000): 2 &ndash; 15 Mar 2025<br data-start=\"603\" data-end=\"606\">🔹 <em data-start=\"609\" data-end=\"629\">Workshop with Maxy</em>: 28 Feb 2025<br data-start=\"642\" data-end=\"645\">🔹 <em data-start=\"648\" data-end=\"668\">Final Presentation</em>: 26 Apr 2025</p>\r\n<p class=\"\" data-start=\"683\" data-end=\"952\">🏆 <strong data-start=\"686\" data-end=\"702\">TOTAL HADIAH</strong><br data-start=\"702\" data-end=\"705\">🥇 Juara 1: Emas + Voucher Rp2.000.000 + Sertifikat<br data-start=\"756\" data-end=\"759\">🥈 Juara 2: Emas + Voucher Rp1.000.000 + Sertifikat<br data-start=\"810\" data-end=\"813\">🥉 Juara 3: Voucher Rp500.000 + Sertifikat<br data-start=\"855\" data-end=\"858\">🎓 Beasiswa pendidikan hingga puluhan juta rupiah!<br data-start=\"908\" data-end=\"911\">🎁 Voucher menarik untuk seluruh peserta!</p>\r\n<p class=\"\" data-start=\"954\" data-end=\"1048\">💻 Daftar sekarang di:<br data-start=\"976\" data-end=\"979\">🌐 <a class=\"\" href=\"https://bizznovation.framer.website\" target=\"_new\" rel=\"noopener\" data-start=\"982\" data-end=\"1048\">bizznovation.framer.website</a></p>\r\n<p class=\"\" data-start=\"1050\" data-end=\"1196\">📲 Info lebih lanjut:<br data-start=\"1071\" data-end=\"1074\">IG: @bizznovation<br data-start=\"1091\" data-end=\"1094\">📩 Email: <a class=\"cursor-pointer\" rel=\"noopener\" data-start=\"1104\" data-end=\"1134\">bpcpraditauniversity@gmail.com</a><br data-start=\"1134\" data-end=\"1137\">📞 CP: Faiz (+62 813-1754-9681) | Ephraim (+62 818-117-887)</p>', '2025-05-06', '1747688068_[Poster] Bizznovation 2025 (2) (1).jpg', 'https://bizznovation.framer.website/?fbclid=PAZXh0bgNhZW0CMTEAAabbsuBWOe8Er_TgxBR80B3btarnMC_SsxxsVumxlD-k5wW6AhuV6_tU6fc_aem_RFlzzuEPSL2zhzL3f3sudw', 'bizznovation-2025', '2025-05-17 08:06:20'),
(5, 'Break and Bonds', 'AKADEMIK', '<p>Yuk buruan daftar dan gabung bareng kita di Acara Break and Bond : Bukber Seru Ala Sistem Informasi!</p>\r\n<p>Hari/Tanggal : Selasa, 25 Maret 2025<br>Waktu : 16.30 - 19.30&nbsp;<br>Tempat : Multifunction Room 1, Pradita University&nbsp;<br>Harga Pendaftaran : 30k/Orang<br>Link Pendaftaran : https://s.id/breaknbond</p>\r\n<p>Kami tunggu ya ! 🤗✨</p>', '2025-05-19', '1747643951_WhatsApp Image 2025-03-24 at 13.26.16.jpeg', 'https://s.id/breaknbond', 'break-and-bonds', '2025-05-17 08:30:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_events`
--

CREATE TABLE `gallery_events` (
  `id` int(11) NOT NULL,
  `foto_ke` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gallery_events`
--

INSERT INTO `gallery_events` (`id`, `foto_ke`, `foto`) VALUES
(1, 1, 'IMG_20250322_144454 (1).jpg'),
(2, 2, 'img2.JPG'),
(3, 3, 'img3.JPG'),
(4, 4, 'img4.JPG'),
(5, 5, 'img5.JPG'),
(6, 6, 'img6.JPG'),
(7, 7, 'img7.JPG'),
(8, 8, 'img8.JPG'),
(9, 9, 'img9.JPG'),
(10, 10, 'img10.JPG'),
(11, 11, 'img11.JPG'),
(12, 12, 'img12.jpg'),
(13, 13, 'img13.jpg'),
(14, 14, 'img14.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kabinet`
--

CREATE TABLE `kabinet` (
  `id` int(11) NOT NULL,
  `nama_kabinet` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kabinet`
--

INSERT INTO `kabinet` (`id`, `nama_kabinet`, `deskripsi`, `logo`) VALUES
(5, 'Satvikara', 'Dengan semangat untuk mengakar dan berkembang, Badan Pengurus Harian periode 2024–2025 siap mewujudkan HIMSI Pradita yang senantiasa tumbuh sebagai wadah pengembangan diri bagi anggotanya.', 'logosatvikara.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ourhistory`
--

CREATE TABLE `ourhistory` (
  `id` int(11) NOT NULL,
  `tahun_jabatan` varchar(20) NOT NULL,
  `nama_ketua` varchar(100) NOT NULL,
  `nama_wakil` varchar(100) NOT NULL,
  `foto_profil` varchar(255) NOT NULL,
  `daftar_kegiatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ourhistory`
--

INSERT INTO `ourhistory` (`id`, `tahun_jabatan`, `nama_ketua`, `nama_wakil`, `foto_profil`, `daftar_kegiatan`) VALUES
(1, '2023/2024', 'Chelyne', 'Steven Dermawan', 'himsi202324.png', 'Webinar\r\nCharity\r\nLomba Esai\r\nLomba E Sport\r\nPKKMB Prodi\r\nStudi Banding\r\nSerah Terima Jabatan'),
(2, '2024/2025', 'Keisha Jovie Dermawan', 'Danendra Rafi Enditama', 'fotoempat.png', 'Lomba Tingkat Nasional\r\nWorkshop\r\nCharity');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','superadmin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`) VALUES
(1, 'stevendarmawan2016@gmail.com', '$2y$10$KsLeA3xMbCS6J35kJvvj2.h4PcV4RnSYCQGXbMXvwrbDd/7cDRMjS', 'admin'),
(2, 'stevendarmawan3888@gmail.com', '$2y$10$FSalAZpdhSFVqfqqNZhqH.D9wjF0aJNGfwknq9fJ626MjTyW1rQTO', 'admin'),
(4, 'superadminn@gmail.com', '$2y$10$/8ve5564.VaqMDQrDZPQlu27OaL1yorvzgSmK7H21Idv8pleVY.K.', 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visimisi`
--

CREATE TABLE `visimisi` (
  `id` int(11) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `visimisi`
--

INSERT INTO `visimisi` (`id`, `visi`, `misi`) VALUES
(1, 'Menjadikan HIMSI Pradita sebagai organisasi yang berperan aktif dalam pengembangan mahasiswa Sistem Informasi, baik dalam aspek akademik, profesional, dan sosial, serta menjadi wadah inovatif yang mampu memberikan kontribusi nyata bagi universitas, industri dan masyarakat.', '1. Mendorong pengembangan kompetensi akademik dan non-akademik mahasiswa Sistem Informasi.\r\n2. Meningkatkan kolaborasi dengan berbagai pihak, baik internal maupun eksternal kampus.\r\n3. Menjadi fasilitator kegiatan yang mendukung inovasi, kreativitas, dan kontribusi nyata mahasiswa.\r\n4. Membangun lingkungan organisasi yang inklusif, profesional, dan berintegritas.');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `artikelfix`
--
ALTER TABLE `artikelfix`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `eventshimpunan`
--
ALTER TABLE `eventshimpunan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `gallery_events`
--
ALTER TABLE `gallery_events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kabinet`
--
ALTER TABLE `kabinet`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ourhistory`
--
ALTER TABLE `ourhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `visimisi`
--
ALTER TABLE `visimisi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `artikelfix`
--
ALTER TABLE `artikelfix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `eventshimpunan`
--
ALTER TABLE `eventshimpunan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `gallery_events`
--
ALTER TABLE `gallery_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `kabinet`
--
ALTER TABLE `kabinet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ourhistory`
--
ALTER TABLE `ourhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `visimisi`
--
ALTER TABLE `visimisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD CONSTRAINT `data_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
