<template>

<div class="account-wrapper">

<!-- HEADER -->

<div class="account-header">

<h1 class="greeting">
Hi, {{ member?.name }}
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

<h2>Profile</h2>

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

<div><strong>Name:</strong> {{ member?.name }}</div>
<div><strong>Email:</strong> {{ member?.email }}</div>
<div><strong>Membership:</strong> {{ member?.membership_tier }}</div>
<div><strong>Renewal date:</strong> {{ member?.renewal_date || '—' }}</div>
<div><strong>Industry:</strong> {{ member?.industry || '—' }}</div>
<div><strong>City:</strong> {{ member?.city || '—' }}</div>

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

</template>



<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'
import { useRouter } from 'vue-router'

const router = useRouter()

const member = ref(null)
const bookings = ref([])
const user = ref(null)



onMounted(async () => {

const { data } = await supabase.auth.getUser()

user.value = data.user

if (!user.value) return



/* MEMBER PROFILE */

const { data: memberData } = await supabase
.from('members')
.select('*')
.eq('email', user.value.email)
.single()

member.value = memberData



/* BOOKINGS */

const { data: bookingData } = await supabase
.from('bookings')
.select('*')
.eq('user_email', user.value.email)
.order('event_date', { ascending:true })

bookings.value = bookingData || []

})



/* UPCOMING EVENTS */

const upcomingEvents = computed(() => {

const today = new Date()

return bookings.value.filter(event =>
new Date(event.event_date) >= today
)

})



/* PAST EVENTS */

const pastEvents = computed(() => {

const today = new Date()

return bookings.value.filter(event =>
new Date(event.event_date) < today
)

})



/* GLOBAL EVENT LIMIT */

const eventsThisYear = computed(() => {

const year = new Date().getFullYear()

return bookings.value.filter(event =>
new Date(event.event_date).getFullYear() === year
)

})

const remainingEvents = computed(() => {

if(member.value?.membership_tier !== 'global') return null

return 4 - eventsThisYear.value.length

})



/* LOGOUT */

const logout = async () => {

await supabase.auth.signOut()

router.push('/account')

}



/* AVATAR UPLOAD */

const uploadAvatar = async (event) => {

const file = event.target.files[0]

if(!file) return

const filePath = `${user.value.id}-${Date.now()}`

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
.eq('email', user.value.email)

member.value.avatar_url = data.publicUrl

}



/* DATE FORMAT */

const formatDate = (date) => {

return new Date(date).toLocaleDateString('en-US',{
month:'long',
day:'numeric',
year:'numeric'
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

</style>