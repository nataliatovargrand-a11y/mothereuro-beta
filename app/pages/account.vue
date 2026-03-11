<template>

<div class="account-wrapper">

<!-- HEADER -->

<div class="account-header">

<h1 class="greeting">
Hi, {{ member?.first_name }}
</h1>

<div class="welcome">
Welcome back to Mother Euro
</div>

<button class="logout-btn" @click="logout">
Log Out
</button>

</div>



<!-- PROFILE -->

<div class="section">

<h2>Profile</h2>

<div class="profile-card">

<div class="avatar-block">

<img
v-if="member?.avatar_url"
:src="member.avatar_url"
class="avatar"
/>

<div v-else class="avatar-placeholder"></div>

<input
type="file"
class="file-input"
@change="uploadAvatar"
/>

</div>

<div class="profile-info">

<div><strong>Name:</strong> {{ member?.first_name }}</div>
<div><strong>Email:</strong> {{ member?.email }}</div>
<div><strong>Membership:</strong> {{ member?.membership_tier }}</div>
<div><strong>Renewal date:</strong> {{ member?.renewal_date || '—' }}</div>
<div><strong>Industry:</strong> {{ member?.industry || '—' }}</div>
<div><strong>City:</strong> {{ member?.city || '—' }}</div>

</div>

</div>

</div>



<!-- MEMBERSHIP -->

<div class="section">

<h2>Your Membership</h2>

<div class="membership-card">

<div class="membership-row">

<div class="membership-item">
<div class="label">Tier</div>
<div class="value">
{{ member?.membership_tier }}
</div>
</div>

<div class="membership-item">
<div class="label">Renewal</div>
<div class="value">
{{ member?.renewal_date || '—' }}
</div>
</div>

<div
v-if="member?.membership_tier === 'global'"
class="membership-item"
>
<div class="label">Events Remaining</div>
<div class="value">
{{ remainingEvents }} / 4
</div>
</div>

</div>

</div>

</div>



<!-- UPCOMING EVENTS -->

<div class="section">

<h2>Your Upcoming Events</h2>

<div v-if="upcomingEvents.length === 0" class="empty">
No upcoming events yet.
</div>

<div
v-for="event in upcomingEvents"
:key="event.id"
class="event-card"
>

<div class="event-title">
{{ event.event_title }}
</div>

<div class="event-date">
{{ formatDate(event.event_date) }}
</div>

</div>

</div>



<!-- PAST EVENTS -->

<div class="section">

<h2>Your Past Events</h2>

<div v-if="pastEvents.length === 0" class="empty">
No past events yet.
</div>

<div
v-for="event in pastEvents"
:key="event.id"
class="event-card"
>

<div class="event-title">
{{ event.event_title }}
</div>

<div class="event-date">
{{ formatDate(event.event_date) }}
</div>

</div>

</div>



<!-- BENEFITS -->

<div class="section">

<h2>Your Membership Benefits</h2>

<div class="benefits-card">

<div v-if="member?.membership_tier === 'aspiring'">
• Community events<br>
• Relocation resources<br>
• Member introductions
</div>

<div v-if="member?.membership_tier === 'resident'">
• Full resource library<br>
• Unlimited events<br>
• Partner benefits
</div>

<div v-if="member?.membership_tier === 'global'">
• Exclusive member dinners<br>
• Global network access<br>
• Partner privileges<br>
• Up to 4 events per year
</div>

</div>

</div>

</div>

</template>



<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'
import { useRouter } from 'vue-router'

const router = useRouter()

const user = ref(null)
const member = ref(null)
const bookings = ref([])

onMounted(async () => {

  /* GET LOGGED IN USER */

  const { data: { user: authUser } } = await supabase.auth.getUser()

  if(!authUser){
    router.push('/login')
    return
  }

  user.value = authUser


  /* LOAD MEMBER PROFILE */

  const { data: memberData, error } = await supabase
    .from('members')
    .select('*')
    .eq('id', authUser.id)   // IMPORTANT FIX
    .single()

  if(error){
    console.log('Member fetch error:', error)
  }

  member.value = memberData


  /* LOAD EVENT BOOKINGS */

  const { data: bookingData } = await supabase
    .from('bookings')
    .select('*')
    .eq('user_id', authUser.id)   // IMPORTANT FIX
    .order('event_date', { ascending:true })

  bookings.value = bookingData || []

})



/* UPCOMING EVENTS */

const upcomingEvents = computed(() => {

  const today = new Date()

  return bookings.value.filter(event =>
    new Date(event.event_date) >= today
  )

})


/* PAST EVENTS */

const pastEvents = computed(() => {

  const today = new Date()

  return bookings.value.filter(event =>
    new Date(event.event_date) < today
  )

})



/* GLOBAL EVENT LIMIT */

const eventsThisYear = computed(() => {

  const year = new Date().getFullYear()

  return bookings.value.filter(event =>
    new Date(event.event_date).getFullYear() === year
  )

})

const remainingEvents = computed(() => {

  if(member.value?.membership_tier !== 'global') return null

  return 4 - eventsThisYear.value.length

})



/* LOGOUT */

const logout = async () => {

  await supabase.auth.signOut()

  router.push('/login')

}

</script>