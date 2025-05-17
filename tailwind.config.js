/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: ["./**/*.{php,html}"],
  theme: {
    extend: {
      animation: {
        'gradient': 'gradient 8s ease infinite',
        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        cursor: 'blink 0.8s infinite',
      },
      keyframes: {
        gradient: {
          '0%, 100%': {
            'background-position': '0% 50%'
          },
          '50%': {
            'background-position': '100% 50%'
          },
        },
        blink: {
          '0%, 100%': { borderColor: 'transparent' },
          '50%': { borderColor: 'white' },
        },
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
