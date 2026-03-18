<template>

<div class="page-wrapper">
  <div class="page-container">

    <h1 class="page-title">Events</h1>

    <p class="page-subtitle">
      Private gatherings, curated experiences, and meaningful connections across Europe.
    </p>

    <div class="events-embed">

      <iframe
        src="https://luma.com/embed/calendar/cal-Hv0aqpqNkf2UIKs/events"
        class="luma-embed"
        frameborder="0"
        allowfullscreen
      ></iframe>

    </div>

  </div>
</div>

</template>


<style scoped>

.events-embed{
  margin-top:40px;
}

/* FIXED + PREMIUM EMBED */

.luma-embed{
  width:100%;
  height:720px;
  border:none;
  border-radius:18px;
  background:white;
  box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

/* MOBILE */

@media (max-width:768px){
  .luma-embed{
    height:600px;
  }
}

</style>