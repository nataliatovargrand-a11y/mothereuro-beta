<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const events = ref<any[]>([])

onMounted(async () => {
  const { data, error } = await supabase
    .from('events')
    .select('*')

  if (!error && data) {
    events.value = data
  }

  console.log('Loaded events:', data)
})
</script>

<template>
  <div style="padding: 40px">
    <h1>MotherEuro Events</h1>

    <div v-for="event in events" :key="event.id" style="margin-bottom:20px; border:1px solid #ccc; padding:20px">
      <h2>{{ event.title }}</h2>
      <p>{{ event.date }}</p>
      <p>{{ event.city }}</p>
    </div>
  </div>
</template>
