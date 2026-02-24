<template>
  <section class="upcoming">
    <div class="container">
      <h1>Upcoming Events</h1>

      <p class="subtitle">
        Discover our curated gatherings across Europe.
      </p>

      <div class="luma-embed">
        <iframe
          src="https://lu.ma/YOUR-LUMA-LINK"
          frameborder="0"
          allowfullscreen
        ></iframe>
      </div>
    </div>
  </section>
</template>

<style scoped>
.upcoming {
  padding: 60px 20px;
  text-align: center;
}

.container {
  max-width: 900px;
  margin: 0 auto;
}

.subtitle {
  margin: 20px 0 40px;
  font-weight: 300;
}

.luma-embed {
  position: relative;
  width: 100%;
  height: 800px;
}

.luma-embed iframe {
  width: 100%;
  height: 100%;
  border-radius: 8px;
}
</style>
