<template>
  <div class="me-container">

    <div class="header">
      <h1>Upcoming Events</h1>
    </div>

    <div class="events-list">

      <div
        v-for="event in events"
        :key="event.id"
        class="event-row"
      >

        <div class="event-left">

          <div class="time">
            {{ formatTime(event.event_date) }}
          </div>

          <h2 class="title">
            {{ event.title }}
          </h2>

          <div class="organizer">
            By Mother Euro
          </div>

          <div class="location">
            {{ event.location }}
          </div>

          <button
            class="status-btn"
            @click="openLuma(event.luma_url)"
          >
            Reserve Spot
          </button>

        </div>

        <div class="event-right">
          <img
            v-if="event.image_url"
            :src="event.image_url"
            class="thumb"
          />
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
const supabase = useSupabaseClient()
const events = ref([])

onMounted(async () => {
  const { data, error } = await supabase
    .from('events')
    .select('*')
    .order('event_date', { ascending: true })

  if (!error) events.value = data
})

const openLuma = (url) => {
  if (url) window.open(url, '_blank')
}

const formatTime = (date) => {
  return new Date(date).toLocaleTimeString([], {
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>

<style scoped>

.header {
  margin-bottom: 40px;
}

.header h1 {
  font-size: 36px;
}

.events-list {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.event-row {
  display: flex;
  justify-content: space-between;
  background: white;
  padding: 30px;
  border-radius: 20px;
  border: 1px solid #eee;
  transition: all 0.3s ease;
  align-items: center;
}

.event-row:hover {
  box-shadow: 0 20px 40px rgba(0,0,0,0.06);
  transform: translateY(-3px);
}

.event-left {
  flex: 1;
}

.time {
  font-size: 20px;
  color: #999;
  margin-bottom: 8px;
}

.title {
  font-size: 22px;
  margin-bottom: 10px;
}

.organizer {
  font-size: 14px;
  color: #888;
  margin-bottom: 5px;
}

.location {
  font-size: 14px;
  color: #888;
  margin-bottom: 20px;
}

.status-btn {
  background: #111;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 20px;
  font-size: 12px;
  letter-spacing: 1px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s;
}

.status-btn:hover {
  background: var(--me-accent);
}

.event-right {
  width: 140px;
  height: 140px;
  margin-left: 30px;
}

.thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 18px;
}

@media (max-width: 768px) {
  .event-row {
    flex-direction: column;
    align-items: flex-start;
  }

  .event-right {
    width: 100%;
    height: 200px;
    margin-left: 0;
    margin-top: 20px;
  }
}

</style>
