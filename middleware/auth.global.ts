export default defineNuxtRouteMiddleware(async (to) => {

  const supabase = useNuxtApp().$supabase

  const { data } = await supabase.auth.getSession()
  const session = data?.session

  const publicRoutes = [
    '/login',
    '/update-password'
  ]

  if (publicRoutes.includes(to.path)) {
    return
  }

  if (!session) {
    return navigateTo('/login', { replace: true })
  }

})