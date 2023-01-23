const withMT = require("@material-tailwind/html/utils/withMT");


module.exports = withMT({
  content: [
    './404.php',
    './archive.php',
    './category.php',
    './tag.php',
    './footer.php',
    './functions.php',
    './header.php',
    './index.php',
    './page.php',
    './single.php',
    './tailwind.config.js',
    './core/**/*.php',
    './vendor/**/*.php',
    './src/**/*.js|css|scss',
  ],
  theme: {
    container: {
      center: true,
      padding: {
        DEFAULT: '1.5rem',
        sm: '2rem',
        lg: '3rem',
        xl: '4rem',
      },
      screens: {
        sm: '600px',
        md: '780px',
        lg: '984px',
        xl: '1296px',
        '2xl': '1296px',
      },
    },
    fontFamily: {
      'sans': [ 'Inter', 'sans-serif'],
      'lato': [ 'Lato', 'sans-serif'],
    },
    extend: {
      colors:{
        primary: '#3A77FF',
        secondary: '#0FE3FC',
        light: '#F2F6F9',
        gray: '#BBBBBB'
      }
    },
  },
  plugins: [],
})
