<template>

<div class="category-page">

<h1>Travel</h1>

<p class="intro">
Hotels, retreats and travel experiences across Europe recommended by the Mother Euro network.
</p>

<!-- HOTELS -->

<div class="section">

<h2>Hotels</h2>

<div class="grid">

<div
v-for="r in hotels"
:key="r.id"
class="resource-card"
>

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View
</a>

</div>

</div>

</div>


<!-- RETREATS -->

<div class="section">

<h2>Retreats</h2>

<div class="grid">

<div
v-for="r in retreats"
:key="r.id"
class="resource-card"
>

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View
</a>

</div>

</div>

</div>


<!-- EXPERIENCES -->

<div class="section">

<h2>Experiences</h2>

<div class="grid">

<div
v-for="r in experiences"
:key="r.id"
class="resource-card"
>

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View
</a>

</div>

</div>

</div>

</div>

</template>

<script setup>

import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const resources = ref([])

onMounted(async()=>{

const { data } = await supabase
.from('resources')
.select('*')
.eq('category','travel')
.eq('active',true)

resources.value = data || []

})

const hotels = computed(() =>
resources.value.filter(r => r.subcategory === 'hotels')
)

const retreats = computed(() =>
resources.value.filter(r => r.subcategory === 'retreats')
)

const experiences = computed(() =>
resources.value.filter(r => r.subcategory === 'experiences')
)

</script>

<style scoped>

.category-page{
padding:140px 40px;
max-width:1100px;
margin:auto;
}

.intro{
opacity:.7;
margin-bottom:60px;
}

.section{
margin-bottom:80px;
}

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
gap:30px;
}

.resource-card{
background:white;
padding:20px;
border-radius:14px;
box-shadow:0 10px 25px rgba(0,0,0,0.06);
}

.resource-card img{
width:100%;
height:180px;
object-fit:cover;
border-radius:10px;
margin-bottom:12px;
}

</style>