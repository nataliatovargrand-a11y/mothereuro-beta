<template>
  <div class="category-wrapper">

    <!-- Editorial Header -->
    <div class="category-hero">
      <h1>{{ categoryTitle }}</h1>
      <div class="subline">
        Curated {{ categoryTitle }} discoveries across Europe.
      </div>
    </div>

    <!-- Resources Grid -->
    <div class="resources-grid">

      <div
        v-for="resource in resources"
        :key="resource.id"
        class="resource-card"
      >

        <img
          v-if="resource.image_url"
          :src="resource.image_url"
          class="resource-image"
        />

        <div class="resource-content">

          <!-- Geo Tag -->
          <div class="meta-row">
            <span class="city">
              {{ resource.city || 'Europe-wide' }}
            </span>
          </div>

          <h2>{{ resource.title }}</h2>

          <p class="description">
            {{ resource.description }}
          </p>

          <a
            :href="resource.link_url"
            target="_blank"
            class="resource-btn"
          >
            Explore
          </a>

        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const route = useRoute()
const resources = ref([])
const categoryTitle = route.params.category

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('category', categoryTitle)
    .eq('active', true)

  resources.value = data || []

})
</script>

<style scoped>

/* Layout */
.category-wrapper {
  padding: 160px 40px 140px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Hero */
.category-hero {
  margin-bottom: 120px;
  max-width: 700px;
}

.category-hero h1 {
  font-size: 64px;
  font-weight: 300;
  letter-spacing: -1px;
  margin-bottom: 24px;
  text-transform: capitalize;
}

.subline {
  font-size: 18px;
  opacity: 0.7;
  line-height: 1.8;
}

/* Grid */
.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
  gap: 100px 60px;
}

/* Card */
.resource-card {
  transition: 0.4s ease;
}

.resource-card:hover {
  transform: translateY(-4px);
}

.resource-image {
  width: 100%;
  height: 360px;
  object-fit: cover;
  margin-bottom: 40px;
}

/* Metadata */
.meta-row {
  margin-bottom: 12px;
}

.city {
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  opacity: 0.5;
}

/* Typography */
.resource-content h2 {
  font-size: 24px;
  font-weight: 400;
  margin-bottom: 16px;
}

.description {
  font-size: 16px;
  line-height: 1.8;
  margin-bottom: 24px;
  opacity: 0.75;
}

/* Button */
.resource-btn {
  padding: 14px 26px;
  background: black;
  color: white;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 3px;
  transition: 0.3s ease;
}

.resource-btn:hover {
  background: #A8985F;
}

/* Responsive */
@media (max-width: 768px) {
  .category-wrapper {
    padding: 120px 20px 140px;
  }

  .category-hero h1 {
    font-size: 44px;
  }
}
</style>