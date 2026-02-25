<template>
  <div class="account-wrapper">

    <h1>MEMBER ACCESS</h1>

    <div v-if="!user">

      <input v-model="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />

      <button class="primary-btn" @click="login">
        LOGIN
      </button>

      <button class="secondary-btn" @click="signup">
        REQUEST ACCESS
      </button>

    </div>

    <div v-else>
      <p class="status">Logged in as {{ user.email }}</p>
      <p class="status">Status: {{ membershipStatus }}</p>

      <button class="primary-btn" @click="logout">
        LOGOUT
      </button>
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
  } else {
    alert(error.message)
  }
}

const signup = async () => {
  const { error } = await supabase.auth.signUp({
    email: email.value,
    password: password.value
  })

  if (!error) {
    alert("Application received. Awaiting approval.")
  } else {
    alert(error.message)
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
  padding: 140px 24px;
  max-width: 420px;
  margin: auto;
  text-align: center;
}

h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 36px;
  margin-bottom: 40px;
}

input {
  display: block;
  width: 100%;
  margin-bottom: 18px;
  padding: 14px;
  border: 1px solid #ddd;
  font-size: 14px;
}

.primary-btn {
  width: 100%;
  background: #A8985F;
  color: white;
  border: none;
  padding: 14px;
  letter-spacing: 3px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
  margin-bottom: 14px;
}

.primary-btn:hover {
  background: #5E5130;
}

.secondary-btn {
  width: 100%;
  background: transparent;
  border: 1px solid #A8985F;
  color: #A8985F;
  padding: 14px;
  letter-spacing: 3px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.secondary-btn:hover {
  background: #A8985F;
  color: white;
}

.status {
  margin-bottom: 20px;
}

</style>