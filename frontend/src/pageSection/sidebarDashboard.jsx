import { AnimatePresence, motion } from "framer-motion";
import React, { useEffect, useState } from "react";
import Logo from "./../assets/m-logo.png";
import profil from "./../assets/user-profile.png";

export default function SidebarDashboard() {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [user, setUser] = useState(null);

  useEffect(() => {
    const storedUser = localStorage.getItem("user");
    if (storedUser) {
      setUser(JSON.parse(storedUser));
    } else {
      window.location.href = "/LoginPage";
    }
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("user");
    window.location.href = "/LoginPage";
  };

  return (
    <aside className="h-screen w-64 bg-white shadow-lg flex flex-col justify-between fixed left-0 top-0 z-50">
      <div>
        {/* Logo */}
        <div className="flex items-center gap-3 p-6 border-b border-gray-200">
          <a href="/dashboard" className="flex items-center gap-3">
            <img src={Logo} alt="Logo" className="h-10 w-10" />
            <span className="font-bold text-[#1a6ba3] text-xl">Dashboard</span>
          </a>
        </div>

        {/* Navigation */}
        <nav className="mt-6 flex flex-col gap-2 px-6">
          <a
            href="/dashboard"
            className="py-2 px-3 text-sm font-bold text-[#1a6ba3] hover:bg-gray-100 rounded-md"
          >
            Beranda
          </a>
          <a
            href="/informasi"
            className="py-2 px-3 text-sm font-bold text-[#1a6ba3] hover:bg-gray-100 rounded-md"
          >
            Informasi
          </a>
          <a
            href="/kontak"
            className="py-2 px-3 text-sm font-bold text-[#1a6ba3] hover:bg-gray-100 rounded-md"
          >
            Kontak
          </a>
        </nav>
      </div>

      {/* User Profile */}
      <div
        className="relative p-6 border-t border-gray-200"
        onMouseEnter={() => setIsDropdownOpen(true)}
        onMouseLeave={() => setIsDropdownOpen(false)}
      >
        {user ? (
          <div className="flex items-center gap-3 cursor-pointer group">
            <img
              src={user.profileImage || profil}
              className="w-10 h-10 rounded-full border-2 border-[#1a6ba3] group-hover:border-[#2889CE] transition"
              alt="Profile"
            />
            <div className="flex flex-col">
              <p className="text-sm font-semibold text-[#1a6ba3]">{user.username}</p>
              <p className="text-xs text-gray-500">{user.email}</p>
            </div>
          </div>
        ) : (
          <div className="w-10 h-10 rounded-full bg-gray-200 animate-pulse" />
        )}

        {/* Dropdown */}
        <AnimatePresence>
          {isDropdownOpen && (
            <motion.div
              className="absolute bottom-20 left-6 w-48 bg-white rounded-lg shadow-lg z-50"
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: 10 }}
              transition={{ duration: 0.3 }}
            >
              <a
                href="/UserProfile"
                className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition"
              >
                Profile
              </a>
              <button
                onClick={handleLogout}
                className="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition"
              >
                Logout
              </button>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </aside>
  );
}
