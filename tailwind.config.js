const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  purge: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      ...colors,
    },
    extend: {
      fontFamily: {
        sans: ['Nunito', ...defaultTheme.fontFamily.sans],
      },
      minHeight: {
        2.25: '2.25rem'
      }
    },
  },
  variants: {
    extend: {
      opacity: ['disabled'],
      backgroundColor: ['active', 'focus', 'focus-within'],
      display: ['group-hover'],
    },
  },

  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
