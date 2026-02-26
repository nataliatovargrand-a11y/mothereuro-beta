<template>
  <div class="account-wrapper">

    <!-- Greeting -->
    <h1>Hi, {{ firstName }}</h1>

    <!-- Account Information -->
    <section class="section">
      <h2>Account Information</h2>

      <div class="card">

        <div class="photo-row">
          <img
            v-if="photo"
            :src="photo"
            class="avatar"
          />
          <div v-else class="avatar placeholder">
            {{ firstName?.charAt(0) }}
          </div>
        </div>

        <div class="row">
          <span class="label">Name</span>
          <span class="value">{{ firstName }}</span>
        </div>

        <div class="row">
          <span class="label">Address</span>
          <span class="value">{{ address || 'Not added yet' }}</span>
        </div>

      </div>
    </section>

    <!-- Upcoming Events -->
    <section class="section">
      <h2>Your Upcoming Events</h2>

      <div class="card">
        <div v-if="bookings.length === 0">
          No current bookings.
        </div>

        <div
          v-for="booking in bookings"
          :key="booking.id"
          class="event-item"
        >
          {{ booking.event_title }}
        </div>
      </div>
    </section>

    <!-- Membership -->
    <section class="section">
      <h2>Your Membership</h2>

      <div class="card">
        <ul class="benefits">
          <li>Access to curated events</li>
          <li>Partner perks & discounts</li>
          <li>Private member network</li>
          <li>Priority booking access</li>
        </ul>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const firstName = ref(null)
const address = ref(null)
const photo = ref(null)
const bookings = ref([])

onMounted(async () => {

  const { data } = await supabase.auth.getUser()

  if (data.user) {

    user.value = data.user

    const { data: member } = await supabase
      .from('members')
      .select('first_name, address, photo_url')
      .eq('email', data.user.email)
      .single()

    firstName.value = member?.first_name
    address.value = member?.address
    photo.value = member?.photo_url

    // Placeholder booking query
    const { data: userBookings } = await supabase
      .from('bookings')
      .select('id, event_title')
      .eq('user_email', data.user.email)

    if (userBookings) bookings.value = userBookings

  }

})
</script>

<style scoped>

.account-wrapper {
  padding: 160px 40px 120px 40px;
  max-width: 800px;
  margin: 0 auto;
}

.section {
  margin-top: 60px;
}

.section h2 {
  margin-bottom: 20px;
  font-size: 18px;
}

.card {
  background: white;
  padding: 30px;
  border-radius: 20px;
  border: 1px solid #eee;
}

.row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

.label {
  font-size: 11px;
  letter-spacing: 2px;
  opacity: 0.6;
}

.value {
  font-size: 14px;
}

.photo-row {
  margin-bottom: 25px;
}

.avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
}

.avatar.placeholder {
  background: #111;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}

.event-item {
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

.benefits {
  list-style: none;
  padding: 0;
}

.benefits li {
  margin-bottom: 10px;
}

</style>