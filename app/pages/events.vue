<template>

<div class="events-wrapper">

<h1 class="page-title">Events</h1>

<p class="events-subtitle">
Private gatherings, cultural salons, and curated dinners for the Mother Euro community.
</p>


<!-- CITY FILTER -->

<div class="filter-bar">

<input
v-model="citySearch"
placeholder="Search by city..."
class="city-search"
/>

</div>


<!-- FEATURED EVENT -->

<div v-if="featuredEvent" class="featured-event">

<img
:src="featuredEvent.image_url"
class="featured-image"
/>

<div class="featured-content">

<div class="featured-label">
NEXT EVENT
</div>

<h2>
{{ featuredEvent.title }}
</h2>

<p class="event-date">
{{ formatDate(featuredEvent.event_date) }}
</p>

<p class="event-location">
{{ featuredEvent.location }}
</p>

<button
@click="register(featuredEvent)"
class="featured-btn"
>
Reserve Your Seat
</button>

</div>

</div>


<!-- UPCOMING EVENTS -->

<div class="section-label">
Upcoming Events
</div>

<div class="events-grid">

<div
v-for="event in filteredEvents"
:key="event.id"
class="event-card"
>

<img
v-if="event.image_url"
:src="event.image_url"
class="event-image"
/>

<div class="event-content">

<h3>{{ event.title }}</h3>

<p class="event-date">
{{ formatDate(event.event_date) }}
</p>

<p class="event-location">
{{ event.location }}
</p>

<button
@click="register(event)"
class="event-btn"
>
Reserve
</button>

</div>

</div>

</div>

</div>

</template>



<script setup>

import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const events = ref([])
const member = ref(null)
const citySearch = ref('')

const featuredEvent = ref(null)


onMounted(async()=>{

const { data:{ session } } = await supabase.auth.getSession()

if(!session) return

const { data: memberData } = await supabase
.from('members')
.select('*')
.eq('id', session.user.id)
.single()

member.value = memberData

const { data } = await supabase
.from('events')
.select('*')
.order('event_date',{ascending:true})

events.value = data || []

const now = new Date()

const futureEvents = events.value.filter(e=>{
return new Date(e.event_date) > now
})

featuredEvent.value = futureEvents[0]

})


const filteredEvents = computed(()=>{

const now = new Date()

const future = events.value.filter(e=>{
return new Date(e.event_date) > now
})

const others = future.slice(1)

if(!citySearch.value) return others

return others.filter(e=>
e.location?.toLowerCase().includes(citySearch.value.toLowerCase())
)

})


const register = async(event)=>{

if(member.value.membership_tier === 'global'){

const { data: registrations } = await supabase
.from('event_registrations')
.select('*, events(event_date)')
.eq('member_id', member.value.id)

const yearStart = new Date(new Date().getFullYear(),0,1)

const yearlyCount = registrations.filter(r=>{
return new Date(r.events.event_date) >= yearStart
}).length

if(yearlyCount >= 4){
alert("Global members may attend four events per year.")
return
}

const month = new Date().getMonth()
const quarterStart = Math.floor(month/3)*3

const qStart = new Date(new Date().getFullYear(),quarterStart,1)
const qEnd = new Date(new Date().getFullYear(),quarterStart+3,1)

const quarterEvents = registrations.filter(r=>{
const d = new Date(r.events.event_date)
return d >= qStart && d < qEnd
})

if(quarterEvents.length >= 1){
alert("Global members may attend only one event per quarter.")
return
}

}

await supabase
.from('event_registrations')
.insert({
member_id: member.value.id,
event_id: event.id
})

window.open(event.luma_url)

}


const formatDate=(d)=>{
return new Date(d).toLocaleDateString(undefined,{
weekday:'long',
month:'long',
day:'numeric'
})
}

</script>



<style scoped>

.events-wrapper{
padding:140px 40px;
max-width:1100px;
margin:auto;
}

.page-title{
font-size:48px;
margin-bottom:20px;
}

.events-subtitle{
opacity:.7;
margin-bottom:60px;
max-width:520px;
line-height:1.6;
}


/* FILTER */

.filter-bar{
margin-bottom:60px;
}

.city-search{
width:300px;
border:none;
border-bottom:1px solid rgba(0,0,0,0.2);
background:transparent;
padding:12px 0;
font-size:16px;
}


/* FEATURED EVENT */

.featured-event{
display:grid;
grid-template-columns:1.2fr 1fr;
gap:60px;
align-items:center;
margin-bottom:120px;
}

.featured-image{
width:100%;
height:420px;
object-fit:cover;
border-radius:12px;
}

.featured-label{
font-size:11px;
letter-spacing:4px;
opacity:.6;
margin-bottom:16px;
}

.featured-content h2{
font-size:34px;
margin-bottom:10px;
}

.event-date{
font-size:13px;
opacity:.6;
margin-bottom:6px;
}

.event-location{
font-size:13px;
opacity:.8;
margin-bottom:20px;
}

.featured-btn{
background:black;
color:white;
padding:14px 26px;
border:none;
cursor:pointer;
letter-spacing:2px;
}

.featured-btn:hover{
background:#A8985F;
}


/* EVENTS GRID */

.section-label{
font-size:12px;
letter-spacing:4px;
opacity:.6;
margin-bottom:30px;
}

.events-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:30px;
}

.event-card{
background:white;
border-radius:14px;
overflow:hidden;
box-shadow:0 15px 35px rgba(0,0,0,.06);
}

.event-image{
width:100%;
height:200px;
object-fit:cover;
}

.event-content{
padding:20px;
}

.event-btn{
margin-top:10px;
padding:10px 18px;
background:black;
color:white;
border:none;
cursor:pointer;
}

.event-btn:hover{
background:#A8985F;
}


@media (max-width:900px){

.featured-event{
grid-template-columns:1fr;
}

.featured-image{
height:280px;
}

}

</style>