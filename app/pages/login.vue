<template>

<div class="login-wrapper">

  <h1>Welcome back</h1>

  <p class="sub">
    Access is by invitation only. Enter your details or use your private link.
  </p>

  <div class="login-card">

    <input
      v-model="email"
      type="email"
      placeholder="Email"
      class="input"
      @keyup.enter="login"
    />

    <input
      v-model="password"
      type="password"
      placeholder="Password"
      class="input"
      @keyup.enter="login"
    />

    <button
      class="login-btn"
      @click="login"
      :disabled="loading"
    >
      <span v-if="!loading">Log In</span>
      <span v-else>Signing In...</span>
    </button>

    <button
      class="magic-btn"
      @click="sendMagicLink"
    >
      Send me a login link
    </button>

    <div class="forgot">
      <button
        class="forgot-btn"
        @click="resetPassword"
      >
        Forgot password?
      </button>
    </div>

    <p v-if="message" class="message">
      {{ message }}
    </p>

    <p v-if="error" class="error">
      {{ error }}
    </p>

  </div>

</div>

</template>


<script setup>

import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { supabase } from '~/utils/supabase'

const router = useRouter()

const email = ref('')
const password = ref('')
const error = ref(null)
const message = ref(null)
const loading = ref(false)


const login = async () => {

  loading.value = true
  error.value = null
  message.value = null

  const { error: loginError } =
  await supabase.auth.signInWithPassword({
    email: email.value,
    password: password.value
  })

  if (loginError) {
    error.value = 'We couldn’t find an account with those details. Access is by invitation only.'
    loading.value = false
    return
  }

  router.push('/account')

  loading.value = false
}


const sendMagicLink = async () => {

  error.value = null
  message.value = null

  if (!email.value) {
    error.value = 'Enter your email first'
    return
  }

  const { error: magicError } =
  await supabase.auth.signInWithOtp({
    email: email.value,
    options: {
      emailRedirectTo: window.location.origin + '/account'
    }
  })

  if (magicError) {
    error.value = magicError.message
    return
  }

  message.value = 'Login link sent to your email'
}


const resetPassword = async () => {

  error.value = null
  message.value = null

  if (!email.value) {
    error.value = 'Enter your email first'
    return
  }

  const { error: resetError } =
  await supabase.auth.resetPasswordForEmail(email.value, {
    redirectTo: window.location.origin + '/account'
  })

  if (resetError) {
    error.value = resetError.message
    return
  }

  message.value = 'Password reset email sent'
}

</script>


<style scoped>

.login-wrapper{
  padding:140px 24px;
  max-width:420px;
  margin:auto;
  text-align:center;
}

h1{
  font-size:36px;
  margin-bottom:10px;
}

.sub{
  font-size:14px;
  opacity:.6;
  margin-bottom:40px;
  line-height:1.5;
}

.login-card{
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

.login-btn{
  background:black;
  color:white;
  padding:14px;
  border:none;
  cursor:pointer;
  letter-spacing:1px;
  font-size:12px;
  border-radius:999px;
}

.login-btn:disabled{
  opacity:.6;
  cursor:not-allowed;
}

.magic-btn{
  background:transparent;
  border:1px solid rgba(0,0,0,.15);
  padding:12px;
  border-radius:999px;
  font-size:12px;
  cursor:pointer;
}

.forgot{
  text-align:right;
  margin-top:-6px;
}

.forgot-btn{
  background:none;
  border:none;
  font-size:12px;
  cursor:pointer;
  opacity:.6;
}

.forgot-btn:hover{
  opacity:1;
}

.error{
  color:#c33;
  font-size:13px;
  margin-top:6px;
}

.message{
  color:#2b7a2b;
  font-size:13px;
  margin-top:6px;
}

</style>