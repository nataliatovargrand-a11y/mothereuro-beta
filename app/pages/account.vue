<template>

<div class="account-wrapper">

<div v-if="loading" class="loading">
Loading your account...
</div>

<div v-else>

<!-- HEADER -->

<div class="account-header">

<h1 class="greeting">
Hi, {{ member?.name || 'Member' }}
</h1>

<button class="logout-btn" @click="logout">
Log Out
</button>

</div>


<!-- PROFILE CARD -->

<div class="card">

<div class="card-header">

<h2>Profile</h2>

<button v-if="!editing" @click="startEdit" class="edit-btn">
Edit Profile
</button>

</div>

<div class="profile-card">

<div class="avatar-block">

<img v-if="member?.avatar_url" :src="member.avatar_url" class="avatar"/>

<div v-else class="avatar-placeholder"></div>

<input type="file" @change="uploadAvatar" />

</div>

<div class="profile-info">

<!-- VIEW -->

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

<!-- EDIT -->

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


<!-- MEMBERSHIP -->

<div class="card">

<h2>Your Membership</h2>

<div class="membership-row">

<div class="membership-item">

<label>Tier</label>
<span>{{ member?.membership_tier }}</span>

</div>

<div class="membership-item">

<label>Renewal</label>
<span>{{ member?.renewal_date }}</span>

</div>

</div>

</div>


<!-- SAVED RESOURCES -->

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


<!-- BENEFITS -->

<div class="card">

<h2>Your Membership Benefits</h2>

<div class="benefits">

<div v-if="member?.membership_tier === 'aspiring'">
Community events<br>
Relocation resources<br>
Member introductions
</div>

<div v-if="member?.membership_tier === 'resident'">
Full resource library<br>
Unlimited events<br>
Partner benefits
</div>

<div v-if="member?.membership_tier === 'global'">
Exclusive dinners<br>
Global network<br>
Partner privileges
</div>

</div>

</div>

</div>

</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'
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

onMounted(async () => {

const { data:{ session } } = await supabase.auth.getSession()

if(!session){
router.push('/login')
return
}

user.value = session.user

/* member */

const { data } = await supabase
.from('members')
.select('*')
.eq('id', user.value.id)
.single()

member.value = data

name.value = data?.name
city.value = data?.city
industry.value = data?.industry


/* saved resources */

const { data: saved } = await supabase
.from('saved_resources')
.select(`
resources (*)
`)
.eq('member_id', user.value.id)

savedResources.value = saved?.map(s => s.resources) || []

loading.value = false

})


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

/* PAGE */

.account-wrapper{
padding:140px 40px;
max-width:900px;
margin:auto;
}

/* HEADER */

.account-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:70px;
}

.greeting{
font-size:42px;
font-weight:500;
}

/* GLASS CARD */

.card{
background:rgba(255,255,255,0.6);
backdrop-filter: blur(14px);
-webkit-backdrop-filter: blur(14px);
border:1px solid rgba(255,255,255,0.4);
border-radius:16px;
padding:32px;
margin-bottom:40px;
box-shadow:
0 10px 30px rgba(0,0,0,0.05);
}

/* PROFILE */

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

/* GRID */

.profile-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:22px;
}

label{
font-size:11px;
letter-spacing:2px;
opacity:.6;
display:block;
text-transform:uppercase;
margin-bottom:3px;
}

span{
font-size:15px;
}

/* BUTTONS */

.logout-btn,
.edit-btn,
.save-btn,
.cancel-btn{
border-radius:8px;
padding:10px 18px;
font-size:12px;
letter-spacing:1px;
cursor:pointer;
transition:all .25s ease;
}

/* PRIMARY BUTTON */

.save-btn{
background:black;
color:white;
border:none;
}

.save-btn:hover{
transform:translateY(-1px);
box-shadow:0 6px 16px rgba(0,0,0,0.15);
}

/* SECONDARY */

.logout-btn,
.edit-btn,
.cancel-btn{
background:rgba(255,255,255,0.6);
border:1px solid rgba(0,0,0,0.15);
}

.logout-btn:hover,
.edit-btn:hover,
.cancel-btn:hover{
background:white;
}

/* FILE INPUT */

.file-input{
margin-top:12px;
font-size:12px;
padding:6px;
border-radius:6px;
background:rgba(255,255,255,0.5);
}

/* EDIT FORM */

.edit-form input{
display:block;
width:100%;
padding:10px;
margin-bottom:10px;
border-radius:8px;
border:1px solid rgba(0,0,0,0.1);
background:white;
}

/* MEMBERSHIP */

.membership-row{
display:flex;
gap:60px;
}

.membership-item label{
opacity:.6;
}

.membership-item span{
font-size:18px;
}

/* EVENTS */

.event-card{
border-top:1px solid rgba(0,0,0,0.05);
padding:18px 0;
}

.event-title{
font-weight:500;
}

.event-date{
font-size:13px;
opacity:.6;
}

/* RESOURCES */

.resource-card{
border-top:1px solid rgba(0,0,0,0.05);
padding:18px 0;
display:flex;
justify-content:space-between;
align-items:center;
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

/* BENEFITS */

.benefits{
line-height:1.7;
}

.empty{
opacity:.5;
}

</style>