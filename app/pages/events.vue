<template>

<div class="events-wrapper">

<h1 class="page-title">
Events
</h1>

<div class="events-subtitle">
Private gatherings, cultural salons, and curated dinners
for the Mother Euro community.
</div>


<!-- FEATURED EVENT -->

<div class="featured-event">

<img
src="https://images.unsplash.com/photo-1504674900247-0877df9cc836"
class="featured-image"
/>

<div class="featured-content">

<div class="featured-label">
FEATURED EVENT
</div>

<h2>
Mother Euro Lisbon Dinner
</h2>

<p>
An intimate dinner bringing together founders,
creatives, and women building life across Europe.
</p>

<a
href="https://luma.com/ME_EVAOMETZ"
target="_blank"
class="featured-btn"
>
Reserve Your Seat
</a>

</div>

</div>


<!-- UPCOMING EVENTS -->

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
border-radius:10px;
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


/* SECTION LABEL */

.section-label{
font-size:12px;
letter-spacing:4px;
text-transform:uppercase;
opacity:.6;
margin-bottom:30px;
}


/* LUMA EMBED */

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