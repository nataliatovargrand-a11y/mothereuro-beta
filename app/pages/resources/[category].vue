<template>
  <div class="category-wrapper">

    <!-- HERO -->
    <div class="beauty-hero" v-if="categoryTitle === 'beauty'">
      <h1>Beauty</h1>
      <p>
        Private recommendations across skincare, makeup,
        hair, and supplements curated for European living.
      </p>
    </div>

    <div v-else class="category-header">
      <h1>{{ formattedTitle }}</h1>
    </div>

    <!-- Subcategory Navigation (Beauty Only) -->
    <div v-if="categoryTitle === 'beauty'" class="subcategory-nav">
      <button
        v-for="sub in beautySections"
        :key="sub"
        :class="['sub-btn', selectedSub === sub ? 'active' : '']"
        @click="selectedSub = sub"
      >
        {{ formatSub(sub) }}
      </button>
    </div>

    <!-- RESOURCE SECTIONS -->
    <div
      v-for="section in groupedResources"
      :key="section.name"
      class="section-block"
    >

      <h2 class="section-title">
        {{ formatSub(section.name) }}
      </h2>

      <div class="resources-grid">

        <div
          v-for="resource in section.items"
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

            <h3>{{ resource.title }}</h3>

            <p>{{ resource.description }}</p>

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

  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const route = useRoute()
const categoryTitle = route.params.category
const resources = ref([])
const selectedSub = ref('')

const beautySections = [
  'skincare',
  'makeup',
  'supplements',
  'hair'
]

const formattedTitle = computed(() =>
  categoryTitle.charAt(0).toUpperCase() + categoryTitle.slice(1)
)

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('category', categoryTitle)
    .eq('active', true)

  resources.value = data || []

  if (categoryTitle === 'beauty') {
    selectedSub.value = 'skincare'
  }

})

const groupedResources = computed(() => {

  if (categoryTitle !== 'beauty') {
    return [{
      name: formattedTitle.value,
      items: resources.value
    }]
  }

  return beautySections.map(section => ({
    name: section,
    items: resources.value.filter(r =>
      r.subcategory === section
    )
  }))
})

const formatSub = (text) =>
  text.charAt(0).toUpperCase() + text.slice(1)
</script>

<style scoped>

/* Layout */
.category-wrapper {
  padding: 140px 40px 160px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Hero */
.beauty-hero {
  margin-bottom: 100px;
  max-width: 700px;
}

.beauty-hero h1 {
  font-size: 64px;
  font-weight: 300;
  margin-bottom: 20px;
}

.beauty-hero p {
  font-size: 18px;
  opacity: 0.7;
  line-height: 1.8;
}

/* Sub Nav */
.subcategory-nav {
  display: flex;
  gap: 30px;
  margin-bottom: 80px;
}

.sub-btn {
  background: transparent;
  border: none;
  font-size: 14px;
  letter-spacing: 2px;
  opacity: 0.5;
  cursor: pointer;
}

.sub-btn.active {
  opacity: 1;
  border-bottom: 1px solid black;
}

/* Sections */
.section-block {
  margin-bottom: 120px;
}

.section-title {
  font-size: 28px;
  font-weight: 400;
  margin-bottom: 40px;
}

/* Grid */
.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 60px;
}

.resource-card {
  transition: 0.3s ease;
}

.resource-card:hover {
  transform: translateY(-4px);
}

.resource-image {
  width: 100%;
  height: 340px;
  object-fit: cover;
  margin-bottom: 30px;
}

.resource-city {
  font-size: 12px;
  letter-spacing: 2px;
  opacity: 0.5;
  margin-bottom: 8px;
}

.resource-btn {
  display: inline-block;
  margin-top: 20px;
  padding: 12px 24px;
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
    padding: 100px 20px 160px;
  }

  .subcategory-nav {
    flex-wrap: wrap;
  }
}

</style>