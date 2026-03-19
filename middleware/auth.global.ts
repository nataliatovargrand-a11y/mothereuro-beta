export default defineNuxtRouteMiddleware(async () => {

  const supabase = useSupabaseClient()

  const { data } = await supabase.auth.getSession()
  const session = data?.session

  if (!session) {
    return navigateTo('/login')
  }

})