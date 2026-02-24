<template>
  <section class="upcoming">
    <div class="container">
      <h1 class="title">Upcoming Events</h1>
      <p class="subtitle">
        Curated gatherings across Europe & online.
      </p>
    </div>

    <div class="embed-wrapper">
      <iframe
        src="https://luma.com/user/mothereuro"
        loading="lazy"
        allowfullscreen
      ></iframe>
    </div>
  </section>
</template>

<style scoped>
.upcoming {
  padding-top: 60px;
  background: var(--me-bg);
}

.container {
  text-align: center;
  padding: 0 20px 40px;
}

.title {
  font-size: 28px;
  letter-spacing: 2px;
}

.subtitle {
  margin-top: 20px;
  font-weight: 300;
  color: var(--me-grey);
}

.embed-wrapper {
  width: 100%;
  height: calc(100vh - 160px);
  overflow: hidden;
}

.embed-wrapper iframe {
  width: 100%;
  height: 100%;
  border: none;
}
</style>
