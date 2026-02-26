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