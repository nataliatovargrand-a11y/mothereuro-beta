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

<!-- DASHBOARD -->

<div class="dashboard">

<div class="dashboard-card">

<div class="dashboard-label">
Membership
</div>

<div class="dashboard-value">
{{ member?.membership_tier }}
</div>

</div>


<div class="dashboard-card">

<div class="dashboard-label">
Renewal
</div>

<div class="dashboard-value">
{{ member?.renewal_date || '—' }}
</div>

</div>


<div class="dashboard-card">

<div class="dashboard-label">
Events Remaining
</div>

<div class="dashboard-value">
{{ remainingEvents }}
</div>

</div>


<div class="dashboard-card">

<div class="dashboard-label">
Saved Resources
</div>

<div class="dashboard-value">
{{ savedResources.length }}
</div>

</div>

</div>

<!-- PROFILE -->

<div class="section">

<div class="section-header">
<h2>Profile</h2>

<button
v-if="!editing"
class="edit-btn"
@click="startEdit"
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

<input
type="file"
class="file-input"
@change="uploadAvatar"
/>

</div>

<div class="profile-info">

<!-- VIEW MODE -->

<div v-if="!editing">

<div><strong>Name:</strong> {{ member?.name || '—' }}</div>
<div><strong>Email:</strong> {{ member?.email }}</div>
<div><strong>Membership:</strong> {{ member?.membership_tier }}</div>
<div><strong>Renewal date:</strong> {{ member?.renewal_date || '—' }}</div>
<div><strong>Industry:</strong> {{ member?.industry || '—' }}</div>
<div><strong>City:</strong> {{ member?.city || '—' }}</div>

</div>


<!-- EDIT MODE -->

<div v-else class="edit-fields">

<input v-model="name" placeholder="Name" />

<input v-model="city" placeholder="City" />

<input v-model="industry" placeholder="Industry" />

<div class="edit-actions">

<button class="save-btn" @click="saveProfile">
Save
</button>

<button class="cancel-btn" @click="cancelEdit">
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
<div class="value">
{{ member?.membership_tier }}
</div>
</div>

<div class="membership-item">
<div class="label">Renewal</div>
<div class="value">
{{ member?.renewal_date || '—' }}
</div>
</div>

<div
v-if="member?.membership_tier === 'global'"
class="membership-item"
>
<div class="label">Events Remaining</div>
<div class="value">
{{ remainingEvents }} / 4
</div>
</div>

</div>

</div>

</div>



<!-- UPCOMING EVENTS -->

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



<!-- PAST EVENTS -->

<div class="section">

<h2>Your Past Events</h2>

<div v-if="pastEvents.length === 0" class="empty">
No past events yet.
</div>

<div
v-for="event in pastEvents"
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

<!-- SAVED RESOURCES -->

<div class="section">

<h2>Saved Resources</h2>

<div v-if="savedResources.length === 0" class="empty">
You haven't saved any resources yet.
</div>

<div class="resources-grid">

<div
v-for="resource in savedResources"
:key="resource.id"
class="resource-card"
>

<img
:src="resource.image_url"
class="resource-image"
/>

<div class="resource-info">

<h3>{{ resource.title }}</h3>

<a
:href="resource.link_url"
target="_blank"
class="resource-btn"
>
View Resource
</a>

</div>

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
const pastEvents = ref([])
const remainingEvents = ref(4)
const savedResources = ref([])



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

const { data: saved } = await supabase
.from('saved_resources')
.select(`
resource_id,
resources (*)
`)
.eq('member_id', user.value.id)

savedResources.value = saved?.map(r => r.resources) || []

const startEdit = () => {

editing.value = true

name.value = member.value?.name
city.value = member.value?.city
industry.value = member.value?.industry

}



const cancelEdit = () => {

editing.value = false

}



const saveProfile = async () => {

const { error } = await supabase
.from('members')
.update({
name: name.value,
city: city.value,
industry: industry.value
})
.eq('id', user.value.id)

if(error){
console.error(error)
return
}

member.value.name = name.value
member.value.city = city.value
member.value.industry = industry.value

editing.value = false

}



const uploadAvatar = async (event) => {

const file = event.target.files[0]

if(!file) return

const filePath = `${user.value.id}/${file.name}`

const { error } = await supabase.storage
.from('avatars')
.upload(filePath,file,{ upsert:true })

if(error){
console.error(error)
return
}

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

if(!date) return ''

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
font-size:16px;
opacity:.6;
}

.account-header{
margin-bottom:60px;
}

.greeting{
font-size:40px;
margin-bottom:6px;
}

.welcome{
opacity:.6;
margin-bottom:20px;
}

.logout-btn{
border:1px solid black;
background:white;
padding:10px 16px;
cursor:pointer;
font-size:12px;
letter-spacing:2px;
}

.section{
margin-bottom:70px;
}

.section-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.edit-btn{
border:1px solid black;
padding:8px 14px;
background:white;
cursor:pointer;
font-size:12px;
letter-spacing:2px;
}

.profile-card{
display:flex;
gap:40px;
align-items:flex-start;
}

.avatar{
width:90px;
height:90px;
border-radius:50%;
object-fit:cover;
}

.avatar-placeholder{
width:90px;
height:90px;
border-radius:50%;
background:#eee;
}

.file-input{
margin-top:10px;
}

.profile-info{
display:flex;
flex-direction:column;
gap:8px;
}

.edit-fields input{
padding:10px;
border:1px solid #ddd;
margin-bottom:10px;
}

.edit-actions{
display:flex;
gap:10px;
}

.save-btn{
background:black;
color:white;
padding:10px 14px;
border:none;
cursor:pointer;
}

.cancel-btn{
border:1px solid black;
background:white;
padding:10px 14px;
cursor:pointer;
}

.membership-card{
border:1px solid rgba(0,0,0,0.08);
padding:28px;
border-radius:10px;
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
margin-bottom:6px;
text-transform:uppercase;
}

.value{
font-size:18px;
}

.event-card{
border:1px solid rgba(0,0,0,0.08);
padding:16px;
margin-bottom:12px;
border-radius:8px;
}

.event-title{
font-weight:500;
margin-bottom:4px;
}

.event-date{
opacity:.6;
font-size:13px;
}

.benefits-card{
border:1px solid rgba(0,0,0,0.08);
padding:20px;
border-radius:8px;
line-height:1.7;
}

.empty{
opacity:.5;
font-size:14px;
}
.dashboard{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:60px;
}

.dashboard-card{
background:white;
border:1px solid rgba(0,0,0,0.06);
border-radius:12px;
padding:20px;
}

.dashboard-label{
font-size:11px;
letter-spacing:2px;
opacity:.6;
text-transform:uppercase;
margin-bottom:6px;
}

.dashboard-value{
font-size:20px;
font-weight:500;
}

.resources-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:24px;
}

.resource-card{
border:1px solid rgba(0,0,0,0.06);
border-radius:10px;
overflow:hidden;
background:white;
}

.resource-image{
width:100%;
height:140px;
object-fit:cover;
}

.resource-info{
padding:16px;
}

.resource-btn{
display:inline-block;
margin-top:10px;
padding:8px 14px;
background:black;
color:white;
font-size:11px;
letter-spacing:2px;
text-decoration:none;
}

</style>