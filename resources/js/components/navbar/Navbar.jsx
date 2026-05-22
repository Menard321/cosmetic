import { useState } from "react";
import { Link } from "react-router-dom";
import { motion, AnimatePresence } from "framer-motion";

export default function Navbar() {
  const [open, setOpen] = useState(false);

  return (
    <div className="w-full bg-white shadow-md relative z-50">
      
      {/* TOP NAVBAR */}
      <div className="flex items-center justify-between px-6 py-4">
        
        {/* LOGO */}
        <h1 className="text-2xl font-bold tracking-wide">
          SILK BEAUTY
        </h1>

        {/* MENU */}
        <div className="flex gap-8">
          
          {/* MAKEUP */}
          <div
            onMouseEnter={() => setOpen(true)}
            onMouseLeave={() => setOpen(false)}
            className="relative"
          >
            <span className="cursor-pointer hover:text-pink-500">
              Makeup
            </span>

            {/* MEGA MENU */}
            <AnimatePresence>
              {open && (
                <motion.div
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  exit={{ opacity: 0, y: 20 }}
                  className="absolute left-0 top-10 w-[700px] bg-white shadow-2xl p-6 grid grid-cols-4 gap-6 rounded-xl"
                >

                  {/* COLUMN 1 */}
                  <div>
                    <h3 className="font-bold mb-2">Lips</h3>
                    <Link to="/lipstick">Lipstick</Link><br />
                    <Link to="/lipgloss">Lip Gloss</Link>
                  </div>

                  {/* COLUMN 2 */}
                  <div>
                    <h3 className="font-bold mb-2">Face</h3>
                    <Link to="/foundation">Foundation</Link><br />
                    <Link to="/powder">Powder</Link>
                  </div>

                  {/* COLUMN 3 */}
                  <div>
                    <h3 className="font-bold mb-2">Eyes</h3>
                    <Link to="/mascara">Mascara</Link><br />
                    <Link to="/eyeliner">Eyeliner</Link>
                  </div>

                  {/* FEATURED BOX */}
                  <div className="bg-pink-50 p-3 rounded-lg">
                    <p className="font-semibold">New Arrivals</p>
                    <p className="text-sm">Luxury makeup collection</p>
                    <button className="mt-2 text-pink-600 font-bold">
                      Shop Now
                    </button>
                  </div>

                </motion.div>
              )}
            </AnimatePresence>

          </div>

          <span>Skincare</span>
          <span>Fragrance</span>
          <span>Wellness</span>

        </div>

        {/* RIGHT ICONS */}
        <div className="flex items-center gap-4">
          <input
            className="border px-3 py-1 rounded-full"
            placeholder="Search..."
          />
          ❤️ 🛍 👤
        </div>

      </div>
    </div>
  );
}