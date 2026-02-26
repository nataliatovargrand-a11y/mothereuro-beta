<template>
  <div class="events-wrapper">

    <div class="events-header">
      <h1>Events</h1>
    </div>

    <div class="events-grid">

      <div
        v-for="event in events"
        :key="event.id"
        class="event-card"
      >

        <img
          v-if="event.image_url"
          :src="event.image_url"
          class="event-image"
        />

        <div class="event-content">

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
            @click="reserveEvent(event)"
          >
            REGISTER
          </button>

        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'
import { useRouter } from 'vue-router'

const router = useRouter()
const events = ref([])

onMounted(async () => {

  const { data: eventsData } = await supabase
    .from('events')
    .select('*')
    .order('event_date', { ascending: true })

  if (eventsData) {
    events.value = eventsData
  }

})

const reserveEvent = async (event) => {

  const { data } = await supabase.auth.getUser()

  // If not logged in → send to account page
  if (!data.user) {
    router.push('/account')
    return
  }

  // Save booking
  await supabase.from('bookings').insert({
    user_email: data.user.email,
    event_id: event.id,
    event_title: event.title,
    event_date: event.event_date
  })

  // Open Luma
  if (event.luma_url) {
    window.open(event.luma_url, '_blank')
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>

.events-wrapper {
  padding: 120px 40px 140px 40px;
  max-width: 1100px;
  margin: 0 auto;
}

.events-header {
  margin-bottom: 50px;
}

.events-header h1 {
  font-size: 40px;
  letter-spacing: 2px;
  text-transform: uppercase;
  font-weight: 500;
}

.events-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 40px;
}

.event-card {
  background: white;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.06);
  transition: all 0.3s ease;
}

.event-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 30px 60px rgba(0,0,0,0.08);
}

.event-image {
  width: 100%;
  height: 240px;
  object-fit: cover;
}

.event-content {
  padding: 30px;
}

.event-date {
  font-size: 13px;
  letter-spacing: 2px;
  margin-bottom: 12px;
  opacity: 0.7;
}

.event-title {
  font-size: 22px;
  margin-bottom: 12px;
  font-weight: 500;
}

.event-location {
  font-size: 14px;
  margin-bottom: 16px;
  opacity: 0.7;
}

.event-description {
  font-size: 14px;
  margin-bottom: 25px;
  line-height: 1.6;
}

.register-btn {
  background: black;
  color: white;
  border: none;
  padding: 14px 24px;
  letter-spacing: 2px;
  font-size: 12px;
  cursor: pointer;
  transition: 0.3s ease;
}

.register-btn:hover {
  background: #A8985F;
}

@media (max-width: 768px) {
  .events-wrapper {
    padding: 100px 20px 140px 20px;
  }
}

</style>