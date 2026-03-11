<template>

<div class="events-wrapper">

<!-- HERO EVENT -->

<div
  v-if="heroEvent"
  class="featured-event"
>

  <img
    v-if="heroEvent.image_url"
    :src="heroEvent.image_url"
    class="featured-image"
  />

  <div class="featured-content">

    <div class="featured-label">
      NEXT EVENT
    </div>

    <h2>
      {{ heroEvent.title }}
    </h2>

    <p>
      {{ heroEvent.description }}
    </p>

    <div class="event-date">
      {{ formatDate(heroEvent.event_date) }} · {{ heroEvent.city }}
    </div>

    <button
      class="event-btn"
      :disabled="!canRegister"
      @click="registerEvent(heroEvent)"
    >
      {{ canRegister ? "Reserve Your Seat" : "Limit Reached" }}
    </button>

  </div>

</div>



<!-- UPCOMING EVENTS -->

<div class="section-header">
Upcoming Events
</div>

<div class="events-grid">

<div
  v-for="event in upcomingEvents"
  :key="event.id"
  class="event-card"
>

<img
  v-if="event.image_url"
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

<p class="event-description">
{{ event.description }}
</p>

<button
class="event-btn"
:disabled="!canRegister"
@click="registerEvent(event)"
>
{{ canRegister ? "Register" : "Limit Reached" }}
</button>

</div>

</div>

</div>



<!-- YOUR EVENTS -->

<div class="section-header">
Your Registered Events
</div>

<div
v-if="userBookings.length === 0"
class="empty-state"
>
You haven't registered for any events yet.
</div>

<div class="events-grid">

<div
v-for="booking in userBookings"
:key="booking.id"
class="event-card past"
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



<!-- PAST EVENTS -->

<div class="section-header">
Past Events
</div>

<div class="events-grid">

<div
v-for="event in pastEvents"
:key="event.id"
class="event-card past"
>

<div class="event-content">

<div class="event-date">
{{ formatDate(event.event_date) }} · {{ event.city }}
</div>

<h2 class="event-title">
{{ event.title }}
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
const membershipTier = ref(null)
const userEmail = ref(null)



onMounted(async () => {

const { data } = await supabase.auth.getUser()

if (!data.user) return

userEmail.value = data.user.email



/* MEMBER INFO */

const { data: member } = await supabase
.from("members")
.select("membership_tier")
.eq("email", userEmail.value)
.single()

membershipTier.value = member?.membership_tier || "global"



/* LOAD EVENTS */

const { data: eventsData } = await supabase
.from("events")
.select("*")
.order("event_date", { ascending: true })

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
.sort((a,b) => new Date(a.event_date) - new Date(b.event_date))

return upcoming[0] || null

})



/* UPCOMING */

const upcomingEvents = computed(() =>
events.value.filter(e => new Date(e.event_date) >= new Date())
)



/* PAST */

const pastEvents = computed(() =>
events.value.filter(e => new Date(e.event_date) < new Date())
)



/* EVENT LIMIT */

const canRegister = computed(() => {

if (
membershipTier.value === "aspiring" ||
membershipTier.value === "resident"
){
return true
}

if (membershipTier.value === "global"){

const year = new Date().getFullYear()

const count = userBookings.value.filter(b =>
new Date(b.event_date).getFullYear() === year
).length

return count < 4
}

return false

})



/* REGISTER */

const registerEvent = async (event) => {

if (!canRegister.value){
alert("You have reached your event limit for this year.")
return
}

await supabase.from("bookings").insert({

user_email: userEmail.value,
event_id: event.id,
event_title: event.title,
event_date: event.event_date

})

if (event.luma_url){
window.open(event.luma_url, "_blank")
}

}



/* DATE FORMAT */

const formatDate = (date) => {

return new Date(date).toLocaleDateString("en-US",{
month:"long",
day:"numeric",
year:"numeric"
})

}

</script>



<style scoped>


.events-wrapper{
padding:160px 40px 140px;
max-width:1100px;
margin:0 auto;
}



/* HERO */

.featured-event{
display:grid;
grid-template-columns:1.2fr 1fr;
gap:70px;
align-items:center;
margin-bottom:120px;
}

.featured-image{
width:100%;
height:420px;
object-fit:cover;
border-radius:6px;
}

.featured-label{
font-size:12px;
letter-spacing:4px;
margin-bottom:18px;
opacity:.6;
}

.featured-content h2{
font-size:36px;
margin-bottom:16px;
}

.event-date{
font-size:13px;
letter-spacing:2px;
opacity:.6;
margin-bottom:16px;
}

.event-btn{
padding:14px 28px;
background:black;
color:white;
border:none;
font-size:12px;
letter-spacing:2px;
cursor:pointer;
}

.event-btn:hover{
background:#A8985F;
}



/* SECTIONS */

.section-header{
font-size:13px;
letter-spacing:4px;
margin-top:80px;
margin-bottom:30px;
opacity:.6;
}



/* GRID */

.events-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:40px;
}



/* CARDS */

.event-card{
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 20px 50px rgba(0,0,0,0.05);
}

.event-card:hover{
transform:translateY(-5px);
}

.event-image{
width:100%;
height:220px;
object-fit:cover;
}

.event-content{
padding:28px;
}

.event-title{
font-size:22px;
margin-bottom:14px;
}

.event-description{
font-size:15px;
opacity:.75;
margin-bottom:20px;
}

.event-card.past{
opacity:.6;
}



.empty-state{
opacity:.6;
font-size:15px;
}

</style>