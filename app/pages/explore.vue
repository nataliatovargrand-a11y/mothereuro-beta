<template>

<div class="explore-wrapper">

<!-- HERO -->

<div class="explore-header">

<h1>Explore</h1>

<p class="subtitle">
Curated beauty, travel, gastronomy, wellness and education discoveries across Europe.
</p>

<input
v-model="search"
@input="searchPlatform"
type="text"
placeholder="Search members, resources, partners..."
class="search-input"
/>

</div>



<!-- MAP -->

<div class="map-section">

<div class="map-title">
Discover Europe
</div>

<ExploreMap
:resources="resources"
@citySelected="selectedCity = $event"
/>

</div>



<!-- CATEGORY BUTTONS -->

<div class="category-grid">

<NuxtLink to="/resources/beauty" class="category-btn">
Beauty
</NuxtLink>

<NuxtLink to="/resources/travel" class="category-btn">
Travel
</NuxtLink>

<NuxtLink to="/resources/gastronomy" class="category-btn">
Gastronomy
</NuxtLink>

<NuxtLink to="/resources/wellness" class="category-btn">
Wellness
</NuxtLink>

<NuxtLink to="/resources/education" class="category-btn">
Education
</NuxtLink>

</div>



<!-- SEARCH RESULTS -->

<div v-if="searchResults.length > 0" class="search-results">

<h2>Search Results</h2>

<div
v-for="result in searchResults"
:key="result.id"
class="search-card"
>

<strong>{{ result.title || result.name }}</strong>

<div class="result-type">
{{ result.type }}
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
const searchResults = ref([])
const selectedCity = ref(null)



onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('active', true)

resources.value = data || []

})



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



const searchPlatform = async () => {

if(!search.value){
searchResults.value=[]
return
}

const { data: resourcesData } = await supabase
.from('resources')
.select('*')
.ilike('title', `%${search.value}%`)

const { data: partnersData } = await supabase
.from('partners')
.select('*')
.ilike('name', `%${search.value}%`)

const { data: membersData } = await supabase
.from('members')
.select('*')
.ilike('name', `%${search.value}%`)

searchResults.value = [

...(resourcesData || []).map(r => ({...r,type:'Resource'})),
...(partnersData || []).map(p => ({...p,type:'Partner'})),
...(membersData || []).map(m => ({...m,type:'Member'}))

]

}

</script>



<style scoped>

.explore-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}



.explore-header{
margin-bottom:50px;
}

.subtitle{
margin-bottom:20px;
opacity:.7;
}

.search-input{
width:100%;
padding:16px;
border:1px solid #ddd;
}



.map-section{
margin:80px 0;
}

.map-title{
letter-spacing:6px;
font-size:12px;
margin-bottom:20px;
opacity:.6;
}



.category-grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:20px;
margin-bottom:60px;
}

.category-btn{
border:1px solid black;
padding:26px;
text-align:center;
letter-spacing:4px;
text-decoration:none;
font-size:13px;
}



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



.search-results{
margin-bottom:80px;
}



.search-card{
padding:16px;
border-bottom:1px solid #eee;
}

.result-type{
font-size:11px;
opacity:.6;
}

</style>