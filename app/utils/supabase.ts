<template>
  <div class="events-wrapper">

    <div class="events-header">
      <h1>EVENTS</h1>
    </div>

    <div v-if="events.length === 0" class="empty-state">
      Upcoming gatherings are being curated.
    </div>

    <div v-else class="events-grid">

      <div
        v-for="event in events"
        :key="event.id"
        class="event-card"
      >

        <!-- Content -->
        <div class="event-left">

          <div class="event-date">
            {{ formatDate(event.event_date) }}
          </div>

          <h2 class="event-title">
            {{ event.title }}
          </h2>

          <div class="event-location">
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
        <div class="event-right">
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

.events-wrapper {
  padding: 80px 24px 140px 24px;
  max-width: 1200px;
  margin: auto;
}

.events-header {
  margin-bottom: 60px;
}

.events-header h1 {
  font-family: 'IBM Plex Mono', monospace;
  letter-spacing: 8px;
  font-weight: 300;
  font-size: 16px;
  text-align: center;
}

.empty-state {
  text-align: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  color: #777;
}

.events-grid {
  display: flex;
  flex-direction: column;
  gap: 50px;
}

.event-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  border-radius: 32px;
  padding: 50px;
  border: 1px solid #eae7e2;
  transition: all 0.3s ease;
}

.event-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 40px 80px rgba(0,0,0,0.05);
}

.event-left {
  flex: 1;
  padding-right: 50px;
}

.event-date {
  font-size: 13px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #888;
  margin-bottom: 18px;
}

.event-title {
  font-size: 26px;
  margin-bottom: 16px;
}

.event-location {
  font-size: 14px;
  color: #777;
  margin-bottom: 24px;
}

.event-description {
  font-size: 15px;
  line-height: 1.6;
  margin-bottom: 34px;
  max-width: 500px;
  color: #444;
}

.register-btn {
  background: #A8985F;
  color: white;
  border: none;
  padding: 14px 40px;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.register-btn:hover {
  background: #5E5130;
}

.event-right {
  width: 280px;
  height: 280px;
  border-radius: 24px;
  overflow: hidden;
  flex-shrink: 0;
}

.event-right img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Mobile */

@media (max-width: 900px) {
  .event-card {
    flex-direction: column;
    padding: 40px;
  }

  .event-left {
    padding-right: 0;
  }

  .event-right {
    width: 100%;
    height: 240px;
    margin-top: 30px;
  }
}

</style>