<template>
  <div class="explore-wrapper">

    <!-- Editorial Hero -->
    <div class="explore-hero">
      <h1>Explore</h1>

      <div class="hero-subline">
        Curated beauty, travel, food, and wellness discoveries
        across Europe for women building abroad.
      </div>

      <input
        v-model="search"
        type="text"
        placeholder="Search by keyword..."
        class="search-input"
      />
    </div>

    <!-- Featured Resource -->
    <div v-if="featured" class="featured-resource">

      <img
        :src="featured.image_url"
        class="featured-image"
      />

      <div class="featured-content">
        <h2>{{ featured.title }}</h2>
        <p>{{ featured.description }}</p>

        <a
          :href="featured.link_url"
          target="_blank"
          class="resource-btn"
        >
          Explore Resource
        </a>
      </div>

    </div>

<ExploreMap @citySelected="selectedCity = $event" />

    <!-- Luxury Category Visual Blocks -->
    <div class="category-visual-grid">

      <NuxtLink to="/resources/beauty" class="category-visual beauty">
        <div class="overlay"></div>
        <span>Beauty</span>
      </NuxtLink>

      <NuxtLink to="/resources/travel" class="category-visual travel">
        <div class="overlay"></div>
        <span>Travel</span>
      </NuxtLink>

      <NuxtLink to="/resources/food" class="category-visual food">
        <div class="overlay"></div>
        <span>Food</span>
      </NuxtLink>

      <NuxtLink to="/resources/wellness" class="category-visual wellness">
        <div class="overlay"></div>
        <span>Wellness</span>
      </NuxtLink>

    </div>

    <!-- Divider -->
    <div class="divider"></div>

    <!-- Section Header -->
    <div class="section-header">
      Featured Resources
    </div>

<div v-if="selectedCity" class="map-filter">
  Showing resources in {{ selectedCity }}
</div>

    <!-- Resources Grid -->
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
import ExploreMap from '~/components/ExploreMap.vue'

const resources = ref([])
const search = ref('')
const featured = ref(null)
const selectedCity = ref(null)

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)
    .eq('access_level', 'public')

  resources.value = data || []
  featured.value = resources.value.find(r => r.featured === true)
})

const filteredResources = computed(() => {

  return resources.value.filter(r => {

    const searchMatch =
      r.title?.toLowerCase().includes(search.value.toLowerCase()) ||
      r.tags?.toLowerCase().includes(search.value.toLowerCase())

    const cityMatch =
      !selectedCity.value || r.city === selectedCity.value

    return searchMatch && cityMatch

  })

})
</script>

<style scoped>

/* Layout */
.explore-wrapper {
  padding: 160px 40px 140px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Editorial Hero */
.explore-hero {
  max-width: 760px;
  margin-bottom: 140px;
}

.explore-hero h1 {
  font-size: 68px;
  font-weight: 300;
  letter-spacing: -1px;
  margin-bottom: 30px;
}

.hero-subline {
  font-size: 20px;
  line-height: 1.8;
  opacity: 0.7;
  margin-bottom: 50px;
  max-width: 620px;
}

.search-input {
  width: 100%;
  padding: 20px;
  border: none;
  border-bottom: 1px solid rgba(0,0,0,0.2);
  background: transparent;
  font-size: 15px;
  letter-spacing: 1px;
}

/* Featured Section */
.featured-resource {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 80px;
  align-items: center;
  margin-bottom: 160px;
}

.featured-image {
  width: 100%;
  height: 460px;
  object-fit: cover;
}

.featured-content h2 {
  font-size: 36px;
  font-weight: 400;
  margin-bottom: 24px;
}

.featured-content p {
  font-size: 18px;
  line-height: 1.8;
  margin-bottom: 30px;
  opacity: 0.85;
}

/* Category Visual Grid */
.category-visual-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  margin-bottom: 160px;
}

.category-visual {
  position: relative;
  height: 300px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  overflow: hidden;
  transition: 0.4s ease;
}

.category-visual span {
  position: relative;
  color: white;
  font-size: 26px;
  font-weight: 300;
  letter-spacing: 6px;
  text-transform: uppercase;
  z-index: 2;
}

.category-visual .overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to top,
    rgba(0,0,0,0.6),
    rgba(0,0,0,0.15)
  );
  transition: 0.4s ease;
}

.category-visual:hover .overlay {
  background: linear-gradient(
    to top,
    rgba(0,0,0,0.45),
    rgba(0,0,0,0.05)
  );
}

/* Background Images */
.beauty {
  background: url('/images/beauty.jpg') center/cover no-repeat;
}

.travel {
  background: url('/images/travel.jpg') center/cover no-repeat;
}

.food {
  background: url('/images/food.jpg') center/cover no-repeat;
}

.wellness {
  background: url('/images/wellness.jpg') center/cover no-repeat;
}

/* Divider */
.divider {
  height: 1px;
  background: rgba(0,0,0,0.08);
  margin-bottom: 100px;
}

/* Section Header */
.section-header {
  font-size: 14px;
  letter-spacing: 4px;
  margin-bottom: 80px;
  opacity: 0.6;
}

/* Resources Grid */
.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
  gap: 80px;
}

.resource-card:hover {
  transform: translateY(-4px);
}

.resource-image {
  width: 100%;
  height: 340px;
  object-fit: cover;
  margin-bottom: 40px;
}

.resource-content h2 {
  font-size: 26px;
  font-weight: 400;
  margin-bottom: 16px;
}

.description {
  font-size: 16px;
  line-height: 1.8;
  margin-bottom: 24px;
  opacity: 0.75;
}

.tag {
  font-size: 11px;
  margin-right: 10px;
  opacity: 0.5;
}

.resource-btn {
  padding: 16px 30px;
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
@media (max-width: 900px) {
  .category-visual-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .featured-resource {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .explore-wrapper {
    padding: 120px 20px 140px;
  }
}
</style>