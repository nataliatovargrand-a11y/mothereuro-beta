<template>
  <div class="account-wrapper">

    <!-- Greeting -->
    <div v-if="user" class="dashboard-header">
      <div>
        <h1>Hi, {{ firstName }}</h1>
        <p class="subtext">
          Welcome back to your private member portal.
        </p>
      </div>

      <button class="logout-btn" @click="logout">
        Logout
      </button>
    </div>

    <!-- Login Block -->
    <div v-if="!user" class="login-block">
      <h2>Member Access</h2>

      <input v-model="email" type="email" placeholder="Email" class="input" />
      <input v-model="password" type="password" placeholder="Password" class="input" />

      <button @click="login" class="primary-btn">
        Login
      </button>
    </div>

    <!-- Logged In Content -->
    <div v-else>

      <!-- PROFILE -->
      <div class="section">
        <h2>Profile</h2>

        <div class="card profile-card">

          <div class="avatar-block">
            <img v-if="avatarUrl" :src="avatarUrl" class="avatar-img" />
            <div v-else class="avatar-placeholder"></div>
            <input type="file" @change="uploadAvatar" class="file-input" />
          </div>

          <div class="profile-info">
            <div><strong>Name:</strong> {{ firstName }}</div>
            <div><strong>Email:</strong> {{ user.email }}</div>
            <div class="membership-badge">
              {{ membershipStatus }}
            </div>
          </div>

        </div>
      </div>

      <!-- UPCOMING EVENTS -->
      <div class="section">
        <h2>Your Upcoming Events</h2>

        <div v-if="bookings.length === 0" class="empty">
          No bookings yet.
        </div>

        <div
          v-for="booking in bookings"
          :key="booking.id"
          class="card booking-card"
        >
          <div class="booking-title">
            {{ booking.event_title }}
          </div>
          <div class="booking-date">
            {{ formatDate(booking.event_date) }}
          </div>
        </div>
      </div>

      <!-- MEMBERSHIP -->
      <div class="section">
        <h2>Your Membership</h2>

        <div class="card membership-card">
          <p>
            Mother Euro is a curated private membership supporting women
            building life, business, and belonging abroad.
          </p>

          <ul>
            <li>• Access to private curated events</li>
            <li>• Strategic relocation network</li>
            <li>• Trusted local partners</li>
            <li>• Community-led growth circles</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const firstName = ref('')
const membershipStatus = ref('pending')
const bookings = ref([])
const avatarUrl = ref(null)

const email = ref('')
const password = ref('')

onMounted(async () => {
  const { data } = await supabase.auth.getUser()
  if (!data.user) return

  user.value = data.user

  const { data: member } = await supabase
    .from('members')
    .select('*')
    .eq('email', data.user.email)
    .single()

  firstName.value = member?.first_name || ''
  membershipStatus.value = member?.membership_status || 'pending'
  avatarUrl.value = member?.avatar_url || null

  const { data: bookingData } = await supabase
    .from('bookings')
    .select('*')
    .eq('user_email', data.user.email)
    .order('event_date', { ascending: true })

  bookings.value = bookingData || []
})

const login = async () => {
  await supabase.auth.signInWithPassword({
    email: email.value,
    password: password.value
  })
  location.reload()
}

const logout = async () => {
  await supabase.auth.signOut()
  location.reload()
}

const uploadAvatar = async (event) => {
  const file = event.target.files[0]
  if (!file || !user.value) return

  const filePath = `${user.value.id}-${Date.now()}`

  await supabase.storage.from('avatars').upload(filePath, file)

  const { data } = supabase.storage
    .from('avatars')
    .getPublicUrl(filePath)

  avatarUrl.value = data.publicUrl

  await supabase
    .from('members')
    .update({ avatar_url: data.publicUrl })
    .eq('email', user.value.email)
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
  max-width: 1000px;
  margin: 0 auto;
  padding: 120px 40px 140px;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 60px;
}

.dashboard-header h1 {
  font-size: 32px;
}

.subtext {
  opacity: 0.6;
  margin-top: 5px;
}

.section {
  margin-bottom: 80px;
}

.section h2 {
  font-size: 28px;
  margin-bottom: 30px;
}

.card {
  background: white;
  padding: 40px;
  border-radius: 24px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

.profile-card {
  display: flex;
  gap: 40px;
  align-items: center;
}

.avatar-img,
.avatar-placeholder {
  width: 120px;
  height: 120px;
  border-radius: 100%;
  object-fit: cover;
  background: #eee;
}

.file-input {
  margin-top: 15px;
}

.membership-badge {
  margin-top: 10px;
  font-size: 12px;
  letter-spacing: 2px;
  opacity: 0.6;
}

.booking-card {
  margin-bottom: 20px;
}

.booking-title {
  font-size: 16px;
  margin-bottom: 6px;
}

.booking-date {
  font-size: 13px;
  opacity: 0.6;
}

.membership-card ul {
  margin-top: 20px;
  line-height: 1.8;
}

.login-block {
  max-width: 400px;
  margin: 0 auto;
  padding-top: 80px;
}

.input {
  width: 100%;
  padding: 14px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
}

.primary-btn {
  width: 100%;
  padding: 14px;
  background: #A8985F;
  color: white;
  border: none;
  letter-spacing: 2px;
}

.logout-btn {
  background: transparent;
  border: 1px solid black;
  padding: 8px 16px;
  cursor: pointer;
}

</style>