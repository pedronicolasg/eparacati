/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: ["./**/*.php"],
  theme: {
    extend: {
      fontFamily: {
        exo: ["Exo", "sans-serif"],
        rubik: ["Rubik", "sans-serif"],
      },
    },
  },
  plugins: [],
};
