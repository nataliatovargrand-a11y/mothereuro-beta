<template>

<div class="events-wrapper">

<h1 class="page-title">Events</h1>

<div class="events-subtitle">
Private gatherings, cultural salons, and curated dinners
for the Mother Euro community.
</div>


<!-- FEATURED EVENT -->

<div v-if="nextEvent" class="featured-event">

<img
:src="nextEvent.cover_url"
class="featured-image"
/>

<div class="featured-content">

<div class="featured-label">
NEXT EVENT
</div>

<h2>
{{ nextEvent.name }}
</h2>

<p>
{{ nextEvent.description }}
</p>

<a
:href="nextEvent.url"
target="_blank"
class="featured-btn"
>
Reserve Your Seat
</a>

</div>

</div>


<!-- LUMA CALENDAR -->

<div class="section-label">
Upcoming Events
</div>

<div class="luma-wrapper">

<iframe
src="https://luma.com/embed/calendar/cal-Hv0aqpqNkf2UIKs/events"
frameborder="0"
allowfullscreen
></iframe>

</div>

</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'

const nextEvent = ref(null)

onMounted(async () => {

const response = await fetch(
'https://api.luma.com/calendar/cal-Hv0aqpqNkf2UIKs/events'
)

const data = await response.json()

if(data.entries && data.entries.length){

nextEvent.value = data.entries[0]

}

})

</script>


<style scoped>

.events-wrapper{
padding:140px 40px 140px;
max-width:1100px;
margin:auto;
}

.page-title{
font-size:48px;
margin-bottom:20px;
}

.events-subtitle{
opacity:.7;
margin-bottom:80px;
max-width:520px;
line-height:1.6;
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
margin-bottom:12px;
}

.featured-content p{
opacity:.8;
margin-bottom:24px;
line-height:1.6;
}

.featured-btn{
background:black;
color:white;
padding:14px 26px;
text-decoration:none;
font-size:11px;
letter-spacing:2px;
}

.featured-btn:hover{
background:#A8985F;
}


/* CALENDAR */

.section-label{
font-size:12px;
letter-spacing:4px;
text-transform:uppercase;
opacity:.6;
margin-bottom:30px;
}

.luma-wrapper{
border-radius:18px;
overflow:hidden;
box-shadow:0 25px 50px rgba(0,0,0,.08);
}

.luma-wrapper iframe{
width:100%;
height:720px;
border:none;
}


/* MOBILE */

@media (max-width:900px){

.featured-event{
grid-template-columns:1fr;
}

.featured-image{
height:280px;
}

}

</style>