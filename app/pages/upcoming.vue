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
import { ref, onMounted } from 'vue'
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
  padding: 100px 24px 160px 24px;
  max-width: 1200px;
  margin: auto;
  background: #FAF3EA;
}

.events-header {
  margin-bottom: 80px;
  text-align: center;
}

.events-header h1 {
  font-family: 'IBM Plex Mono', monospace;
  letter-spacing: 8px;
  font-weight: 300;
  font-size: 14px;
  color: #2E2B29;
}

.empty-state {
  text-align: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  color: #7A746E;
}

.events-grid {
  display: flex;
  flex-direction: column;
  gap: 70px;
}

.event-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #F7F1E7;
  border-radius: 36px;
  padding: 60px;
  border: 1px solid rgba(168, 152, 95, 0.15);
  position: relative;
  transition: all 0.4s ease;
}

.event-card::before {
  content: "";
  position: absolute;
  left: 0;
  top: 50px;
  height: 60%;
  width: 3px;
  background: #A8985F;
  border-radius: 10px;
}

.event-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 40px 80px rgba(0,0,0,0.06);
}

.event-left {
  flex: 1;
  padding-right: 60px;
}

.event-date {
  font-family: 'IBM Plex Mono', monospace;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #A8985F;
  margin-bottom: 20px;
}

.event-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 32px;
  font-weight: 400;
  margin-bottom: 20px;
  line-height: 1.2;
}

.event-location {
  font-size: 14px;
  letter-spacing: 1px;
  color: #7A746E;
  margin-bottom: 30px;
}

.event-description {
  font-size: 16px;
  line-height: 1.7;
  margin-bottom: 40px;
  max-width: 540px;
  color: #4A4744;
}

.register-btn {
  background: transparent;
  border: 1px solid #A8985F;
  color: #A8985F;
  padding: 14px 38px;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.register-btn:hover {
  background: #A8985F;
  color: white;
}

.event-right {
  width: 320px;
  height: 320px;
  border-radius: 30px;
  overflow: hidden;
  flex-shrink: 0;
}

.event-right img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.event-card:hover .event-right img {
  transform: scale(1.05);
}

/* Mobile */

@media (max-width: 900px) {
  .event-card {
    flex-direction: column;
    padding: 40px;
  }

  .event-card::before {
    display: none;
  }

  .event-left {
    padding-right: 0;
  }

  .event-right {
    width: 100%;
    height: 240px;
    margin-top: 40px;
  }
}

</style>