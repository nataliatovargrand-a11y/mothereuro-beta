export default defineNuxtConfig({

  ssr: true,

  nitro: {
    preset: 'vercel'
  },

  compatibilityDate: '2026-02-24',

  app: {
    head: {
      title: 'Mother Euro',
      meta: [
        { name: 'theme-color', content: '#D8D0C6' },
        { name: 'apple-mobile-web-app-capable', content: 'yes' },
        { name: 'apple-mobile-web-app-status-bar-style', content: 'default' }
      ],
      link: [
        { rel: 'icon', type: 'image/png', href: '/favicon.ico' },
        { rel: 'apple-touch-icon', sizes: '180x180', href: '/icon-180.png' },
        { rel: 'manifest', href: '/manifest.json' }
      ]
    }
  }

})
