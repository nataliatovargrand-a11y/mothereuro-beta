<template>
  <div class="category-wrapper">

    <div class="category-header">
      <h1>{{ formattedCategory }}</h1>
    </div>

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
import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const route = useRoute()
const resources = ref([])

const formattedCategory = computed(() => {
  return route.params.category.charAt(0).toUpperCase() +
         route.params.category.slice(1)
})

onMounted(async () => {
  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('category', formattedCategory.value)
    .eq('active', true)
    .eq('access_level', 'public')

  resources.value = data || []
})
</script>

<style scoped>

.category-wrapper {
  padding: 120px 40px 140px;
  max-width: 1200px;
  margin: 0 auto;
}

.category-header {
  margin-bottom: 60px;
}

.category-header h1 {
  font-size: 42px;
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

.resource-btn {
  display: inline-block;
  padding: 12px 22px;
  background: black;
  color: white;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 2px;
}

</style>