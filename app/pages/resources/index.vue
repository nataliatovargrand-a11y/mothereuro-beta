<template>
  <div class="explore-wrapper">

    <!-- Editorial Header -->
    <div class="explore-hero">
      <h1>Explore</h1>
      <p>
        A curated collection of trusted beauty, travel, food,
        and wellness resources across Europe.
      </p>

      <input
        v-model="search"
        type="text"
        placeholder="Search by keyword..."
        class="search-input"
      />
    </div>

    <!-- Category Blocks -->
    <div class="category-grid">
      <NuxtLink
        v-for="cat in categories"
        :key="cat"
        :to="`/resources/${cat.toLowerCase()}`"
        class="category-card"
      >
        <div class="category-title">
          {{ cat }}
        </div>
      </NuxtLink>
    </div>

    <!-- Divider -->
    <div class="divider"></div>

    <!-- Featured Resources -->
    <div class="section-header">
      Featured Resources
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

          <p class="description">
            {{ resource.description }}
          </p>

          <div class="tag-row">
            <span
              v-for="tag in resource.tags?.split(',')"
              :key="tag"
              class="tag"
            >
              {{ tag.trim() }}
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
    r.tags?.toLowerCase().includes(search.value.toLowerCase())
  )
})
</script>

<style scoped>

.explore-wrapper {
  padding: 140px 40px 140px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Hero */
.explore-hero {
  max-width: 700px;
  margin-bottom: 100px;
}

.explore-hero h1 {
  font-size: 56px;
  font-weight: 400;
  margin-bottom: 20px;
}

.explore-hero p {
  font-size: 18px;
  line-height: 1.7;
  margin-bottom: 40px;
  opacity: 0.75;
}

.search-input {
  width: 100%;
  padding: 18px;
  border: 1px solid rgba(0,0,0,0.1);
  font-size: 14px;
}

/* Categories */
.category-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  margin-bottom: 120px;
}

.category-card {
  border: 1px solid black;
  padding: 40px;
  text-align: center;
  text-decoration: none;
  transition: 0.3s ease;
}

.category-card:hover {
  background: black;
  color: white;
}

.category-title {
  font-size: 18px;
  letter-spacing: 2px;
}

/* Divider */
.divider {
  height: 1px;
  background: rgba(0,0,0,0.08);
  margin-bottom: 80px;
}

/* Section Header */
.section-header {
  font-size: 16px;
  letter-spacing: 3px;
  margin-bottom: 60px;
}

/* Resources */
.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 60px;
}

.resource-card {
  transition: 0.3s ease;
}

.resource-card:hover {
  transform: translateY(-6px);
}

.resource-image {
  width: 100%;
  height: 240px;
  object-fit: cover;
  margin-bottom: 30px;
}

.resource-content h2 {
  font-size: 22px;
  margin-bottom: 12px;
}

.description {
  font-size: 15px;
  line-height: 1.6;
  margin-bottom: 18px;
  opacity: 0.8;
}

.tag-row {
  margin-bottom: 25px;
}

.tag {
  font-size: 11px;
  margin-right: 8px;
  opacity: 0.6;
}

.resource-btn {
  padding: 14px 24px;
  background: black;
  color: white;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 2px;
  transition: 0.3s ease;
}

.resource-btn:hover {
  background: #A8985F;
}

@media (max-width: 900px) {
  .category-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .explore-wrapper {
    padding: 120px 20px 140px;
  }
}

</style>