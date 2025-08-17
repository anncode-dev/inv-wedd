/** @type {import('tailwindcss').Config} */

const defaultTheme = require("tailwindcss/defaultTheme");

export default {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./app.vue",
    "./error.vue",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#002D71',
        'secondary':'#2AD92A',
        'info': '#707070',
        'purple': '#AC43D9',
        'orange': '#FFC600',
      },
      screens: {
        '2xl': '1536px',
        'xl' : '1280px',
        'lg' : '1024px',
        'md' : '768px',
        'sm' : '640px',
      },
      keyframes: {
        zoomOut: {
          '0%': { transform: 'scale(1.2)' },
          '100%': { transform: 'scale(1)' }
        }
      },
      animation: {
        zoomOut: 'zoomOut 1s ease-out'
      },
    },

  },
  plugins: [require("@tailwindcss/typography")],
};
