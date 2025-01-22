/** @type {import('tailwindcss').Config} */

const colors = require("tailwindcss/colors")

export default {
  content: [
    "./dist/index.html",
    "./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    screens: {
      // desktop first
      // 'xl': {'max': '1279px'},
      // 'lg': {'max': '991px'},
      // 'md': {'max': '767px'},
      // 'sm': {'max': '479px'}

      // mobile-first
      sm: "480px",
      // => @media (min-width: 480px) { ... }

      md: "768px",
      // => @media (min-width: 768px) { ... }

      lg: "992px",
      // => @media (min-width: 992px) { ... }

      xl: "1280px",
      // => @media (min-width: 1280px) { ... }
    },
    fontFamily: { poppins: ["Poppins", "sans-serif"] },
    // opacity: {
    //   0: 0,
    //   15: 0.15,
    //   25: 0.25,
    //   50: 0.5,
    //   75: 0.75,
    //   100: 1,
    // },
    // spacing: {
    // 0
    // px
    // 0.5
    // 1
    // 2
    // 4
    // 6
    // 8
    // 10
    // 12
    // 16
    // 24
    // 32
    // 40
    // 48
    // 60
    // 72
    // 80
    // 96
    // },
    borderWidth: {
      0: "0",
      2: "2px",
      DEFAULT: "2px",
      bold: "4px",
    },
    borderRadius: {
      none: "0",
      sm: "0.5rem",
      DEFAULT: "0.5rem",
      md: "1rem",
      lg: "2rem",
      full: "9999px",
    },
    extend: {
      fontSize: {
        h0: [
          "clamp(2.986rem, 2.5319rem + 2.2705vi, 4.2915rem)",
          { lineHeight: "1", letterSpacing: "-0.03em", fontWeight: "700" },
        ],
        h1: [
          "clamp(2.4883rem, 2.1597rem + 1.6433vi, 3.4332rem)",
          { lineHeight: "1", letterSpacing: "-0.03em", fontWeight: "500" },
        ],
        h2: [
          "clamp(2.0736rem, 1.8395rem + 1.1704vi, 2.7466rem)",
          { lineHeight: "1.2", letterSpacing: "-0.03em", fontWeight: "700" },
        ],
        h3: [
          "clamp(1.728rem, 1.5648rem + 0.8161vi, 2.1973rem)",
          { lineHeight: "1.2", letterSpacing: "-0.03em", fontWeight: "600" },
        ],
        h4: [
          "clamp(1.44rem, 1.3295rem + 0.5527vi, 1.7578rem)",
          { lineHeight: "1.2", letterSpacing: "-0.03em", fontWeight: "600" },
        ],
        h5: [
          "clamp(1.2rem, 1.1283rem + 0.3587vi, 1.4063rem)",
          { lineHeight: "1.3", letterSpacing: "-0.03em", fontWeight: "500" },
        ],
        h6: [
          "1rem",
          { lineHeight: "1.3", letterSpacing: "-0.03em", fontWeight: "500" },
        ],
      },
      colors: {
        white: "#FCFCFC",
        black: "#1B1B1B",
        gray: {
          lightest: "#F4F4F4",
          light: "#E3E3E3",
          DEFAULT: "#C6C6C6",
          dark: "#3F3F3F",
        },
        accent: {
          lightest: "#C8E0FF",
          light: "#96C3FD",
          DEFAULT: "#006EFF",
          dark: "#003F92",
          darkest: "#00275B",
        },
        danger: {
          light: "#fecaca",
          DEFAULT: "#dc2626",
          dark: "#991b1b",
        },
        success: {
          light: "#bbf7d0",
          DEFAULT: "#22c55e",
          dark: "#166534",
        },
        border_color: "#C6C6C6",

        // secondary section bg
        // tetriary section bg
      },
    },
  },
  plugins: [
    require("@tailwindcss/typography"),
    require("@tailwindcss/forms")({
      strategy: "base",
    }),
    require("flowbite/plugin"),
  ],
}
