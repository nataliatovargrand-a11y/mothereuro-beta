<template>

<div class="events-wrapper">

<h1 class="page-title">Events</h1>

<p class="events-subtitle">
Private gatherings, cultural salons, and curated dinners for the Mother Euro community.
</p>


<!-- CITY FILTER -->

<div class="city-filter">

<button
v-for="city in cities"
:key="city"
@click="selectedCity = city"
:class="['city-pill', selectedCity === city ? 'active' : '']"
>
{{ city }}
</button>

<button
@click="selectedCity = null"
class="city-pill clear"
>
All
</button>

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


<!-- RSVP AVATARS -->

<div class="rsvp-row" v-if="featuredEvent.attendees.length">

<img
v-for="a in featuredEvent.attendees.slice(0,5)"
:key="a.member_id"
:src="a.avatar_url || '/avatar-placeholder.png'"
class="avatar"
/>

<div v-if="featuredEvent.attendees.length > 5" class="avatar-more">
+{{ featuredEvent.attendees.length - 5 }}
</div>

</div>


<!-- WAITLIST -->

<div
v-if="featuredEvent.capacity && featuredEvent.attending >= featuredEvent.capacity"
class="waitlist-badge"
>
Waitlist
</div>


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


<!-- RSVP AVATARS -->

<div class="rsvp-row" v-if="event.attendees.length">

<img
v-for="a in event.attendees.slice(0,5)"
:key="a.member_id"
:src="a.avatar_url || '/avatar-placeholder.png'"
class="avatar"
/>

<div v-if="event.attendees.length > 5" class="avatar-more">
+{{ event.attendees.length - 5 }}
</div>

</div>


<!-- WAITLIST -->

<div
v-if="event.capacity && event.attending >= event.capacity"
class="waitlist-badge"
>
Waitlist
</div>


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
const featuredEvent = ref(null)
const member = ref(null)

const selectedCity = ref(null)

const cities = [
'Madrid',
'Barcelona',
'Paris',
'Lisbon',
'London',
'Virtual'
]


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

if(!data) return


for(const event of data){

const { data: attendees } = await supabase
.from('event_registrations')
.select(`
member_id,
members(avatar_url)
`)
.eq('event_id',event.id)

event.attendees = attendees?.map(a=>({
member_id: a.member_id,
avatar_url: a.members?.avatar_url
})) || []

event.attending = event.attendees.length

}

events.value = data

const now = new Date()

const future = events.value.filter(e=>{
return new Date(e.event_date) > now
})

featuredEvent.value = future[0]

})


const filteredEvents = computed(()=>{

const now = new Date()

let future = events.value.filter(e=>{
return new Date(e.event_date) > now
})

future = future.slice(1)

if(!selectedCity.value) return future

return future.filter(e=>
e.location?.includes(selectedCity.value)
)

})


const register = async(event)=>{

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


/* CITY FILTER */

.city-filter{
display:flex;
gap:12px;
flex-wrap:wrap;
margin-bottom:60px;
}

.city-pill{
padding:8px 16px;
border:1px solid rgba(0,0,0,0.1);
background:white;
cursor:pointer;
border-radius:30px;
font-size:12px;
}

.city-pill.active{
background:black;
color:white;
}

.city-pill.clear{
opacity:.6;
}


/* FEATURED */

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
margin-bottom:10px;
}

.featured-content h2{
font-size:34px;
margin-bottom:10px;
}

.featured-btn{
background:black;
color:white;
padding:14px 26px;
border:none;
cursor:pointer;
letter-spacing:2px;
}


/* RSVP */

.rsvp-row{
display:flex;
align-items:center;
margin-bottom:12px;
}

.avatar{
width:32px;
height:32px;
border-radius:50%;
object-fit:cover;
margin-right:-8px;
border:2px solid white;
}

.avatar-more{
margin-left:10px;
font-size:12px;
opacity:.6;
}


/* WAITLIST */

.waitlist-badge{
display:inline-block;
background:#f5f5f5;
padding:4px 10px;
font-size:11px;
letter-spacing:1px;
margin-bottom:10px;
}


/* GRID */

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

</style>