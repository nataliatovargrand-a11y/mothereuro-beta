<template>
  <div class="explore-wrapper">

    <!-- HERO -->

    <div class="explore-hero">

      <h1>Explore</h1>

      <p class="hero-subtitle">
        Curated beauty, travel, gastronomy, wellness and education discoveries across Europe for women building abroad.
      </p>

      <div class="search-wrapper">

        <div class="search-icon">🔍</div>

        <input
          v-model="search"
          @input="searchPlatform"
          type="text"
          placeholder="Search members, resources, partners..."
          class="search-input"
        />

      </div>

    </div>


    <!-- MAP -->

    <div class="map-section">

      <div class="section-title">
        Discover Europe
      </div>

      <ExploreMap
        :resources="resources"
        @citySelected="selectedCity = $event"
      />

    </div>


    <!-- CATEGORY CARDS -->

    <div class="category-section">

      <NuxtLink to="/resources/beauty" class="category-card beauty">
        <span>Beauty</span>
      </NuxtLink>

      <NuxtLink to="/resources/travel" class="category-card travel">
        <span>Travel</span>
      </NuxtLink>

      <NuxtLink to="/resources/gastronomy" class="category-card gastronomy">
        <span>Gastronomy</span>
      </NuxtLink>

      <NuxtLink to="/resources/wellness" class="category-card wellness">
        <span>Wellness</span>
      </NuxtLink>

      <NuxtLink to="/resources/education" class="category-card education">
        <span>Education</span>
      </NuxtLink>

      <NuxtLink
        v-if="member?.membership_tier === 'aspiring'"
        to="/resources/relocation"
        class="category-card relocation"
      >
        <span>Relocation</span>
      </NuxtLink>

    </div>


    <!-- FEATURED -->

    <div class="featured-section">

      <h2>Editor's Picks</h2>

      <div class="featured-grid">

        <div
          v-for="resource in featuredResources"
          :key="resource.id"
          class="featured-card"
        >

          <img
            :src="resource.image_url"
            class="featured-image"
          />

          <div class="featured-info">

            <h3>{{ resource.title }}</h3>

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


    <!-- RESOURCES -->

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

          <h3>{{ resource.title }}</h3>

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

import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'
import ExploreMap from '~/components/ExploreMap.vue'

const resources = ref([])
const search = ref('')
const selectedCity = ref(null)
const member = ref(null)



onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)

  resources.value = data || []

})



const featuredResources = computed(() =>
  resources.value.filter(r => r.is_featured)
)



const filteredResources = computed(() => {

  return resources.value.filter(r => {

    const cityMatch =
      !selectedCity.value || r.city === selectedCity.value

    const searchMatch =
      !search.value ||
      r.title?.toLowerCase().includes(search.value.toLowerCase())

    return cityMatch && searchMatch

  })

})



const searchPlatform = () => {}

</script>



<style scoped>

.explore-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}



/* HERO */

.explore-hero{
margin-bottom:80px;
max-width:700px;
}

.hero-subtitle{
font-size:18px;
opacity:.7;
line-height:1.6;
margin-bottom:30px;
}



/* SEARCH */

.search-wrapper{
position:relative;
max-width:720px;
}

.search-icon{
position:absolute;
left:18px;
top:50%;
transform:translateY(-50%);
opacity:.5;
}

.search-input{
width:100%;
padding:18px 18px 18px 46px;
border-radius:12px;
border:1px solid rgba(0,0,0,0.1);
font-size:16px;
background:white;
}



/* MAP */

.map-section{
margin:80px 0;
}

.section-title{
letter-spacing:6px;
font-size:12px;
margin-bottom:20px;
opacity:.6;
}



/* CATEGORY CARDS */

.category-section{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:24px;
margin:80px 0;
}

.category-card{
position:relative;
height:260px;
display:flex;
align-items:center;
justify-content:center;
text-decoration:none;
color:white;
font-size:24px;
letter-spacing:4px;
background-size:cover;
background-position:center;
}

.category-card::after{
content:"";
position:absolute;
inset:0;
background:rgba(0,0,0,0.25);
}

.category-card span{
z-index:2;
}



/* FIXED IMAGE PATHS */

.beauty{background-image:url('/images/beauty.jpg')}
.travel{background-image:url('/images/travel.jpg')}
.gastronomy{background-image:url('/images/gastronomy.jpg')}
.wellness{background-image:url('/images/wellness.jpg')}
.education{background-image:url('/images/education.jpg')}
.relocation{background-image:url('/images/travel.jpg')}



/* FEATURED */

.featured-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
gap:30px;
}

.featured-card{
background:white;
border-radius:18px;
overflow:hidden;
box-shadow:0 20px 40px rgba(0,0,0,0.06);
}

.featured-image{
width:100%;
height:220px;
object-fit:cover;
}

.featured-info{
padding:24px;
}



/* RESOURCES */

.resources-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:40px;
}

.resource-card{
background:white;
border-radius:16px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.resource-image{
width:100%;
height:200px;
object-fit:cover;
}

.resource-content{
padding:20px;
}

.resource-btn{
display:inline-block;
margin-top:10px;
padding:10px 20px;
background:black;
color:white;
text-decoration:none;
font-size:12px;
letter-spacing:2px;
}

</style>