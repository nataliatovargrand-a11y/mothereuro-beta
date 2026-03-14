<template>
  <div class="login-wrapper">

    <h1>Member Login</h1>

    <div class="login-card">

      <input
        v-model="email"
        type="email"
        placeholder="Email"
        class="input"
      />

      <input
        v-model="password"
        type="password"
        placeholder="Password"
        class="input"
      />

      <button class="login-btn" @click="login">
        Sign In
      </button>

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

const login = async () => {

  error.value = null

  const { data, error: loginError } = await supabase.auth.signInWithPassword({
    email: email.value,
    password: password.value
  })

  if (loginError) {
    error.value = loginError.message
    return
  }

  // wait for session to exist
  const { data: sessionData } = await supabase.auth.getSession()

  if (sessionData.session) {
    router.push('/account')
  }

}
</script>

<style scoped>

.login-wrapper{
padding:160px 40px;
max-width:420px;
margin:auto;
}

h1{
font-size:36px;
margin-bottom:40px;
}

.login-card{
display:flex;
flex-direction:column;
gap:14px;
}

.input{
padding:12px;
border:1px solid rgba(0,0,0,.15);
border-radius:6px;
}

.login-btn{
background:black;
color:white;
padding:12px;
border:none;
cursor:pointer;
letter-spacing:2px;
font-size:12px;
}

.error{
color:red;
font-size:13px;
margin-top:10px;
}

</style>