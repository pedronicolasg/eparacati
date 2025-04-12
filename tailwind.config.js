/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: ["./**/*.{php,html}"],
  theme: {
    extend: {
      fontFamily: {
        exo: ["Exo", "sans-serif"],
        rubik: ["Rubik", "sans-serif"],
      },
    },
  },
  plugins: [
    function ({ addUtilities }) {
      addUtilities({
        '.scrollbar-thin': {
          '&::-webkit-scrollbar': {
            width: '6px',
            height: '6px',
          },
          '&::-webkit-scrollbar-track': {
            backgroundColor: 'rgb(229, 231, 235)',
          },
          '&::-webkit-scrollbar-thumb': {
            backgroundColor: 'rgb(156, 163, 175)',
            borderRadius: '3px',
            '&:hover': {
              backgroundColor: 'rgb(107, 114, 128)',
            },
          },
          '.dark &::-webkit-scrollbar-track': {
            backgroundColor: 'rgb(31, 41, 55)',
          },
          '.dark &::-webkit-scrollbar-thumb': {
            backgroundColor: 'rgb(75, 85, 99)',
            '&:hover': {
              backgroundColor: 'rgb(107, 114, 128)',
            },
          },
        },
      });
    },
  ],
};
