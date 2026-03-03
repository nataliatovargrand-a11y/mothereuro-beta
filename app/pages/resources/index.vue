<template>
  <div class="category-wrapper">

    <h1>{{ categoryTitle }}</h1>

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
    .eq('access_level', 'public')

  resources.value = data || []
})
</script>