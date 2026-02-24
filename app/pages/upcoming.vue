<template>
  <div class="me-container">

    <h1 class="page-title">Upcoming Events</h1>

    <div class="events-grid">

      <div
        v-for="event in events"
        :key="event.id"
        class="event-card"
        @click="goToEvent(event.luma_url)"
      >
        <h2>{{ event.title }}</h2>
        <p class="date">{{ event.date }}</p>
        <p class="location">{{ event.location }}</p>
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

.page-title {
  margin-bottom: 50px;
  font-size: 36px;
}

.events-grid {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.event-card {
  background: white;
  padding: 30px;
  cursor: pointer;
  transition: 0.3s ease;
  border: 1px solid #eee;
}

.event-card:hover {
  transform: translateY(-4px);
}

.event-card h2 {
  font-size: 22px;
  margin-bottom: 10px;
}

.date {
  font-weight: 500;
  margin-bottom: 5px;
}

.location {
  color: var(--me-muted);
  font-weight: 300;
}

</style>
