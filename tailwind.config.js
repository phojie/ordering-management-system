const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  safelist: [
    // some safe classes here
  ],

  theme: {
    extend: {
      colors: {
        primary: colors.blue,
        success: colors.green,
        danger: colors.red,
        warning: colors.amber,
        info: colors.sky,
      },
      fontFamily: {
        sans: ['Poppins', 'Helvetica', 'Arial', 'sans-serif', ...defaultTheme.fontFamily.sans],
        cabin: ['Cabin', 'sans-serif', 'serif', ...defaultTheme.fontFamily.serif],
      },
    },
  },

  plugins: [require('@tailwindcss/forms')],
}
