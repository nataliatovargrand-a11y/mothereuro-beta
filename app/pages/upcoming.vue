<template>
  <div class="events-wrapper">

    <!-- Top Greeting -->
    <div class="top-greeting" v-if="firstName">
      Hi, {{ firstName }}
    </div>

    <!-- Under Review Banner -->
    <div v-if="membershipStatus === 'pending'" class="review-banner">
      Your membership application is under review.
    </div>

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
            :disabled="membershipStatus !== 'active'"
            @click="reserveEvent(event)"
          >
            {{ membershipStatus === 'active'
                ? 'REGISTER'
                : 'MEMBERSHIP REQUIRED' }}
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
const membershipStatus = ref(null)
const firstName = ref(null)

onMounted(async () => {

  const { data } = await supabase.auth.getUser()

  if (!data.user) {
    router.push('/account')
    return
  }

  const { data: member } = await supabase
    .from('members')
    .select('membership_status, first_name')
    .eq('email', data.user.email)
    .single()

  membershipStatus.value = member?.membership_status || 'pending'
  firstName.value = member?.first_name || ''

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
  if (!data.user) return

  if (membershipStatus.value !== 'active') return

  // Save booking in database
  await supabase.from('bookings').insert({
    user_email: data.user.email,
    event_id: event.id,
    event_title: event.title,
    event_date: event.event_date
  })

  // Then open Luma
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
  max-width: 1200px;
  margin: 0 auto;
}

.top-greeting {
  font-size: 18px;
  letter-spacing: 1px;
  margin-bottom: 30px;
  opacity: 0.8;
}

.review-banner {
  background: #F3EBDD;
  border: 1px solid #A8985F;
  color: #5E5130;
  padding: 18px;
  margin-bottom: 50px;
  text-align: center;
  letter-spacing: 1px;
  font-size: 14px;
}

.events-header {
  margin-bottom: 50px;
}

.events-header h1 {
  font-size: 40px;
  letter-spacing: 2px;
  text-transform: uppercase;
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
  transition: 0.3s ease;
}

.event-card:hover {
  transform: translateY(-6px);
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

.register-btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.register-btn:not(:disabled):hover {
  background: #A8985F;
}

@media (max-width: 768px) {
  .events-wrapper {
    padding: 100px 20px 140px 20px;
  }
}

</style>