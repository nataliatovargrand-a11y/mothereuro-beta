<template>

<div class="events-wrapper">

<!-- HERO EVENT -->

<div
v-if="heroEvent"
class="hero-event"
>

<img
:src="heroEvent.image_url"
class="hero-image"
/>

<div class="hero-content">

<div class="hero-label">
NEXT EVENT
</div>

<h2>{{ heroEvent.title }}</h2>

<div class="hero-meta">
{{ formatDate(heroEvent.event_date) }} · {{ heroEvent.city }}
</div>

<button
class="hero-btn"
@click="registerEvent(heroEvent)"
>
Reserve Your Seat
</button>

</div>

</div>



<!-- UPCOMING EVENTS -->

<div class="section-header">
Upcoming Events
</div>

<div v-if="upcomingEvents.length === 0" class="empty-state">
New events will be announced soon.
</div>

<div v-else class="events-grid">

<div
v-for="event in upcomingEvents"
:key="event.id"
class="event-card"
>

<img
:src="event.image_url"
class="event-image"
/>

<div class="event-content">

<div class="event-date">
{{ formatDate(event.event_date) }} · {{ event.city }}
</div>

<h2 class="event-title">
{{ event.title }}
</h2>

<button
class="event-btn"
@click="registerEvent(event)"
>
Register
</button>

</div>

</div>

</div>



<!-- REGISTERED EVENTS -->

<div class="section-header">
Your Registered Events
</div>

<div v-if="userBookings.length === 0" class="empty-state">
You haven't registered for any events yet.
</div>

<div class="events-grid">

<div
v-for="booking in userBookings"
:key="booking.id"
class="event-card"
>

<div class="event-content">

<div class="event-date">
{{ formatDate(booking.event_date) }}
</div>

<h2 class="event-title">
{{ booking.event_title }}
</h2>

</div>

</div>

</div>

</div>

</template>


<script setup>

import { ref, onMounted, computed } from "vue"
import { supabase } from "~/utils/supabase"

const events = ref([])
const userBookings = ref([])
const userEmail = ref(null)


onMounted(async () => {

const { data } = await supabase.auth.getUser()

if (!data.user) return

userEmail.value = data.user.email


/* LOAD EVENTS */

const { data: eventsData } = await supabase
.from("events")
.select("*")
.order("event_date",{ ascending:true })

events.value = eventsData || []


/* USER BOOKINGS */

const { data: bookings } = await supabase
.from("bookings")
.select("*")
.eq("user_email", userEmail.value)

userBookings.value = bookings || []

})



/* HERO EVENT */

const heroEvent = computed(() => {

const upcoming = events.value
.filter(e => new Date(e.event_date) >= new Date())
.sort((a,b)=> new Date(a.event_date) - new Date(b.event_date))

return upcoming[0] || null

})


/* UPCOMING */

const upcomingEvents = computed(()=>{

return events.value.filter(e =>
new Date(e.event_date) >= new Date()
)

})



/* REGISTER */

const registerEvent = async(event)=>{

await supabase.from("bookings").insert({

user_email: userEmail.value,
event_id: event.id,
event_title: event.title,
event_date: event.event_date

})

window.open(event.luma_url,"_blank")

}



/* DATE FORMAT */

const formatDate=(date)=>{

return new Date(date).toLocaleDateString("en-US",{
month:"long",
day:"numeric",
year:"numeric"
})

}

</script>



<style scoped>

.events-wrapper{
padding:140px 40px 120px;
max-width:1100px;
margin:0 auto;
}



/* HERO */

.hero-event{
display:grid;
grid-template-columns:1.2fr 1fr;
gap:60px;
align-items:center;
margin-bottom:100px;
}

.hero-image{
width:100%;
height:420px;
object-fit:cover;
border-radius:6px;
}

.hero-label{
font-size:11px;
letter-spacing:4px;
opacity:.6;
margin-bottom:16px;
}

.hero-content h2{
font-size:34px;
margin-bottom:12px;
}

.hero-meta{
font-size:13px;
letter-spacing:2px;
opacity:.6;
margin-bottom:20px;
}

.hero-btn{
background:black;
color:white;
border:none;
padding:14px 26px;
font-size:11px;
letter-spacing:2px;
cursor:pointer;
}

.hero-btn:hover{
background:#A8985F;
}



/* GRID */

.section-header{
font-size:12px;
letter-spacing:4px;
text-transform:uppercase;
margin-top:80px;
margin-bottom:30px;
opacity:.6;
}

.events-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
gap:36px;
}



/* CARD */

.event-card{
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,0.05);
}

.event-image{
width:100%;
height:220px;
object-fit:cover;
}

.event-content{
padding:26px;
}

.event-date{
font-size:12px;
letter-spacing:2px;
opacity:.6;
margin-bottom:10px;
}

.event-title{
font-size:20px;
margin-bottom:12px;
}

.event-btn{
background:black;
color:white;
border:none;
padding:12px 22px;
font-size:11px;
letter-spacing:2px;
cursor:pointer;
}

.event-btn:hover{
background:#A8985F;
}



/* EMPTY */

.empty-state{
font-size:14px;
opacity:.5;
padding:40px 0;
}

</style>