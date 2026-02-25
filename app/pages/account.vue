<template>
  <div class="account-wrapper">

    <h1>MEMBER ACCESS</h1>

    <div v-if="!user">
      <input v-model="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button @click="login">Login</button>
    </div>

    <div v-else>
      <p>Logged in as {{ user.email }}</p>
      <p>Status: {{ membershipStatus }}</p>
      <button @click="logout">Logout</button>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const email = ref('')
const password = ref('')
const membershipStatus = ref(null)

onMounted(async () => {
  const { data } = await supabase.auth.getUser()
  if (data.user) {
    user.value = data.user
    await checkMembership()
  }
})

const login = async () => {
  const { error } = await supabase.auth.signInWithPassword({
    email: email.value,
    password: password.value
  })

  if (!error) {
    const { data } = await supabase.auth.getUser()
    user.value = data.user
    await checkMembership()
  }
}

const logout = async () => {
  await supabase.auth.signOut()
  user.value = null
  membershipStatus.value = null
}

const checkMembership = async () => {
  const { data } = await supabase
    .from('members')
    .select('*')
    .eq('email', user.value.email)
    .single()

  if (!data) {
    await supabase.from('members').insert({
      email: user.value.email,
      membership_status: 'pending'
    })
    membershipStatus.value = 'pending'
  } else {
    membershipStatus.value = data.membership_status
  }
}
</script>

<style scoped>

.account-wrapper {
  padding: 100px 24px;
  max-width: 400px;
  margin: auto;
  text-align: center;
}

input {
  display: block;
  width: 100%;
  margin-bottom: 12px;
  padding: 10px;
}

button {
  padding: 10px 20px;
  cursor: pointer;
}

</style>