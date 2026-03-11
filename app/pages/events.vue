<template>

<div class="events-wrapper">

<!-- HERO EVENT -->

<div class="hero-event">

<img
src="https://images.lumacdn.com/cdn-cgi/image/quality=75,width=1200,height=800,fit=cover/..."
class="hero-image"
/>

<div class="hero-content">

<div class="hero-label">
FEATURED EVENT
</div>

<h2>
Mother Euro Lisbon Dinner
</h2>

<div class="hero-description">
A private gathering of founders, creatives, and women building life
across Europe. Hosted in Lisbon.
</div>

<a
href="https://luma.com/ME_EVAOMETZ"
target="_blank"
class="hero-btn"
>
Reserve Your Seat
</a>

</div>

</div>



<!-- UPCOMING EVENTS -->

<div class="section-header">
Upcoming Events
</div>


<!-- LUMA CALENDAR -->

<div class="luma-embed">

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
border-radius:8px;
}

.hero-label{
font-size:11px;
letter-spacing:4px;
opacity:.6;
margin-bottom:16px;
}

.hero-content h2{
font-size:34px;
margin-bottom:16px;
}

.hero-description{
line-height:1.6;
opacity:.8;
margin-bottom:24px;
}

.hero-btn{
background:black;
color:white;
padding:14px 26px;
font-size:11px;
letter-spacing:2px;
text-decoration:none;
display:inline-block;
}

.hero-btn:hover{
background:#A8985F;
}



/* SECTION */

.section-header{
font-size:12px;
letter-spacing:4px;
text-transform:uppercase;
margin-bottom:30px;
opacity:.6;
}



/* LUMA EMBED */

.luma-embed{
width:100%;
border-radius:18px;
overflow:hidden;
box-shadow:0 20px 40px rgba(0,0,0,.08);
}

.luma-embed iframe{
width:100%;
height:700px;
border:none;
}



/* MOBILE */

@media (max-width:900px){

.hero-event{
grid-template-columns:1fr;
}

.hero-image{
height:300px;
}

}

</style>