<template>
  <div class="events-page">

    <div class="page-header">
      <h1>EVENTS</h1>
    </div>

    <div class="events-container">

      <div
        v-for="event in events"
        :key="event.id"
        class="event-card"
      >

        <!-- Left Content -->
        <div class="event-content">

          <div class="event-date">
            {{ formatDate(event.event_date) }}
          </div>

          <h2 class="event-title">
            {{ event.title }}
          </h2>

          <div class="event-meta">
            {{ event.location }}
          </div>

          <p class="event-description">
            {{ event.description }}
          </p>

          <button
            class="register-btn"
            @click="openLuma(event.luma_url)"
          >
            REGISTER
          </button>

        </div>

        <!-- Image -->
        <div class="event-image">
          <img
            v-if="event.image_url"
            :src="event.image_url"
            alt="Event Image"
          />
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { supabase } from '~/utils/supabase'
const events = ref([])

onMounted(async () => {
  const { data, error } = await supabase
    .from('events')
    .select('*')
    .order('event_date', { ascending: true })

  if (!error && data) {
    events.value = data
  }
})

const openLuma = (url) => {
  if (url) window.open(url, '_blank')
}

const formatDate = (date) => {
  const d = new Date(date)
  return d.toLocaleDateString('en-GB', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}
</script>

<style scoped>

.events-page {
  padding: 60px 24px 140px 24px;
  max-width: 1200px;
  margin: auto;
}

.page-header {
  margin-bottom: 50px;
}

.page-header h1 {
  font-family: 'IBM Plex Mono', monospace;
  letter-spacing: 8px;
  font-weight: 300;
  font-size: 18px;
}

.events-container {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.event-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  padding: 40px;
  border-radius: 28px;
  border: 1px solid #e8e6e2;
  transition: 0.3s ease;
}

.event-card:hover {
  box-shadow: 0 30px 60px rgba(0,0,0,0.05);
  transform: translateY(-4px);
}

.event-content {
  flex: 1;
  padding-right: 40px;
}

.event-date {
  font-size: 14px;
  color: #999;
  margin-bottom: 12px;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.event-title {
  font-size: 24px;
  margin-bottom: 14px;
}

.event-meta {
  font-size: 14px;
  color: #888;
  margin-bottom: 20px;
}

.event-description {
  font-size: 15px;
  line-height: 1.6;
  max-width: 520px;
  margin-bottom: 30px;
  color: #444;
}

.register-btn {
  background: #A8985F;
  color: white;
  border: none;
  padding: 14px 36px;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s;
}

.register-btn:hover {
  background: #5E5130;
}

.event-image {
  width: 260px;
  height: 260px;
  border-radius: 24px;
  overflow: hidden;
  flex-shrink: 0;
}

.event-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Mobile */

@media (max-width: 900px) {
  .event-card {
    flex-direction: column;
    padding: 30px;
  }

  .event-content {
    padding-right: 0;
  }

  .event-image {
    width: 100%;
    height: 240px;
    margin-top: 30px;
  }
}

</style>
