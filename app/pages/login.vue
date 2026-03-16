<template>

<div class="login-wrapper">

<h1>Member Login</h1>

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

<span v-if="!loading">Sign In</span>
<span v-else>Signing In...</span>

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

if(loginError){

error.value = loginError.message
loading.value = false
return

}

const { data: sessionData } =
await supabase.auth.getSession()

if(sessionData.session){

router.push('/account')

}

loading.value = false

}


const resetPassword = async () => {

error.value = null
message.value = null

if(!email.value){

error.value = "Enter your email first"
return

}

const { error: resetError } =
await supabase.auth.resetPasswordForEmail(email.value,{

redirectTo: window.location.origin + '/update-password'

})

if(resetError){

error.value = resetError.message
return

}

message.value = "Password reset email sent"

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
font-size:14px;
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

.login-btn:disabled{
opacity:.6;
cursor:not-allowed;
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
opacity:.7;
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