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
        <div>
  <img v-if="avatarUrl" :src="avatarUrl" class="avatar-img" />
  <div v-else class="avatar"></div>

  <input type="file" @change="uploadAvatar" class="file-input" />
</div>

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
  const { data, error } = await supabase.auth.signInWithPassword({
    email: email.value,
    password: password.value
  })

  if (error) {
    alert(error.message)
    return
  }

  user.value = data.user
  location.reload()
}

const logout = async () => {
  await supabase.auth.signOut()
  user.value = null
  firstName.value = null
  bookings.value = []
}

const uploadAvatar = async (event) => {

  const file = event.target.files[0]
  if (!file || !user.value) return

  const filePath = `${user.value.id}-${Date.now()}`

  await supabase.storage
    .from('avatars')
    .upload(filePath, file)

  const { data } = supabase
    .storage
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
  padding: 120px 40px 140px 40px;
}

/* Greeting Row */
.greeting-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 60px;
}

.greeting {
  font-size: 22px;
  letter-spacing: 1px;
}

.logout-btn {
  background: transparent;
  border: 1px solid #000;
  padding: 8px 16px;
  font-size: 12px;
  letter-spacing: 2px;
  cursor: pointer;
  transition: 0.3s ease;
}

.logout-btn:hover {
  background: #000;
  color: white;
}

/* Section Layout */
.section {
  margin-bottom: 80px;
}

.section h2 {
  font-size: 34px;
  margin-bottom: 30px;
  letter-spacing: 2px;
}

/* Account Card */
.account-card {
  display: flex;
  gap: 40px;
  align-items: center;
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

/* Avatar */
.avatar-img {
  width: 120px;
  height: 120px;
  border-radius: 100%;
  object-fit: cover;
}

.avatar {
  width: 120px;
  height: 120px;
  border-radius: 100%;
  background: #eee;
}

.file-input {
  margin-top: 15px;
  font-size: 12px;
}

.info {
  font-size: 15px;
  line-height: 1.8;
}

/* Bookings */
.booking-card {
  background: white;
  padding: 25px 30px;
  border-radius: 18px;
  margin-bottom: 20px;
  box-shadow: 0 15px 30px rgba(0,0,0,0.04);
}

.booking-title {
  font-size: 16px;
  margin-bottom: 6px;
}

.booking-date {
  font-size: 13px;
  opacity: 0.6;
}

/* Membership */
.membership-card {
  background: #F3EBDD;
  border: 1px solid #A8985F;
  padding: 30px;
  border-radius: 18px;
  font-size: 14px;
  line-height: 1.6;
}

/* Login Block */
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
  cursor: pointer;
}

.primary-btn:hover {
  opacity: 0.9;
}

/* Responsive */
@media (max-width: 768px) {

  .account-wrapper {
    padding: 100px 20px 140px 20px;
  }

  .account-card {
    flex-direction: column;
    align-items: flex-start;
  }

}

</style>