<template>

<div class="auth-wrapper">

  <h1 class="auth-title">
    Complete Your Access
  </h1>

  <p class="auth-sub">
    Create your password to enter the Mother Euro platform.
  </p>

  <div class="auth-card">

    <input
      v-model="password"
      type="password"
      placeholder="Create password"
      class="input"
    />

    <input
      v-model="confirmPassword"
      type="password"
      placeholder="Confirm password"
      class="input"
    />

    <button
      class="primary-btn"
      @click="updatePassword"
      :disabled="loading"
    >
      <span v-if="!loading">Enter the Platform</span>
      <span v-else>Setting password...</span>
    </button>

    <p v-if="error" class="error">
      {{ error }}
    </p>

    <p v-if="message" class="message">
      {{ message }}
    </p>

  </div>

</div>

</template>


<script setup>

import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { supabase } from '~/utils/supabase'

const router = useRouter()

const password = ref('')
const confirmPassword = ref('')
const error = ref(null)
const message = ref(null)
const loading = ref(false)


const updatePassword = async () => {

  error.value = null
  message.value = null

  if (password.value !== confirmPassword.value) {
    error.value = 'Passwords do not match'
    return
  }

  if (password.value.length < 6) {
    error.value = 'Password must be at least 6 characters'
    return
  }

  loading.value = true

  const { error: updateError } = await supabase.auth.updateUser({
    password: password.value
  })

  if (updateError) {
    error.value = updateError.message
    loading.value = false
    return
  }

  message.value = 'Password set successfully'

  setTimeout(() => {
    router.push('/account')
  }, 1000)

}

</script>


<style scoped>

.auth-wrapper{
  padding:140px 24px;
  max-width:420px;
  margin:auto;
  text-align:center;
}

.auth-title{
  font-size:36px;
  margin-bottom:10px;
}

.auth-sub{
  font-size:14px;
  opacity:.6;
  margin-bottom:40px;
  line-height:1.5;
}

.auth-card{
  display:flex;
  flex-direction:column;
  gap:14px;
}

.input{
  padding:14px;
  border:1px solid rgba(0,0,0,.12);
  border-radius:10px;
  font-size:14px;
}

.primary-btn{
  background:black;
  color:white;
  padding:14px;
  border:none;
  cursor:pointer;
  letter-spacing:1px;
  font-size:12px;
  border-radius:999px;
}

.primary-btn:disabled{
  opacity:.6;
}

.error{
  color:#c33;
  font-size:13px;
}

.message{
  color:#2b7a2b;
  font-size:13px;
}

</style>