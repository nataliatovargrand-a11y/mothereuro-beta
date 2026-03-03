<template>
  <div class="explore-wrapper">

    <div class="explore-header">
      <h1>Explore</h1>

      <input
        v-model="search"
        type="text"
        placeholder="Search resources..."
        class="search-input"
      />
    </div>

    <div class="category-row">
      <NuxtLink
        v-for="cat in categories"
        :key="cat"
        :to="`/resources/${cat.toLowerCase()}`"
        class="category-pill"
      >
        {{ cat }}
      </NuxtLink>
    </div>

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
          <h2>{{ resource.title }}</h2>
          <p>{{ resource.description }}</p>

          <div class="tag-row">
            <span
              v-for="tag in resource.tags"
              :key="tag"
              class="tag"
            >
              {{ tag }}
            </span>
          </div>

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
import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const resources = ref([])
const search = ref('')

const categories = ['Beauty', 'Travel', 'Food', 'Wellness']

onMounted(async () => {
  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)
    .eq('access_level', 'public')

  resources.value = data || []
})

const filteredResources = computed(() => {
  return resources.value.filter(r =>
    r.title.toLowerCase().includes(search.value.toLowerCase()) ||
    r.tags?.join(' ').toLowerCase().includes(search.value.toLowerCase())
  )
})
</script>

<style scoped>

.explore-wrapper {
  padding: 120px 40px 140px;
  max-width: 1200px;
  margin: 0 auto;
}

.explore-header {
  margin-bottom: 40px;
}

.explore-header h1 {
  font-size: 42px;
  margin-bottom: 20px;
}

.search-input {
  width: 100%;
  padding: 16px;
  border: 1px solid #ddd;
  font-size: 14px;
}

.category-row {
  display: flex;
  gap: 20px;
  margin-bottom: 60px;
  flex-wrap: wrap;
}

.category-pill {
  padding: 10px 18px;
  border: 1px solid black;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 2px;
}

.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 40px;
}

.resource-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

.resource-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.resource-content {
  padding: 30px;
}

.tag-row {
  margin: 15px 0;
}

.tag {
  display: inline-block;
  font-size: 11px;
  margin-right: 8px;
  opacity: 0.6;
}

.resource-btn {
  display: inline-block;
  padding: 12px 22px;
  background: black;
  color: white;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 2px;
}

@media (max-width: 768px) {
  .explore-wrapper {
    padding: 100px 20px 140px;
  }
}

</style>