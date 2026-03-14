<template>

<div class="account-wrapper">

<!-- LOADING -->

<div v-if="loading" class="loading">
Loading your account...
</div>

<div v-else>

<!-- HEADER -->

<div class="account-header">

<h1 class="greeting">
Hi, {{ member?.name || 'Member' }}
</h1>

<div class="welcome">
Welcome back to Mother Euro
</div>

<button class="logout-btn" @click="logout">
Log Out
</button>

</div>


<!-- PROFILE -->

<div class="section">

<div class="section-header">

<h2>Profile</h2>

<button v-if="!editing" @click="startEdit" class="edit-btn">
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

<input
type="file"
class="file-input"
@change="uploadAvatar"
/>

</div>

<div class="profile-info">

<!-- VIEW MODE -->

<div v-if="!editing" class="profile-grid">

<div><strong>Name</strong><span>{{ member?.name }}</span></div>
<div><strong>Email</strong><span>{{ member?.email }}</span></div>
<div><strong>Membership</strong><span>{{ member?.membership_tier }}</span></div>
<div><strong>Renewal</strong><span>{{ member?.renewal_date || '—' }}</span></div>
<div><strong>Industry</strong><span>{{ member?.industry || '—' }}</span></div>
<div><strong>City</strong><span>{{ member?.city || '—' }}</span></div>

</div>

<!-- EDIT MODE -->

<div v-else class="edit-fields">

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


<!-- MEMBERSHIP -->

<div class="section">

<h2>Your Membership</h2>

<div class="membership-card">

<div class="membership-row">

<div class="membership-item">
<div class="label">Tier</div>
<div class="value">{{ member?.membership_tier }}</div>
</div>

<div class="membership-item">
<div class="label">Renewal</div>
<div class="value">{{ member?.renewal_date || '—' }}</div>
</div>

<div v-if="member?.membership_tier === 'global'" class="membership-item">
<div class="label">Events Remaining</div>
<div class="value">{{ remainingEvents }} / 4</div>
</div>

</div>

</div>

</div>


<!-- EVENTS -->

<div class="section">

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


<!-- BENEFITS -->

<div class="section">

<h2>Your Membership Benefits</h2>

<div class="benefits-card">

<div v-if="member?.membership_tier === 'aspiring'">
• Community events<br>
• Relocation resources<br>
• Member introductions
</div>

<div v-if="member?.membership_tier === 'resident'">
• Full resource library<br>
• Unlimited events<br>
• Partner benefits
</div>

<div v-if="member?.membership_tier === 'global'">
• Exclusive member dinners<br>
• Global network access<br>
• Partner privileges<br>
• Up to 4 events per year
</div>

</div>

</div>

</div>

</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { supabase } from '~/utils/supabase'

const router = useRouter()

const member = ref(null)
const user = ref(null)

const loading = ref(true)
const editing = ref(false)

const name = ref('')
const city = ref('')
const industry = ref('')

const upcomingEvents = ref([])
const remainingEvents = ref(4)

onMounted(async () => {

const { data:{ session } } = await supabase.auth.getSession()

if(!session){
router.push('/login')
return
}

user.value = session.user

const { data, error } = await supabase
.from('members')
.select('*')
.eq('id', user.value.id)
.single()

if(error){
console.error(error)
}

member.value = data

name.value = data?.name
city.value = data?.city
industry.value = data?.industry

loading.value = false

})


const startEdit = () => {
editing.value = true
}

const cancelEdit = () => {
editing.value = false
}

const saveProfile = async () => {

await supabase
.from('members')
.update({
name:name.value,
city:city.value,
industry:industry.value
})
.eq('id',user.value.id)

member.value.name = name.value
member.value.city = city.value
member.value.industry = industry.value

editing.value = false

}

const uploadAvatar = async (event) => {

const file = event.target.files[0]
if(!file) return

const filePath = `${user.value.id}/${file.name}`

await supabase.storage
.from('avatars')
.upload(filePath,file,{upsert:true})

const { data } = supabase.storage
.from('avatars')
.getPublicUrl(filePath)

await supabase
.from('members')
.update({ avatar_url:data.publicUrl })
.eq('id',user.value.id)

member.value.avatar_url = data.publicUrl

}

const logout = async () => {
await supabase.auth.signOut()
router.push('/login')
}

const formatDate = (date) => {
return new Date(date).toLocaleDateString()
}

</script>


<style scoped>

.account-wrapper{
padding:140px 40px;
max-width:900px;
margin:auto;
}

.loading{
opacity:.6;
font-size:16px;
}

.account-header{
margin-bottom:70px;
}

.greeting{
font-size:42px;
margin-bottom:6px;
}

.welcome{
opacity:.6;
margin-bottom:20px;
}

.logout-btn{
border:1px solid black;
background:white;
padding:10px 18px;
font-size:12px;
letter-spacing:2px;
cursor:pointer;
}

/* SECTION */

.section{
margin-bottom:80px;
}

.section-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

/* PROFILE */

.profile-card{
display:flex;
gap:40px;
align-items:flex-start;
border:1px solid rgba(0,0,0,0.06);
padding:30px;
border-radius:14px;
background:white;
}

.avatar-block{
display:flex;
flex-direction:column;
align-items:center;
}

.avatar{
width:120px;
height:120px;
border-radius:50%;
object-fit:cover;
margin-bottom:10px;
}

.avatar-placeholder{
width:120px;
height:120px;
border-radius:50%;
background:#eee;
margin-bottom:10px;
}

.file-input{
font-size:12px;
}

.profile-info{
flex:1;
}

.profile-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:16px 30px;
}

.profile-grid strong{
display:block;
font-size:11px;
letter-spacing:2px;
opacity:.5;
text-transform:uppercase;
margin-bottom:3px;
}

.profile-grid span{
font-size:15px;
}

/* EDIT */

.edit-fields input{
display:block;
width:100%;
margin-bottom:10px;
padding:10px;
border:1px solid #ddd;
}

.edit-actions{
display:flex;
gap:10px;
margin-top:10px;
}

.save-btn{
background:black;
color:white;
border:none;
padding:10px 18px;
cursor:pointer;
}

.cancel-btn{
border:1px solid black;
background:white;
padding:10px 18px;
cursor:pointer;
}

.edit-btn{
border:1px solid black;
background:white;
padding:6px 14px;
font-size:11px;
letter-spacing:1px;
cursor:pointer;
}

/* MEMBERSHIP */

.membership-card{
border:1px solid rgba(0,0,0,0.08);
padding:28px;
border-radius:12px;
background:white;
}

.membership-row{
display:flex;
gap:60px;
flex-wrap:wrap;
}

.membership-item{
display:flex;
flex-direction:column;
}

.label{
font-size:11px;
letter-spacing:2px;
opacity:.6;
text-transform:uppercase;
margin-bottom:6px;
}

.value{
font-size:18px;
}

/* EVENTS */

.event-card{
border:1px solid rgba(0,0,0,0.08);
padding:18px;
margin-bottom:12px;
border-radius:10px;
background:white;
}

.event-title{
font-weight:500;
margin-bottom:4px;
}

.event-date{
font-size:13px;
opacity:.6;
}

/* BENEFITS */

.benefits-card{
border:1px solid rgba(0,0,0,0.08);
padding:22px;
border-radius:12px;
background:white;
line-height:1.7;
}

.empty{
opacity:.5;
font-size:14px;
}

</style>