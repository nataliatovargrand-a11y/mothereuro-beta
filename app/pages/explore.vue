<template>

<div class="explore-wrapper">

<!-- HERO -->

<div class="explore-hero">

<h1>Explore</h1>

<p class="hero-subtitle">
Curated beauty, travel, gastronomy, wellness and education discoveries across Europe for women building abroad.
</p>

<div class="search-elevated">

<input
v-model="search"
@input="searchPlatform"
type="text"
placeholder="Search by keyword..."
class="search-minimal"
/>

</div>

</div>


<!-- SEARCH RESULTS -->

<div v-if="searchResults.length" class="search-results">

<div
v-for="result in searchResults"
:key="result.id"
class="search-result"
>

<strong>{{ result.title || result.name }}</strong>

<span class="result-type">
{{ result.type }}
</span>

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


<!-- DISCOVER BY CITY -->

<div class="city-section">

<div class="section-title">
Discover by City
</div>

<div class="city-buttons">

<button
v-for="city in cities"
:key="city"
@click="selectedCity = city"
class="city-btn"
>
{{ city }}
</button>

<button
v-if="selectedCity"
@click="selectedCity = null"
class="city-clear"
>
Clear Filter
</button>

</div>

</div>


<!-- CATEGORY CAROUSEL -->

<div class="category-carousel">

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
v-if="member && member.membership_tier === 'aspiring'"
to="/resources/relocation"
class="category-card relocation"
>
<span>Relocation</span>
</NuxtLink>

</div>

</div>

</template>



<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'
import ExploreMap from '~/components/ExploreMap.vue'

const resources = ref([])
const search = ref('')
const selectedCity = ref(null)
const member = ref(null)
const searchResults = ref([])

const cities = [
'Madrid',
'Paris',
'London',
'Lisbon',
'Milan',
'Barcelona',
'Rome'
]

onMounted(async () => {

const { data:{ session } } = await supabase.auth.getSession()

if(session){

const { data: memberData } = await supabase
.from('members')
.select('*')
.eq('id', session.user.id)
.single()

member.value = memberData

}

const { data } = await supabase
.from('resources')
.select('*')
.eq('active', true)

resources.value = data || []

})


const searchPlatform = async () => {

if(!search.value){
searchResults.value = []
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


/* HERO */

.explore-hero{
margin-bottom:70px;
max-width:700px;
}

.hero-subtitle{
font-size:18px;
opacity:.7;
line-height:1.6;
margin-bottom:40px;
}


/* SEARCH */

.search-elevated{
max-width:680px;
}

.search-minimal{
width:100%;
border:none;
border-bottom:1px solid rgba(0,0,0,0.2);
background:transparent;
font-size:18px;
padding:16px 0;
}

.search-minimal::placeholder{
color:rgba(0,0,0,0.4);
}

.search-minimal:focus{
outline:none;
border-bottom:1px solid #A8985F;
}


/* SEARCH RESULTS */

.search-results{
margin-bottom:60px;
max-width:680px;
}

.search-result{
padding:10px 0;
border-bottom:1px solid rgba(0,0,0,0.08);
display:flex;
justify-content:space-between;
}

.result-type{
font-size:12px;
opacity:.5;
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


/* CITY FILTER */

.city-section{
margin-bottom:80px;
}

.city-buttons{
display:flex;
flex-wrap:wrap;
gap:14px;
}

.city-btn{
background:white;
border:1px solid rgba(0,0,0,0.08);
padding:10px 18px;
border-radius:30px;
cursor:pointer;
font-size:12px;
letter-spacing:1px;
}

.city-btn:hover{
background:#f5f5f5;
}

.city-clear{
background:black;
color:white;
border:none;
padding:10px 18px;
border-radius:30px;
cursor:pointer;
font-size:12px;
}


/* CATEGORY CAROUSEL */

.category-carousel{
display:flex;
gap:24px;
overflow-x:auto;
padding-bottom:10px;
scroll-snap-type:x mandatory;
margin:60px 0;
}

.category-carousel::-webkit-scrollbar{
display:none;
}

.category-card{
min-width:220px;
height:260px;
flex-shrink:0;
scroll-snap-align:start;

position:relative;
display:flex;
align-items:center;
justify-content:center;

text-decoration:none;
color:white;

font-size:22px;
letter-spacing:4px;

background-size:cover;
background-position:center;

border-radius:14px;
}

.category-card::after{
content:"";
position:absolute;
inset:0;
background:rgba(0,0,0,0.25);
border-radius:14px;
}

.category-card span{
z-index:2;
}


/* CATEGORY IMAGES */

.beauty{background-image:url('/images/beauty.jpg')}
.travel{background-image:url('/images/travel.jpg')}
.gastronomy{background-image:url('/images/gastronomy.jpg')}
.wellness{background-image:url('/images/wellness.jpg')}
.education{background-image:url('/images/education.jpg')}
.relocation{background-image:url('/images/relocation.jpg')}

</style>