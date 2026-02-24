export default defineNuxtConfig({

  ssr: true,

  nitro: {
    preset: 'vercel'
  },

  compatibilityDate: '2026-02-24',

  app: {
    head: {
      link: [
        { rel: 'manifest', href: '/manifest.json' }
      ]
    }
  }

})
