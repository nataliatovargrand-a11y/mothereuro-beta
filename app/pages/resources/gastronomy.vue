<template>

<div class="category-page">

<h1>Gastronomy</h1>

<p class="intro">
Restaurants, cafes and bars across Europe recommended by the Mother Euro community.
</p>

<!-- RESTAURANTS -->

<div class="section">

<h2>Restaurants</h2>

<div class="grid">

<div v-for="r in restaurants" :key="r.id" class="resource-card">

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">View</a>

</div>

</div>

</div>


<!-- CAFES -->

<div class="section">

<h2>Cafes</h2>

<div class="grid">

<div v-for="r in cafes" :key="r.id" class="resource-card">

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">View</a>

</div>

</div>

</div>


<!-- BARS -->

<div class="section">

<h2>Bars</h2>

<div class="grid">

<div v-for="r in bars" :key="r.id" class="resource-card">

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">View</a>

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
.eq('category','gastronomy')
.eq('active',true)

resources.value = data || []

})

const restaurants = computed(()=>resources.value.filter(r=>r.subcategory==='restaurants'))
const cafes = computed(()=>resources.value.filter(r=>r.subcategory==='cafes'))
const bars = computed(()=>resources.value.filter(r=>r.subcategory==='bars'))

</script>