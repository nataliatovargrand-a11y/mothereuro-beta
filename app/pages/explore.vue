<template>
  <div class="explore-wrapper">

    <!-- HEADER -->

    <div class="explore-header">
      <h1>Explore</h1>

      <input
        v-model="search"
        type="text"
        placeholder="Search resources..."
        class="search-input"
      />
    </div>


    <!-- CATEGORY PILLS -->

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


    <!-- EXPLORE MAP -->

    <div class="map-section">

      <div class="map-header">
        Discover Europe
      </div>

      <ExploreMap
        @citySelected="selectedCity = $event"
      />

      <div v-if="selectedCity" class="map-filter">
        Showing resources in {{ selectedCity }}
      </div>

    </div>


    <!-- RESOURCES GRID -->

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
import ExploreMap from '~/components/ExploreMap.vue'

const resources = ref([])
const search = ref('')
const selectedCity = ref(null)

const categories = [
  'Beauty',
  'Travel',
  'Food',
  'Wellness'
]

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)
    .eq('access_level', 'public')

  resources.value = data || []

})


const filteredResources = computed(() => {

  return resources.value.filter(r => {

    const searchMatch =
      r.title?.toLowerCase().includes(search.value.toLowerCase()) ||
      r.tags?.join(' ').toLowerCase().includes(search.value.toLowerCase())

    const cityMatch =
      !selectedCity.value || r.city === selectedCity.value

    return searchMatch && cityMatch

  })

})

</script>



<style scoped>

.explore-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}


/* HEADER */

.explore-header{
margin-bottom:40px;
}

.explore-header h1{
font-size:42px;
margin-bottom:20px;
}

.search-input{
width:100%;
padding:16px;
border:1px solid #ddd;
font-size:14px;
}


/* CATEGORY */

.category-row{
display:flex;
gap:20px;
margin-bottom:60px;
flex-wrap:wrap;
}

.category-pill{
padding:10px 18px;
border:1px solid black;
text-decoration:none;
font-size:12px;
letter-spacing:2px;
transition:.2s;
}

.category-pill:hover{
background:black;
color:white;
}


/* MAP */

.map-section{
margin-bottom:100px;
}

.map-header{
font-size:12px;
letter-spacing:6px;
text-transform:uppercase;
margin-bottom:20px;
opacity:.6;
}

.map-filter{
margin-top:10px;
font-size:12px;
opacity:.6;
}


/* GRID */

.resources-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:40px;
}

.resource-card{
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 20px 40px rgba(0,0,0,0.05);
}

.resource-image{
width:100%;
height:200px;
object-fit:cover;
}

.resource-content{
padding:30px;
}

.description{
opacity:.7;
line-height:1.6;
}

.tag-row{
margin:15px 0;
}

.tag{
display:inline-block;
font-size:11px;
margin-right:8px;
opacity:.6;
}

.resource-btn{
display:inline-block;
padding:12px 22px;
background:black;
color:white;
text-decoration:none;
font-size:12px;
letter-spacing:2px;
}

.resource-btn:hover{
background:#A8985F;
}


@media(max-width:768px){

.explore-wrapper{
padding:100px 20px 140px;
}

}

</style>