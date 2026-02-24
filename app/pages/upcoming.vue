<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const events = ref<any[]>([])

onMounted(async () => {
  const { data } = await supabase
    .from('events')
    .select('*')

  if (data) events.value = data
})
</script>

<template>
  <div>
    <h1>Upcoming Events</h1>

    <div
      v-for="event in events"
      :key="event.id"
      style="margin-bottom:20px; border:1px solid #ddd; padding:20px"
    >
      <h2>{{ event.title }}</h2>
      <p>{{ event.date }}</p>
      <p>{{ event.city }}</p>
    </div>
  </div>
</template>
