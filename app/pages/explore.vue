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

<div class="section-title">
Members
</div>

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

<div class="section-title">
Resources
</div>

<NuxtLink
v-for="resource in resourcesResults"
:key="resource.id"
:to="'/resources/' + resource.slug"
class="search-result"
>

<strong>{{ resource.title }}</strong>

<span class="result-type">
Resource
</span>

</NuxtLink>

</div>


<!-- PARTNERS -->

<div v-if="partnersResults.length" class="search-section">

<div class="section-title">
Partners
</div>

<a
v-for="partner in partnersResults"
:key="partner.id"
:href="partner.website"
target="_blank"
class="search-result"
>

<strong>{{ partner.name }}</strong>

<span class="result-type">
Partner
</span>

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

/* MAP DATA */

const resources = ref([])
const partners = ref([])

/* SEARCH RESULTS */

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

/* LOAD PARTNERS FOR MAP */

const { data: partnersData } = await supabase
.from('partners')
.select('*')

partners.value = partnersData || []

})


const searchPlatform = async () => {

if(!search.value){

resourcesResults.value = []
partnersResults.value = []
membersResults.value = []

return

}

/* SEARCH RESOURCES */

const { data: resourcesData } = await supabase
.from('resources')
.select('*')
.ilike('title', `%${search.value}%`)
.limit(6)

/* SEARCH PARTNERS */

const { data: partnersData } = await supabase
.from('partners')
.select('*')
.ilike('name', `%${search.value}%`)
.limit(6)

/* SEARCH MEMBERS */

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

/* keep your existing styles unchanged */

.explore-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}

/* rest of your styles remain exactly the same */

</style>