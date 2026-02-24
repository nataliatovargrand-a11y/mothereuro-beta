<template>
  <div class="me-container">

    <div class="header">
      <h1>Upcoming Events</h1>
      <p class="intro">
        Thoughtfully curated gatherings across Europe and virtually.
      </p>
    </div>

    <div class="events-grid">

      <div
        v-for="event in events"
        :key="event.id"
        class="event-card"
        @click="goToEvent(event.luma_url)"
      >

        <div class="card-top">
          <div class="event-meta">
            <span class="date">{{ event.date }}</span>
            <span class="dot">•</span>
            <span class="location">{{ event.location }}</span>
          </div>
        </div>

        <h2 class="title">
          {{ event.title }}
        </h2>

        <div class="card-footer">
          <span class="cta">View Event →</span>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>

const events = [
  {
    id: 1,
    title: "Trip Planning Hacked – Globe Thrivers",
    date: "March 4",
    location: "Virtual",
    luma_url: "https://luma.com/ME_GlobeThrivers"
  },
  {
    id: 2,
    title: "An Evening with Flabelus",
    date: "March 4",
    location: "Madrid",
    luma_url: "https://luma.com/ME_Flabelus"
  },
  {
    id: 3,
    title: "Nervous System Reset – AMUNA",
    date: "March 10",
    location: "Madrid",
    luma_url: "https://luma.com/ME_AMUNA"
  }
]

const goToEvent = (url) => {
  window.open(url, '_blank')
}

</script>

<style scoped>

.header {
  margin-bottom: 60px;
}

.header h1 {
  font-size: 38px;
  margin-bottom: 10px;
}

.intro {
  font-weight: 300;
  color: var(--me-muted);
  max-width: 500px;
}

.events-grid {
  display: flex;
  flex-direction: column;
  gap: 35px;
}

.event-card {
  background: white;
  padding: 35px;
  border-radius: 8px;
  border: 1px solid #eee;
  transition: all 0.3s ease;
  cursor: pointer;
}

.event-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

.card-top {
  margin-bottom: 15px;
}

.event-meta {
  font-size: 13px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--me-muted);
}

.dot {
  margin: 0 8px;
}

.title {
  font-size: 24px;
  line-height: 1.3;
  margin-bottom: 20px;
}

.card-footer {
  margin-top: auto;
}

.cta {
  font-size: 13px;
  letter-spacing: 1px;
  text-transform: uppercase;
}

@media (max-width: 768px) {
  .header h1 {
    font-size: 30px;
  }

  .title {
    font-size: 20px;
  }
}

</style>
