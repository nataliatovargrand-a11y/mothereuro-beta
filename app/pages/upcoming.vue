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
      >

        <div class="card-top">
          <div class="event-meta">
            <span>{{ formatDate(event.event_date) }}</span>
            <span class="dot">•</span>
            <span>{{ event.location }}</span>
          </div>
        </div>

        <h2 class="title">
          {{ event.title }}
        </h2>

        <p v-if="event.description" class="description">
          {{ event.description }}
        </p>

        <button class="me-button" @click="openLuma(event.luma_url)">
          Register
        </button>

      </div>

    </div>

  </div>
</template>

<script setup>

const supabase = useSupabaseClient()

const events = ref([])

onMounted(async () => {
  const { data, error } = await supabase
    .from('events')
    .select('*')
    .order('event_date', { ascending: true })

  if (!error) {
    events.value = data
  } else {
    console.error(error)
  }
})

const openLuma = (url) => {
  if (url) {
    window.open(url, '_blank')
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric'
  })
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
  gap: 40px;
}

.event-card {
  background: white;
  padding: 40px;
  border-radius: 10px;
  border: 1px solid #eee;
  transition: all 0.3s ease;
}

.event-card:hover {
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
  font-size: 26px;
  margin-bottom: 15px;
}

.description {
  font-weight: 300;
  margin-bottom: 30px;
  line-height: 1.6;
}

.me-button {
  margin-top: 10px;
}

</style>
