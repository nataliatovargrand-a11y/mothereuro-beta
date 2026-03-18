<template>

<div class="account-wrapper">

  <div v-if="loading" class="loading">
    Loading your account...
  </div>

  <div v-else>

    <!-- PASSWORD FLOW -->

    <div v-if="needsPassword" class="password-wrapper">

      <div class="password-card">

        <div class="password-label">
          Private Access
        </div>

        <h2 class="password-title">
          Complete Your Access
        </h2>

        <p class="password-sub">
          Create your password to enter the Mother Euro platform
        </p>

        <input
          v-model="password"
          type="password"
          placeholder="Create password"
          class="password-input"
        />

        <button @click="setPassword" class="password-btn">
          ENTER THE PLATFORM
        </button>

      </div>

    </div>

    <!-- HEADER -->

    <div class="account-header">

      <div class="header-left">

        <h1 class="greeting">
          Hi, {{ firstName }}
        </h1>

        <p class="welcome">
          Welcome back to Mother Euro
        </p>

      </div>

      <button class="logout-btn" @click="logout">
        Log Out
      </button>

    </div>

    <!-- PROFILE -->

    <div class="card">

      <div class="card-header">

        <h2>Profile</h2>

        <button
          v-if="!editing"
          @click="startEdit"
          class="upload-btn"
        >
          Edit Profile
        </button>

      </div>

      <div class="profile-card">

        <div class="avatar-block">

          <img
            v-if="member?.avatar_url"
            :src="member.avatar_url"
            class="avatar"
          />

          <div v-else class="avatar-placeholder"></div>

          <label class="upload-btn profile-upload">
            Upload Photo
            <input type="file" @change="uploadAvatar" hidden />
          </label>

        </div>

        <div class="profile-info">

          <div v-if="!editing" class="profile-grid">

            <div>
              <label>Name</label>
              <span>{{ member?.name }}</span>
            </div>

            <div>
              <label>Email</label>
              <span>{{ member?.email }}</span>
            </div>

            <div>
              <label>Membership</label>
              <span>{{ member?.membership_tier }}</span>
            </div>

            <div>
              <label>Renewal</label>
              <span>{{ member?.renewal_date }}</span>
            </div>

            <div>
              <label>Industry</label>
              <span>{{ member?.industry }}</span>
            </div>

            <div>
              <label>City</label>
              <span>{{ member?.city }}</span>
            </div>

          </div>

          <div v-else class="edit-form">

            <input v-model="name" placeholder="Name" />
            <input v-model="city" placeholder="City" />
            <input v-model="industry" placeholder="Industry" />

            <div class="edit-actions">

              <button @click="saveProfile" class="save-btn">
                Save
              </button>

              <button @click="cancelEdit" class="cancel-btn">
                Cancel
              </button>

            </div>

          </div>

        </div>

      </div>

    </div>

    <!-- SAVED -->

    <div class="card">

      <h2>Saved Resources</h2>

      <div v-if="savedResources.length === 0" class="empty">
        No saved resources yet.
      </div>

      <div
        v-for="resource in savedResources"
        :key="resource.id"
        class="resource-card"
      >

        <div class="resource-title">
          {{ resource.title }}
        </div>

        <div class="resource-actions">

          <a
            :href="resource.link_url"
            target="_blank"
            class="view-btn"
          >
            View Resource
          </a>

          <button
            @click="removeSaved(resource.id)"
            class="remove-btn"
          >
            Remove
          </button>

        </div>

      </div>

    </div>

    <!-- EVENTS -->

    <div class="card">

      <h2>Your Upcoming Events</h2>

      <div v-if="upcomingEvents.length === 0" class="empty">
        No upcoming events yet.
      </div>

      <div
        v-for="event in upcomingEvents"
        :key="event.id"
        class="event-card"
      >

        <div class="event-title">
          {{ event.event_title }}
        </div>

        <div class="event-date">
          {{ formatDate(event.event_date) }}
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
const member = ref(null)
const user = ref(null)

const editing = ref(false)

const name = ref('')
const city = ref('')
const industry = ref('')

const savedResources = ref([])
const upcomingEvents = ref([])

const needsPassword = ref(false)
const password = ref('')

const firstName = computed(() => {
  if (!member.value?.name) return 'Member'
  return member.value.name.split(' ')[0]
})

onMounted(async () => {

const { data:{ session } } = await supabase.auth.getSession()

if(!session){
router.push('/login')
return
}

user.value = session.user

// 🔥 BULLETPROOF: detect if user still needs password
const { data: userData } = await supabase.auth.getUser()

if (!userData.user?.user_metadata?.password_set) {
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

if(!password.value) return

const { error } = await supabase.auth.updateUser({
  password: password.value,
  data: {
    password_set: true
  }
})

if(!error){
  needsPassword.value = false

  // clean URL
  window.history.replaceState({}, document.title, window.location.pathname)

  window.location.reload()
}
}

const removeSaved = async(id)=>{
await supabase
.from('saved_resources')
.delete()
.eq('resource_id', id)
.eq('member_id', user.value.id)

savedResources.value =
savedResources.value.filter(r=>r.id!==id)
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

await supabase.storage
.from('avatars')
.upload(path,file,{upsert:true})

const { data } =
supabase.storage.from('avatars').getPublicUrl(path)

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


<style scoped>

.account-wrapper{
padding:120px 24px;
max-width:900px;
margin:auto;
}

.account-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:60px;
}

.greeting{
font-size:38px;
}

.welcome{
font-size:16px;
opacity:.6;
}

.card{
background: rgba(255,255,255,0.35);
backdrop-filter: blur(18px);
border: 1px solid rgba(255,255,255,0.55);
border-radius:18px;
padding:32px;
margin-bottom:32px;
}

.password-card{
text-align:center;
margin-bottom:40px;
}

.password-sub{
opacity:.6;
margin-bottom:20px;
}

.password-input{
width:100%;
max-width:320px;
padding:12px;
border:1px solid rgba(0,0,0,0.1);
border-radius:10px;
margin-bottom:16px;
}

.profile-card{
display:flex;
gap:40px;
align-items:flex-start;
}

.avatar{
width:120px;
height:120px;
border-radius:50%;
object-fit:cover;
}

.avatar-placeholder{
width:120px;
height:120px;
border-radius:50%;
background:#eee;
}

.profile-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:22px;
}

label{
font-size:11px;
letter-spacing:2px;
opacity:.6;
text-transform:uppercase;
}

span{
display:block;
margin-top:4px;
font-size:15px;
}

.logout-btn{
border:1px solid rgba(0,0,0,0.08);
padding:10px 18px;
border-radius:12px;
cursor:pointer;
background:white;
}

.upload-btn{
padding:8px 14px;
border-radius:12px;
border:1px solid rgba(0,0,0,0.1);
cursor:pointer;
font-size:12px;
background:white;
}

.save-btn{
background:black;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
}

.resource-card{
border-top:1px solid rgba(0,0,0,0.05);
padding:18px 0;
display:flex;
justify-content:space-between;
}

.view-btn{
background:black;
color:white;
padding:6px 12px;
border-radius:6px;
text-decoration:none;
font-size:12px;
}

.remove-btn{
border:none;
background:none;
color:#c33;
cursor:pointer;
}

.relocation-content{
display:flex;
align-items:center;
justify-content:space-between;
gap:40px;
}

.relocation-btn{
display:inline-block;
margin-top:14px;
padding:12px 24px;
border-radius:30px;
background:#A8985F;
color:white;
text-decoration:none;
}

.relocation-image{
width:220px;
height:130px;
border-radius:14px;
background-image:url('/images/relocation.jpg');
background-size:cover;
background-position:center;
}

@media (max-width:768px){
.profile-card{
flex-direction:column;
align-items:center;
text-align:center;
}
.profile-grid{
grid-template-columns:1fr;
}
.account-header{
flex-direction:column;
align-items:flex-start;
gap:16px;
}
}

</style>