<template>

<div class="account-wrapper">

  <div v-if="loading">Loading...</div>

  <div v-else>

    <!-- PASSWORD FLOW -->
    <div v-if="needsPassword">

      <h2>Complete Your Access</h2>

      <input v-model="password" type="password" placeholder="Create password" />
      <input v-model="confirmPassword" type="password" placeholder="Confirm password" />

      <p v-if="passwordError">{{ passwordError }}</p>

      <button @click="setPassword">
        ENTER THE PLATFORM
      </button>

    </div>

    <!-- ACCOUNT -->
    <div v-else>

      <div class="account-header">
        <h1>Hi, {{ firstName }}</h1>
        <button @click="logout">Log Out</button>
      </div>

      <div class="card">

        <button v-if="!editing" @click="editing = true">
          Edit Profile
        </button>

        <div>

          <img v-if="member?.avatar_url" :src="member.avatar_url" width="100" />
          <input type="file" @change="uploadAvatar" />

        </div>

        <div v-if="!editing">

          <div>Name: {{ member?.name }}</div>
          <div>Email: {{ member?.email }}</div>
          <div>Membership: {{ member?.membership_tier }}</div>
          <div>City: {{ member?.city }}</div>

        </div>

        <div v-else>

          <input v-model="name" placeholder="Name" />
          <input v-model="city" placeholder="City" />
          <input v-model="industry" placeholder="Industry" />

          <button @click="saveProfile">Save</button>
          <button @click="editing = false">Cancel</button>

        </div>

      </div>

    </div>

  </div>

</div>

</template>

<script setup>

import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'
import { useRouter } from 'vue-router'

const router = useRouter()

const loading = ref(true)
const user = ref(null)
const member = ref(null)

const editing = ref(false)

const name = ref('')
const city = ref('')
const industry = ref('')

const needsPassword = ref(false)
const password = ref('')
const confirmPassword = ref('')
const passwordError = ref('')

const firstName = computed(() => {
  return member.value?.name?.split(' ')[0] || 'Member'
})

onMounted(async () => {

  const hash = window.location.hash

  const isInvite = hash.includes('type=invite')
  const isRecovery = hash.includes('type=recovery')

  // create session from email tokens
  if (hash.includes('access_token')) {

    const params = new URLSearchParams(hash.replace('#', ''))

    const access_token = params.get('access_token')
    const refresh_token = params.get('refresh_token')

    if (access_token && refresh_token) {
      await supabase.auth.setSession({
        access_token,
        refresh_token
      })
    }
  }

  const { data: { session } } = await supabase.auth.getSession()

  if (!session && !isInvite && !isRecovery) {
    router.push('/login')
    return
  }

  user.value = session?.user

  if (
    isInvite ||
    isRecovery ||
    !session?.user?.user_metadata?.password_set
  ) {
    needsPassword.value = true
  }

  if (user.value) {

    const { data } = await supabase
      .from('members')
      .select('*')
      .eq('id', user.value.id)
      .single()

    member.value = data

    name.value = data?.name
    city.value = data?.city
    industry.value = data?.industry
  }

  loading.value = false

})

const setPassword = async () => {

  passwordError.value = ''

  if (!password.value || !confirmPassword.value) {
    passwordError.value = 'Fill both fields'
    return
  }

  if (password.value !== confirmPassword.value) {
    passwordError.value = 'Passwords do not match'
    return
  }

  const { error } = await supabase.auth.updateUser({
    password: password.value,
    data: { password_set: true }
  })

  if (error) {
    passwordError.value = error.message
    return
  }

  needsPassword.value = false

  window.history.replaceState({}, document.title, window.location.pathname)

}

const saveProfile = async () => {

  await supabase
    .from('members')
    .update({
      name: name.value,
      city: city.value,
      industry: industry.value
    })
    .eq('id', user.value.id)

  editing.value = false
}

const uploadAvatar = async (e) => {

  const file = e.target.files[0]
  if (!file) return

  const path = `${user.value.id}/${file.name}`

  await supabase.storage.from('avatars').upload(path, file, { upsert: true })

  const { data } = supabase.storage.from('avatars').getPublicUrl(path)

  await supabase
    .from('members')
    .update({ avatar_url: data.publicUrl })
    .eq('id', user.value.id)

  member.value.avatar_url = data.publicUrl
}

const logout = async () => {
  await supabase.auth.signOut()
  router.push('/login')
}

</script>