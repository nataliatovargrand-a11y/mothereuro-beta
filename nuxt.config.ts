export default defineNuxtConfig({

  ssr: true,

  nitro: {
    preset: 'vercel'
  },

  compatibilityDate: '2026-02-24',

  css: [
    '@/assets/css/main.css',
    'mapbox-gl/dist/mapbox-gl.css'
  ],

  runtimeConfig: {
    public: {
      mapboxToken: process.env.NUXT_PUBLIC_MAPBOX_TOKEN
    }
  },

  app: {
    head: {

      title: 'Mother Euro',

      meta: [
        { charset: 'utf-8' },

        // IMPORTANT FOR MOBILE SPACING
        {
          name: 'viewport',
          content: 'width=device-width, initial-scale=1'
        },

        { name: 'theme-color', content: '#FAF3EA' },
        { name: 'apple-mobile-web-app-capable', content: 'yes' },
        { name: 'apple-mobile-web-app-status-bar-style', content: 'default' },
        { name: 'apple-mobile-web-app-title', content: 'Mother Euro' }
      ],

      link: [
        { rel: 'manifest', href: '/manifest.json' },
        { rel: 'apple-touch-icon', href: '/icon-192.png' }
      ]

    }
  }

})