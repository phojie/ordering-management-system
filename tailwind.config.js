const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './node_modules/floating-vue/dist/style.css',
    './node_modules/vue-select/dist/vue-select.css',
    './node_modules/filepond/dist/filepond.min.css',
    './node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css',
  ],

  safelist: [
    // some safe classes here
  ],

  theme: {
    extend: {
      colors: {
        gray: colors.slate,
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

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
