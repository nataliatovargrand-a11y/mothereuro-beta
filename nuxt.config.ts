export default defineNuxtConfig({

  ssr: true,

  nitro: {
    preset: 'vercel'
  },

  compatibilityDate: '2026-02-24',

  css: [
    '@/assets/css/main.css'
  ],

  app: {
    head: {
      title: 'Mother Euro',
      meta: [
        { name: 'theme-color', content: '#D8D0C6' }
      ],
      link: [
        { rel: 'apple-touch-icon', sizes: '180x180', href: '/icon-180.png' }
      ]
    }
  }

})
