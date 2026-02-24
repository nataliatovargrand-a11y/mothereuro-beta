<template>
  <div class="page">

    <h1 class="page-title">Upcoming Events</h1>

    <div class="cards">

      <div
        v-for="event in events"
        :key="event.id"
        class="card"
      >

        <div class="image-wrapper">
          <img
            :src="event.image_url"
            class="image"
          />
        </div>

        <div class="content">
          <p class="meta">
            {{ formatDate(event.event_date) }} • {{ event.location }}
          </p>

          <h2 class="title">
            {{ event.title }}
          </h2>

          <button
            class="button"
            @click="openLuma(event.luma_url)"
          >
            Book via Luma
          </button>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
const supabase = useSupabaseClient()
const events = ref([])

onMounted(async () => {
  const { data } = await supabase
    .from('events')
    .select('*')
    .order('event_date', { ascending: true })

  events.value = data || []
})

const openLuma = (url) => {
  if (url) window.open(url, '_blank')
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>

.page {
  padding: 60px 40px;
  background: #fafafa;
  min-height: 100vh;
}

.page-title {
  font-size: 42px;
  margin-bottom: 50px;
}

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 40px;
}

.card {
  background: white;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  transition: transform 0.3s ease;
}

.card:hover {
  transform: translateY(-6px);
}

.image-wrapper {
  height: 240px;
  overflow: hidden;
}

.image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.content {
  padding: 30px;
}

.meta {
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #888;
  margin-bottom: 15px;
}

.title {
  font-size: 22px;
  margin-bottom: 25px;
}

.button {
  background: black;
  color: white;
  border: none;
  padding: 12px 22px;
  border-radius: 30px;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
}

.button:hover {
  background: #4b7c6b;
}

</style>
