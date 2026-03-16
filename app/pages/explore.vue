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
placeholder="Search members, partners, or resources..."
class="search-minimal"
/>

</div>

</div>


<!-- SEARCH RESULTS -->

<div v-if="search.length" class="search-results">

<!-- MEMBERS -->

<div v-if="membersResults.length" class="search-section">

<div class="section-title">Members</div>

<NuxtLink
v-for="member in membersResults"
:key="member.id"
:to="'/members/' + member.id"
class="search-result"
>

<div class="result-left">

<img
:src="member.avatar_url || '/avatar-placeholder.png'"
class="avatar"
/>

<div>

<strong>{{ member.name }}</strong>

<div class="result-meta">
{{ member.city }} • {{ member.industry }}
</div>

</div>

</div>

<span class="result-type">Member</span>

</NuxtLink>

</div>


<!-- RESOURCES -->

<div v-if="resourcesResults.length" class="search-section">

<div class="section-title">Resources</div>

<NuxtLink
v-for="resource in resourcesResults"
:key="resource.id"
:to="'/resources/' + resource.slug"
class="search-result"
>

<strong>{{ resource.title }}</strong>

<span class="result-type">Resource</span>

</NuxtLink>

</div>


<!-- PARTNERS -->

<div v-if="partnersResults.length" class="search-section">

<div class="section-title">Partners</div>

<a
v-for="partner in partnersResults"
:key="partner.id"
:href="partner.website"
target="_blank"
class="search-result"
>

<strong>{{ partner.name }}</strong>

<span class="result-type">Partner</span>

</a>

</div>

</div>


<!-- MAP -->

<div class="map-section">

<div class="section-title">
Discover Europe
</div>

<ExploreMap
:resources="resources"
:partners="partners"
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

<NuxtLink to="/resources/real-estate" class="category-card realestate">
<span>Real Estate</span>
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

const search = ref('')

const resources = ref([])
const partners = ref([])

const resourcesResults = ref([])
const partnersResults = ref([])
const membersResults = ref([])

const selectedCity = ref(null)
const member = ref(null)

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

/* LOAD RESOURCES */

const { data: resourcesData } = await supabase
.from('resources')
.select('*')
.eq('active', true)

resources.value = resourcesData || []

/* LOAD PARTNERS */

const { data: partnersData } = await supabase
.from('partners')
.select('*')
.eq('active', true)
.not('latitude', 'is', null)
.not('longitude', 'is', null)

partners.value = partnersData || []

})


const searchPlatform = async () => {

if(!search.value){

resourcesResults.value = []
partnersResults.value = []
membersResults.value = []

return

}

/* RESOURCES */

const { data: resourcesData } = await supabase
.from('resources')
.select('*')
.ilike('title', `%${search.value}%`)
.limit(6)

/* PARTNERS */

const { data: partnersData } = await supabase
.from('partners')
.select('*')
.ilike('name', `%${search.value}%`)
.limit(6)

/* MEMBERS */

const { data: membersData } = await supabase
.from('members')
.select('id,name,city,industry,avatar_url')
.or(`name.ilike.%${search.value}%,city.ilike.%${search.value}%,industry.ilike.%${search.value}%`)
.limit(6)

resourcesResults.value = resourcesData || []
partnersResults.value = partnersData || []
membersResults.value = membersData || []

}

</script>


<style scoped>

.explore-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}

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

.search-minimal:focus{
outline:none;
border-bottom:1px solid #A8985F;
}

/* SEARCH RESULTS */

.search-results{
margin-bottom:60px;
max-width:700px;
}

.search-section{
margin-bottom:40px;
}

.search-result{
display:flex;
justify-content:space-between;
align-items:center;
padding:14px 0;
border-bottom:1px solid rgba(0,0,0,0.08);
text-decoration:none;
color:inherit;
}

.result-left{
display:flex;
gap:14px;
align-items:center;
}

.result-type{
font-size:12px;
opacity:.5;
}

.result-meta{
font-size:13px;
opacity:.6;
}

/* AVATAR */

.avatar{
width:36px;
height:36px;
border-radius:50%;
object-fit:cover;
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
margin:60px 0;
}

.category-carousel::-webkit-scrollbar{
display:none;
}

.category-card{
min-width:220px;
height:260px;
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
position:relative;
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

.beauty{background-image:url('/images/beauty.jpg')}
.travel{background-image:url('/images/travel.jpg')}
.gastronomy{background-image:url('/images/gastronomy.jpg')}
.wellness{background-image:url('/images/wellness.jpg')}
.education{background-image:url('/images/education.jpg')}
.realestate{background-image:url('/images/realestate.jpg')}
.relocation{background-image:url('/images/relocation.jpg')}

</style>