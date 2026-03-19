<template>

<div class="page-wrapper">
  <div class="page-container">

    <!-- HEADER -->

    <h1 class="page-title-main">
      EVENTS
    </h1>

    <p class="page-subtitle">
      Discover curated gatherings across Europe.
    </p>

    <!-- LUMA EMBED -->

    <div class="events-embed">

      <iframe
        src="https://luma.com/embed/calendar/cal-Hv0aqpqNkf2UIKs/events"
        width="100%"
        height="600"
        frameborder="0"
        style="border:1px solid #e5e5e5;border-radius:12px;"
      ></iframe>

    </div>

  </div>
</div>

</template>


<script setup>

definePageMeta({
  middleware: 'auth'
})

</script>


<style scoped>

/* TITLE */

.page-title-main{
  font-size:42px;
  text-transform:uppercase;
  margin-bottom:14px;
}

.page-subtitle{
  font-size:16px;
  opacity:.65;
  margin-bottom:50px;
  max-width:500px;
}


/* EMBED */

.events-embed{
  width:100%;
  max-width:100%;
  overflow:hidden;
}


/* MOBILE */

@media (max-width:768px){

  .page-title-main{
    font-size:30px;
  }

  .events-embed iframe{
    height:500px;
  }

}

</style>