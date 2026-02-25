export default defineNuxtConfig({

  ssr: true,

  modules: ['@nuxtjs/supabase'],

  supabase: {
    redirect: false
  },

  nitro: {
    preset: 'vercel'
  },

  compatibilityDate: '2026-02-24'

})
