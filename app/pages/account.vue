<template>

<div class="account-wrapper">

<!-- HEADER -->

<div class="account-header">

<div class="greeting">
Hi, {{ member?.first_name }}
</div>

<div class="welcome">
Welcome back to Mother Euro
</div>

<button class="logout-btn" @click="logout">
Log Out
</button>

</div>


<!-- PROFILE -->

<div class="section">

<h2>Profile</h2>

<div class="profile-card">

<div class="avatar-block">

<img
v-if="member?.avatar_url"
:src="member.avatar_url"
class="avatar"
/>

<div v-else class="avatar-placeholder"></div>

<input type="file" @change="uploadAvatar" class="file-input"/>

</div>

<div class="profile-info">

<div><strong>Name:</strong> {{ member?.first_name }}</div>

<div><strong>Email:</strong> {{ member?.email }}</div>

<div><strong>Membership:</strong> {{ member?.membership_tier }}</div>

<div><strong>Renewal date:</strong> {{ member?.renewal_date || '—' }}</div>

<div><strong>Industry:</strong> {{ member?.industry || '—' }}</div>

<div><strong>City:</strong> {{ member?.city || '—' }}</div>

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


<!-- MEMBERSHIP BENEFITS -->

<div class="section">

<h2>Your Membership Benefits</h2>

<div class="benefits-card">

<div v-if="member?.membership_tier === 'aspiring'">
• Access to relocation resources  
• Community events  
• Member network
</div>

<div v-if="member?.membership_tier === 'resident'">
• Full resource library  
• Unlimited events  
• Private partner benefits
</div>

<div v-if="member?.membership_tier === 'global'">
• Global member network  
• Exclusive dinners  
• Partner privileges  
• Up to 4 events per year
</div>

</div>

</div>

</div>

</template>



<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const member = ref(null)
const bookings = ref([])

onMounted(async () => {

const { data: userData } = await supabase.auth.getUser()

if(!userData.user) return

const { data } = await supabase
.from('members')
.select('*')
.eq('email', userData.user.email)
.single()

member.value = data

const { data: bookingData } = await supabase
.from('bookings')
.select('*')
.eq('user_email', userData.user.email)
.order('event_date')

bookings.value = bookingData || []

})


const upcomingEvents = computed(() => {

const today = new Date()

return bookings.value.filter(event =>
new Date(event.event_date) >= today
)

})

const pastEvents = computed(() => {

const today = new Date()

return bookings.value.filter(event =>
new Date(event.event_date) < today
)

})


const uploadAvatar = async (event) => {

const file = event.target.files[0]

if(!file || !member.value) return

const filePath = `${member.value.id}-${Date.now()}`

await supabase.storage
.from('avatars')
.upload(filePath, file)

const { data } = supabase
.storage
.from('avatars')
.getPublicUrl(filePath)

await supabase
.from('members')
.update({ avatar_url: data.publicUrl })
.eq('id', member.value.id)

member.value.avatar_url = data.publicUrl

}


const logout = async () => {

await supabase.auth.signOut()
location.reload()

}


const formatDate = (date) => {

return new Date(date).toLocaleDateString('en-US', {
month: 'long',
day: 'numeric',
year: 'numeric'
})

}

</script>



<style scoped>

.account-wrapper{
padding:140px 40px;
max-width:900px;
margin:auto;
}

.account-header{
margin-bottom:60px;
}

.greeting{
font-size:36px;
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

.profile-card{
display:flex;
gap:40px;
align-items:center;
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

</style>