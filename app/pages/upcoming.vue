<template>

<div class="events-wrapper">

  <!-- HERO -->

  <div class="events-hero">

    <h1>Events</h1>

    <p class="hero-subline">
      Intimate gatherings, cultural salons, and curated dinners
      across Europe for the Mother Euro community.
    </p>

  </div>


  <!-- FEATURED EVENT -->

  <div class="featured-event">

    <div class="featured-image-placeholder"></div>

    <div class="featured-content">

      <div class="featured-label">
        FEATURED EVENT
      </div>

      <h2>Mother Euro Lisbon Dinner</h2>

      <p>
        A private gathering of founders, creatives, and women
        building life across Europe. Hosted in Lisbon.
      </p>

      <a
        href="https://luma.com"
        target="_blank"
        class="event-btn"
      >
        Reserve Your Seat
      </a>

    </div>

  </div>


  <!-- EVENTS CALENDAR -->

  <div class="calendar-header">
    Upcoming Events
  </div>

  <div class="events-calendar">

    <iframe
      src="https://luma.com/embed/calendar/cal-Hv0aqpqNkf2UIKs/events"
      width="100%"
      height="720"
      frameborder="0"
      style="border:0"
      allowfullscreen
    ></iframe>

  </div>

</div>

</template>



<script setup>

/*
Events powered by Luma
No backend needed
*/

</script>



<style scoped>

/* PAGE LAYOUT */

.events-wrapper{
padding:160px 40px 140px;
max-width:1100px;
margin:0 auto;
}



/* HERO */

.events-hero{
max-width:640px;
margin-bottom:100px;
}

.events-hero h1{
font-size:68px;
font-weight:300;
letter-spacing:-1px;
margin-bottom:28px;
}

.hero-subline{
font-size:20px;
line-height:1.8;
opacity:.75;
}



/* FEATURED EVENT */

.featured-event{
display:grid;
grid-template-columns:1.2fr 1fr;
gap:70px;
align-items:center;
margin-bottom:140px;
}

.featured-image{
width:100%;
height:420px;
object-fit:cover;
border-radius:6px;
}

.featured-content{
max-width:420px;
}

.featured-label{
font-size:12px;
letter-spacing:4px;
margin-bottom:18px;
opacity:.6;
}

.featured-content h2{
font-size:36px;
font-weight:400;
margin-bottom:20px;
}

.featured-content p{
font-size:16px;
line-height:1.8;
opacity:.75;
margin-bottom:30px;
}



/* BUTTON */

.event-btn{
padding:16px 32px;
background:black;
color:white;
text-decoration:none;
font-size:12px;
letter-spacing:3px;
transition:.3s ease;
}

.event-btn:hover{
background:#A8985F;
}



/* CALENDAR */

.calendar-header{
font-size:14px;
letter-spacing:5px;
text-transform:uppercase;
margin-bottom:30px;
opacity:.6;
}

.events-calendar{
border-radius:16px;
overflow:hidden;
box-shadow:0 20px 60px rgba(0,0,0,0.08);
}



/* MOBILE */

@media (max-width:900px){

.featured-event{
grid-template-columns:1fr;
}

.events-hero h1{
font-size:48px;
}

}


@media (max-width:768px){

.events-wrapper{
padding:120px 20px 140px;
}
.featured-image-placeholder{
width:100%;
height:420px;
background:#f5f5f5;
border-radius:6px;
}

}

</style>