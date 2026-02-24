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

        <!-- Image -->
        <div class="image-wrapper">
          <img
            v-if="event.image_url"
            :src="event.image_url"
            class="event-image"
          />
          <div class="image-overlay"></div>
        </div>

        <!-- Content -->
        <div class="card-content">

          <div class="event-meta">
            <span>{{ formatDate(event.event_date) }}</span>
            <span class="dot">•</span>
            <span>{{ event.location }}</span>
          </div>

          <h2 class="title">
            {{ event.title }}
          </h2>

          <p v-if="event.description" class="description">
            {{ event.description }}
          </p>

          <button class="me-button premium" @click="openLuma(event.luma_url)">
            Reserve Your Spot
          </button>

        </div>

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
  if (url) window.open(url, '_blank')
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
  margin-bottom: 80px;
}

.header h1 {
  font-size: 42px;
  margin-bottom: 12px;
}

.intro {
  font-weight: 300;
  color: var(--me-muted);
  max-width: 500px;
}

.events-grid {
  display: flex;
  flex-direction: column;
  gap: 70px;
}

.event-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid #eee;
  transition: all 0.4s ease;
}

.event-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 30px 60px rgba(0,0,0,0.08);
}

.image-wrapper {
  position: relative;
  height: 320px;
  overflow: hidden;
}

.event-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.event-card:hover .event-image {
  transform: scale(1.05);
}

.image-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to bottom,
    rgba(0,0,0,0.05),
    rgba(0,0,0,0.2)
  );
}

.card-content {
  padding: 50px;
}

.event-meta {
  font-size: 12px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--me-muted);
  margin-bottom: 18px;
}

.dot {
  margin: 0 10px;
}

.title {
  font-size: 28px;
  margin-bottom: 20px;
}

.description {
  font-weight: 300;
  margin-bottom: 40px;
  line-height: 1.7;
  max-width: 600px;
}

.premium {
  padding: 14px 28px;
  font-size: 14px;
  letter-spacing: 1px;
  text-transform: uppercase;
  background: black;
  color: white;
  border-radius: 30px;
  transition: all 0.3s ease;
}

.premium:hover {
  background: var(--me-accent);
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .image-wrapper {
    height: 220px;
  }

  .card-content {
    padding: 30px;
  }

  .header h1 {
    font-size: 34px;
  }
}

</style>
