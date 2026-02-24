<template>
  <div class="me-container" v-if="event">

    <div class="event-detail">

      <div class="meta">
        <span>{{ formatDate(event.event_date) }}</span>
        <span class="dot">•</span>
        <span>{{ event.location }}</span>
      </div>

      <h1 class="title">
        {{ event.title }}
      </h1>

      <p v-if="event.description" class="description">
        {{ event.description }}
      </p>

      <button class="me-button" @click="goToEvent">
        Register on Luma
      </button>

    </div>

  </div>

  <div v-else class="me-container">
    Loading event...
  </div>
</template>

<script setup>

const route = useRoute()
const supabase = useSupabaseClient()

const { data: event } = await useAsyncData(
  'event',
  async () => {
    const { data, error } = await supabase
      .from('events')
      .select('*')
      .eq('id', route.params.id)
      .single()

    if (error) {
      console.error(error)
      return null
    }

    return data
  }
)

const goToEvent = () => {
  if (event.value?.luma_url) {
    window.open(event.value.luma_url, '_blank')
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric'
  })
}

</script>

<style scoped>

.event-detail {
  max-width: 700px;
}

.meta {
  font-size: 13px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--me-muted);
  margin-bottom: 20px;
}

.dot {
  margin: 0 8px;
}

.title {
  font-size: 42px;
  margin-bottom: 30px;
  line-height: 1.2;
}

.description {
  font-weight: 300;
  margin-bottom: 40px;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .title {
    font-size: 30px;
  }
}

</style>
