export default defineNuxtRouteMiddleware(async (to) => {

  const supabase = useNuxtApp().$supabase

  const publicPages = ['/login', '/update-password']

  if (publicPages.includes(to.path)) return

  const { data: { session } } = await supabase.auth.getSession()

  const { data: { user } } = await supabase.auth.getUser()

  if (!session && !user) {
    return navigateTo('/login')
  }

})