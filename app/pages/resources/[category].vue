<template>
  <div class="category-wrapper">

    <!-- Header -->
    <div class="category-header">
      <h1>{{ formattedTitle }}</h1>
      <p class="category-sub">
        Curated {{ formattedTitle }} recommendations across Europe.
      </p>
    </div>

    <!-- Filters -->
    <div class="filters-row">

      <select v-model="selectedCity" class="city-select">
        <option value="">All Cities</option>
        <option v-for="city in cities" :key="city" :value="city">
          {{ city }}
        </option>
      </select>

    </div>

    <!-- Grid -->
    <div class="resources-grid">

      <div
        v-for="resource in filteredResources"
        :key="resource.id"
        class="resource-card"
      >

        <img
          v-if="resource.image_url"
          :src="resource.image_url"
          class="resource-image"
        />

        <div class="resource-content">

          <div class="resource-city">
            {{ resource.city }}
          </div>

          <h2>{{ resource.title }}</h2>
          <p>{{ resource.description }}</p>

          <a
            :href="resource.link_url"
            target="_blank"
            class="resource-btn"
          >
            View Resource
          </a>

        </div>
      </div>

    </div>

  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const route = useRoute()
const resources = ref([])
const cities = ref([])
const selectedCity = ref('')

const categoryTitle = route.params.category

const formattedTitle = computed(() => {
  return categoryTitle.charAt(0).toUpperCase() + categoryTitle.slice(1)
})

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('category', categoryTitle.toLowerCase())
    .eq('active', true)
    .eq('access_level', 'public')

  resources.value = data || []

  // Extract unique cities
  cities.value = [...new Set(resources.value.map(r => r.city).filter(Boolean))]

})

const filteredResources = computed(() => {
  if (!selectedCity.value) return resources.value
  return resources.value.filter(r => r.city === selectedCity.value)
})
</script>

<style scoped>

.category-wrapper {
  padding: 120px 40px 140px;
  max-width: 1200px;
  margin: 0 auto;
}

.category-header h1 {
  font-size: 48px;
  margin-bottom: 10px;
}

.category-sub {
  opacity: 0.7;
  margin-bottom: 50px;
}

.filters-row {
  margin-bottom: 40px;
}

.city-select {
  padding: 14px 18px;
  border: 1px solid #A8985F;
  background: transparent;
  font-size: 14px;
  letter-spacing: 1px;
  min-width: 200px;
}

.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 40px;
}

.resource-card {
  background: white;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.06);
  transition: 0.3s ease;
}

.resource-card:hover {
  transform: translateY(-6px);
}

.resource-image {
  width: 100%;
  height: 240px;
  object-fit: cover;
}

.resource-content {
  padding: 30px;
}

.resource-city {
  font-size: 12px;
  letter-spacing: 2px;
  opacity: 0.6;
  margin-bottom: 10px;
}

.resource-btn {
  display: inline-block;
  margin-top: 20px;
  padding: 12px 20px;
  background: black;
  color: white;
  text-decoration: none;
  letter-spacing: 2px;
  font-size: 12px;
  transition: 0.3s ease;
}

.resource-btn:hover {
  background: #A8985F;
}

@media (max-width: 768px) {
  .category-wrapper {
    padding: 100px 20px 140px;
  }
}

</style>