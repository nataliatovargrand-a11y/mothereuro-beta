import { ref } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const membershipStatus = ref(null)

export const useAuth = () => {

  const loadUser = async () => {
    const { data } = await supabase.auth.getUser()

    if (data.user) {
      user.value = data.user

      const { data: member } = await supabase
        .from('members')
        .select('membership_status')
        .eq('email', data.user.email)
        .single()

      membershipStatus.value = member?.membership_status || 'pending'
    } else {
      user.value = null
      membershipStatus.value = null
    }
  }

  return {
    user,
    membershipStatus,
    loadUser
  }
}