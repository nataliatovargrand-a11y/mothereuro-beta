<template>

<div class="events-wrapper">

<h1 class="page-title">Events</h1>

<div class="events-grid">

<div
v-for="event in events"
:key="event.id"
class="event-card"
>

<img
:src="event.image_url"
class="event-image"
/>

<div class="event-content">

<div class="event-date">
{{ formatDate(event.event_date) }} · {{ event.location }}
</div>

<h2 class="event-title">
{{ event.title }}
</h2>

<button
class="event-btn"
@click="registerEvent(event)"
>
RSVP
</button>

</div>

</div>

</div>

</div>

</template>

<script setup>

import { ref, onMounted } from "vue"
import { supabase } from "~/utils/supabase"

const events = ref([])
const userEmail = ref(null)

onMounted(async () => {

const { data: userData } = await supabase.auth.getUser()

if (!userData?.user) return

userEmail.value = userData.user.email

const { data: eventsData, error } = await supabase
.from("events")
.select("*")

if(error){
console.error("EVENT LOAD ERROR:", error)
}

events.value = eventsData || []

})

const registerEvent = async(event)=>{

await supabase.from("bookings").insert({
event_id:event.id,
event_title:event.title,
event_date:event.event_date,
user_email:userEmail.value
})

window.open(event.luma_url,"_blank")

}

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
padding:120px 40px;
max-width:1100px;
margin:auto;
}

.page-title{
font-size:40px;
margin-bottom:50px;
}

.events-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:30px;
}

.event-card{
background:white;
border-radius:18px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.event-image{
width:100%;
height:200px;
object-fit:cover;
}

.event-content{
padding:24px;
}

.event-date{
font-size:12px;
opacity:.6;
margin-bottom:10px;
}

.event-title{
font-size:20px;
margin-bottom:14px;
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

</style>