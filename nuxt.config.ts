export default defineNuxtConfig({

  ssr: true,

  nitro: {
    preset: 'vercel'
  },

  compatibilityDate: '2026-02-24',

  css: [
    '@/assets/css/main.css'
  ]

})
