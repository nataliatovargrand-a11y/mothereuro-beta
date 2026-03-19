import { supabase } from '~/utils/supabase'

export default defineNuxtRouteMiddleware(async (to) => {

  const publicPages = ['/login', '/update-password']

  if (publicPages.includes(to.path)) return

  const { data: { session } } = await supabase.auth.getSession()

  if (!session) {
    return navigateTo('/login')
  }

})