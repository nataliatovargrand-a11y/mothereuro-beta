<template>
  <div class="account-wrapper">

    <!-- Greeting -->
   <div v-if="firstName" class="greeting-row">
  <div class="greeting">
    Hi, {{ firstName }}
  </div>

  <button class="logout-btn" @click="logout">
    Logout
  </button>
</div>

    <!-- Not logged in -->
    <div v-if="!user" class="login-block">
      <h2>Member Access</h2>

      <input
        v-model="email"
        type="email"
        placeholder="Email"
        class="input"
      />

      <input
        v-model="password"
        type="password"
        placeholder="Password"
        class="input"
      />

      <button @click="login" class="primary-btn">
        Login
      </button>
    </div>

    <!-- Logged in content -->
    <div v-else>

      <!-- Account Information -->
      <div class="section">
        <h2>Account Information</h2>

        <div class="account-card">
          <div class="avatar"></div>

          <div class="info">
            <div><strong>Name:</strong> {{ firstName }}</div>
            <div><strong>Email:</strong> {{ user.email }}</div>
            <div><strong>Address:</strong> —</div>
          </div>
        </div>
      </div>

      <!-- Upcoming Events -->
      <div class="section">
        <h2>Your Upcoming Events</h2>

        <div v-if="bookings.length === 0" class="empty">
          No bookings yet.
        </div>

        <div
          v-for="booking in bookings"
          :key="booking.id"
          class="booking-card"
        >
          <div class="booking-title">
            {{ booking.event_title }}
          </div>
          <div class="booking-date">
            {{ formatDate(booking.event_date) }}
          </div>
        </div>
      </div>

      <!-- Membership -->
      <div class="section">
        <h2>Your Membership</h2>

        <div class="membership-card">
          <div>Status: {{ membershipStatus }}</div>
          <div>Invite-only private membership</div>
        </div>
      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const firstName = ref(null)
const membershipStatus = ref(null)
const bookings = ref([])

const email = ref('')
const password = ref('')

onMounted(async () => {
  const { data } = await supabase.auth.getUser()
  user.value = data.user

  if (data.user) {
    loadMemberData(data.user.email)
  }
})

const loadMemberData = async (emailAddress) => {

  const { data: member } = await supabase
    .from('members')
    .select('first_name, membership_status')
    .eq('email', emailAddress)
    .single()

  firstName.value = member?.first_name || ''
  membershipStatus.value = member?.membership_status || 'pending'

  const { data: bookingData } = await supabase
    .from('bookings')
    .select('*')
    .eq('user_email', emailAddress)
    .order('event_date', { ascending: true })

  if (bookingData) {
    bookings.value = bookingData
  }
}

const login = async () => {
  const { data, error } = await supabase.auth.signInWithPassword({
    email: email.value,
    password: password.value
  })

  if (!error && data.user) {
    user.value = data.user
    loadMemberData(data.user.email)
  }
}
const logout = async () => {
  await supabase.auth.signOut()
  user.value = null
  firstName.value = null
  membershipStatus.value = null
  bookings.value = []
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>

.account-wrapper {
  padding: 140px 40px 160px 40px;
  max-width: 900px;
  margin: 0 auto;
}

/* Greeting */

.greeting {
  font-size: 28px;
  letter-spacing: 2px;
  margin-bottom: 70px;
  font-weight: 400;
}

/* Sections */

.section {
  margin-bottom: 90px;
}

.section h2 {
  font-size: 18px;
  letter-spacing: 3px;
  text-transform: uppercase;
  margin-bottom: 30px;
  opacity: 0.7;
}

/* Account Info Card */

.account-card {
  display: flex;
  gap: 40px;
  background: white;
  padding: 40px;
  border-radius: 28px;
  box-shadow: 0 30px 60px rgba(0,0,0,0.04);
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #e8e2d6;
}

.info div {
  margin-bottom: 12px;
  font-size: 15px;
}

/* Bookings */

.booking-card {
  background: white;
  padding: 30px;
  border-radius: 24px;
  margin-bottom: 20px;
  box-shadow: 0 20px 50px rgba(0,0,0,0.04);
  transition: all 0.3s ease;
}

.booking-card:hover {
  transform: translateY(-4px);
}

.booking-title {
  font-size: 18px;
  margin-bottom: 8px;
  font-weight: 500;
}

.booking-date {
  font-size: 14px;
  letter-spacing: 1px;
  opacity: 0.6;
}

/* Membership */

.membership-card {
  background: #F3EBDD;
  padding: 30px;
  border-radius: 24px;
  border: 1px solid #A8985F;
  font-size: 15px;
  line-height: 1.6;
}

/* Login Block */

.login-block {
  max-width: 420px;
}

.input {
  width: 100%;
  padding: 14px;
  margin-bottom: 18px;
  border: 1px solid #ddd;
  background: white;
  font-size: 14px;
}

.primary-btn {
  background: #A8985F;
  color: white;
  border: none;
  padding: 14px 24px;
  letter-spacing: 2px;
  font-size: 12px;
  cursor: pointer;
  transition: 0.3s ease;
}

.primary-btn:hover {
  background: #8f8151;
}

.empty {
  opacity: 0.6;
}

@media (max-width: 768px) {

  .account-wrapper {
    padding: 120px 20px 160px 20px;
  }

  .account-card {
    flex-direction: column;
  }
.greeting-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 70px;
}

.logout-btn {
  background: transparent;
  border: 1px solid rgba(0,0,0,0.2);
  padding: 8px 16px;
  font-size: 12px;
  letter-spacing: 2px;
  cursor: pointer;
  transition: 0.3s ease;
}

.logout-btn:hover {
  background: rgba(0,0,0,0.05);
}
}

</style>