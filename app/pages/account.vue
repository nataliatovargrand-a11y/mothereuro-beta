<template>

<div class="account-wrapper">

  <div v-if="loading" class="loading">
    Loading your account...
  </div>

  <div v-else>

    <!-- PASSWORD FLOW -->

    <div v-if="needsPassword" class="password-wrapper">

      <div class="password-card">

        <h2 class="password-title">
          {{ isRecovery ? 'Reset Your Password' : 'Complete Your Access' }}
        </h2>

        <p class="password-sub">
          {{ isRecovery
            ? 'Enter a new password for your account'
            : 'Create your password to enter the Mother Euro platform'
          }}
        </p>

        <input v-model="password" type="password" placeholder="Create password" class="password-input"/>
        <input v-model="confirmPassword" type="password" placeholder="Confirm password" class="password-input"/>

        <p v-if="passwordError" class="password-error">{{ passwordError }}</p>

        <button @click="setPassword" class="password-btn">
          ENTER THE PLATFORM
        </button>

      </div>

    </div>

    <!-- ACCOUNT -->

    <div v-else>

      <!-- HEADER -->

      <div class="account-header">

        <div>
          <h1 class="greeting">Hi, {{ firstName }}</h1>
          <p class="welcome">Welcome back to Mother Euro</p>
        </div>

        <button class="logout-btn" @click="logout">
          Log Out
        </button>

      </div>

      <!-- PROFILE CARD -->

      <div class="card profile-card">

        <div class="profile-top">

          <button
            v-if="!editing"
            @click="startEdit"
            class="edit-btn"
          >
            Edit Profile
          </button>

        </div>

        <div class="profile-content">

          <div class="avatar-block">

            <img
              v-if="member?.avatar_url"
              :src="member.avatar_url"
              class="avatar"
            />

            <div v-else class="avatar-placeholder"></div>

            <label class="upload-btn">
              Upload Photo
              <input type="file" @change="uploadAvatar" hidden />
            </label>

          </div>

          <div class="profile-info">

            <div v-if="!editing" class="profile-grid">

              <div><label>Name</label><span>{{ member?.name }}</span></div>
              <div><label>Email</label><span>{{ member?.email }}</span></div>
              <div><label>Membership</label><span>{{ member?.membership_tier || '—' }}</span></div>
              <div><label>Renewal</label><span>{{ formattedRenewal }}</span></div>
              <div><label>Industry</label><span>{{ member?.industry }}</span></div>
              <div><label>City</label><span>{{ member?.city }}</span></div>

            </div>

            <div v-else class="edit-form">

              <input v-model="name" placeholder="Name" />
              <input v-model="city" placeholder="City" />
              <input v-model="industry" placeholder="Industry" />

              <div class="edit-actions">
                <button @click="saveProfile" class="save-btn">Save</button>
                <button @click="cancelEdit" class="cancel-btn">Cancel</button>
              </div>

            </div>

          </div>

        </div>

      </div>

      <!-- SAVED -->

      <div class="card">

        <h2 class="section-title">Saved Resources</h2>

        <div v-if="!safeSavedResources.length" class="empty">
          No saved resources yet.
        </div>

        <div v-for="resource in safeSavedResources" :key="resource.id" class="resource-card">
          <div>{{ resource.title }}</div>
          <div>
            <a :href="resource.link_url" target="_blank" class="view-btn">View</a>
            <button @click="removeSaved(resource.id)" class="remove-btn">Remove</button>
          </div>
        </div>

      </div>

      <!-- EVENTS -->

      <div class="card">

        <h2 class="section-title">Your Upcoming Events</h2>

        <div v-if="!safeEvents.length" class="empty">
          No upcoming events yet.
        </div>

        <div v-for="event in safeEvents" :key="event.id" class="event-card">
          <div>{{ event.event_title }}</div>
          <div class="event-date">{{ formatDate(event.event_date) }}</div>
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

const savedResources = ref([])
const upcomingEvents = ref([])

const needsPassword = ref(false)
const isRecovery = ref(false)

const password = ref('')
const confirmPassword = ref('')
const passwordError = ref('')

const safeSavedResources = computed(() => savedResources.value || [])
const safeEvents = computed(() => upcomingEvents.value || [])

const firstName = computed(() => {
  return member.value?.name?.split(' ')[0] || 'Member'
})

const formattedRenewal = computed(() => {
  if (!member.value?.renewal_date) return '—'
  return new Date(member.value.renewal_date).toLocaleDateString()
})

onMounted(async () => {

  const url = new URL(window.location.href)

  const access_token = url.searchParams.get('access_token')
  const refresh_token = url.searchParams.get('refresh_token')
  const type = url.searchParams.get('type')

  // Set session if coming from email link
  if (access_token && refresh_token) {
    await supabase.auth.setSession({
      access_token,
      refresh_token
    })
  }

  if (type === 'recovery') {
    isRecovery.value = true
  }

  const { data: { session } } = await supabase.auth.getSession()

  if (!session) {
    router.push('/login')
    return
  }

  user.value = session.user

  // Only trigger password when needed
  if (
    type === 'recovery' ||
    !session.user?.user_metadata?.password_set
  ) {
    needsPassword.value = true
  }

  const { data } = await supabase
    .from('members')
    .select('*')
    .eq('id', user.value.id)
    .single()

  member.value = data

  name.value = data?.name
  city.value = data?.city
  industry.value = data?.industry

  const { data: saved } = await supabase
    .from('saved_resources')
    .select(`resources (*)`)
    .eq('member_id', user.value.id)

  savedResources.value = saved?.map(s => s.resources) || []

  loading.value = false

})

const setPassword = async () => {

  passwordError.value = ''

  if (!password.value || !confirmPassword.value) {
    passwordError.value = 'Please fill both fields'
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

  // Exit password flow
  needsPassword.value = false

  // Clean URL
  window.history.replaceState({}, document.title, '/account')

  // Force UI refresh
  router.replace('/account')

}

const removeSaved = async(id)=>{
  await supabase
    .from('saved_resources')
    .delete()
    .eq('resource_id', id)
    .eq('member_id', user.value.id)

  savedResources.value = savedResources.value.filter(r=>r.id!==id)
}

const startEdit = ()=> editing.value=true
const cancelEdit = ()=> editing.value=false

const saveProfile = async ()=>{
  await supabase
    .from('members')
    .update({
      name:name.value,
      city:city.value,
      industry:industry.value
    })
    .eq('id',user.value.id)

  member.value.name=name.value
  member.value.city=city.value
  member.value.industry=industry.value

  editing.value=false
}

const uploadAvatar = async(e)=>{
  const file=e.target.files[0]
  if(!file) return

  const path=`${user.value.id}/${file.name}`

  await supabase.storage.from('avatars').upload(path,file,{upsert:true})

  const { data } = supabase.storage.from('avatars').getPublicUrl(path)

  await supabase
    .from('members')
    .update({avatar_url:data.publicUrl})
    .eq('id',user.value.id)

  member.value.avatar_url=data.publicUrl
}

const logout = async()=>{
  await supabase.auth.signOut()
  router.push('/login')
}

const formatDate=(d)=>{
  return new Date(d).toLocaleDateString()
}

</script>
<style>

/* PASSWORD FLOW */

.password-wrapper{
  min-height:70vh;
  display:flex;
  align-items:center;
  justify-content:center;
}

.password-card{
  width:100%;
  max-width:420px;
  background:white;
  border-radius:20px;
  padding:40px 32px;
  box-shadow:0 10px 30px rgba(0,0,0,0.05);
  text-align:left;
}

/* TITLE */

.password-title{
  font-size:32px;
  margin-bottom:12px;
  font-weight:400;
  line-height:1.2;
}

.password-sub{
  font-size:15px;
  opacity:.6;
  margin-bottom:30px;
  line-height:1.5;
}

/* INPUTS */

.password-input{
  width:100%;
  border:none;
  border-bottom:1px solid rgba(0,0,0,0.2);
  padding:14px 0;
  margin-bottom:18px;
  font-size:16px;
  background:transparent;
}

.password-input:focus{
  outline:none;
  border-bottom:1px solid #A8985F;
}

/* ERROR */

.password-error{
  color:#c33;
  font-size:13px;
  margin-bottom:14px;
}

/* BUTTON */

.password-btn{
  width:100%;
  background:#A8985F;
  color:white;
  border:none;
  padding:14px;
  border-radius:30px;
  font-size:12px;
  letter-spacing:2px;
  cursor:pointer;
  transition:opacity .2s ease;
}

.password-btn:hover{
  opacity:.85;
}

/* HEADER */

.account-header{
display:flex;
justify-content:space-between;
align-items:flex-start;
margin-bottom:50px;
}

.greeting{
font-size:48px;
font-weight:400;
margin-bottom:6px;
}

.welcome{
font-size:16px;
opacity:.6;
}

/* BUTTONS */

.logout-btn{
padding:10px 18px;
border-radius:999px;
border:1px solid rgba(0,0,0,0.1);
background:white;
cursor:pointer;
}

.edit-btn{
padding:8px 16px;
border-radius:999px;
border:1px solid rgba(0,0,0,0.1);
background:white;
cursor:pointer;
}

.upload-btn{
font-size:12px;
padding:6px 12px;
border-radius:999px;
border:1px solid rgba(0,0,0,0.1);
cursor:pointer;
background:white;
}

.save-btn{
background:black;
color:white;
padding:10px 16px;
border-radius:10px;
border:none;
}

.cancel-btn{
margin-left:10px;
}

/* CARD */

.card{
background:white;
border-radius:20px;
padding:30px;
margin-bottom:30px;
box-shadow:0 8px 25px rgba(0,0,0,0.04);
}

/* PROFILE */

.profile-top{
margin-bottom:20px;
}

.profile-content{
display:flex;
gap:40px;
align-items:flex-start;
}

.avatar-block{
display:flex;
flex-direction:column;
align-items:center;
gap:12px;
}

.avatar{
width:110px;
height:110px;
border-radius:50%;
object-fit:cover;
}

.avatar-placeholder{
width:110px;
height:110px;
border-radius:50%;
background:#eee;
}

.profile-info{
flex:1;
}

.profile-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

label{
font-size:11px;
letter-spacing:1.5px;
text-transform:uppercase;
opacity:.5;
display:block;
margin-bottom:4px;
}

span{
font-size:16px;
}

/* SECTIONS */

.section-title{
font-size:28px;
margin-bottom:16px;
}

/* LISTS */

.resource-card,
.event-card{
display:flex;
justify-content:space-between;
padding:14px 0;
border-top:1px solid rgba(0,0,0,0.05);
}

.view-btn{
background:black;
color:white;
padding:6px 12px;
border-radius:6px;
text-decoration:none;
margin-right:8px;
}

.remove-btn{
background:none;
border:none;
color:#c33;
cursor:pointer;
}

.event-date{
opacity:.6;
font-size:14px;
}

/* EMPTY */

.empty{
opacity:.6;
padding:10px 0;
}

/* MOBILE */

@media (max-width:768px){

.profile-content{
flex-direction:column;
align-items:center;
text-align:center;
}

.profile-grid{
grid-template-columns:1fr;
}

.account-header{
flex-direction:column;
gap:12px;
}

}

</style>