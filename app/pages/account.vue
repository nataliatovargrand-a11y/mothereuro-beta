<template>
  <div class="account-wrapper">

    <h1>Account</h1>

    <div class="account-card">

      <div class="row">
        <span class="label">Name</span>
        <span class="value">{{ firstName }}</span>
      </div>

      <div class="row">
        <span class="label">Email</span>
        <span class="value">{{ user?.email }}</span>
      </div>

      <div class="divider"></div>

      <button class="logout-btn" @click="logout">
        Log Out
      </button>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { supabase } from '~/utils/supabase'

const router = useRouter()

const user = ref(null)
const firstName = ref(null)

onMounted(async () => {
  const { data } = await supabase.auth.getUser()

  if (data.user) {
    user.value = data.user

    const { data: member } = await supabase
      .from('members')
      .select('first_name')
      .eq('email', data.user.email)
      .single()

    firstName.value = member?.first_name
  }
})

const logout = async () => {
  await supabase.auth.signOut()
  router.push('/')
}
</script>

<style scoped>

.account-wrapper {
  padding: 160px 40px 120px 40px;
  max-width: 700px;
  margin: 0 auto;
}

.account-wrapper h1 {
  margin-bottom: 40px;
}

.account-card {
  background: white;
  padding: 40px;
  border-radius: 20px;
  border: 1px solid #eee;
}

.row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.label {
  font-size: 11px;
  letter-spacing: 2px;
  opacity: 0.6;
}

.value {
  font-size: 14px;
}

.divider {
  height: 1px;
  background: #eee;
  margin: 30px 0;
}

.logout-btn {
  background: black;
  color: white;
  padding: 12px 20px;
  border: none;
  letter-spacing: 1px;
  cursor: pointer;
}

</style>