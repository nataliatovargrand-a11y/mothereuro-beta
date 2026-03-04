import { ref } from 'vue'
import { supabase } from '~/utils/supabase'

export const useAccess = () => {

  const tier = ref('guest')
  const user = ref(null)

  const tierLevels = {
    guest: 0,
    global: 1,
    resident: 2,
    aspiring: 3
  }

  const loadAccess = async () => {

    const { data } = await supabase.auth.getUser()

    if (!data.user) {
      tier.value = 'guest'
      return
    }

    user.value = data.user

    const { data: member } = await supabase
      .from('members')
      .select('membership_tier')
      .eq('email', data.user.email)
      .single()

    tier.value = member?.membership_tier || 'global'
  }

  const hasTier = (requiredTier) => {
    return tierLevels[tier.value] >= tierLevels[requiredTier]
  }

  return {
    tier,
    user,
    loadAccess,
    hasTier
  }

}