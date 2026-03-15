<template>

<div class="curator-wrapper">

<h1>Sunnie's Recommendations</h1>

<p class="intro">
A curated collection of beauty, skincare, hair and supplement
recommendations personally selected by Sunnie.
</p>

<div class="resource-grid">

<div
v-for="resource in sunnieResources"
:key="resource.id"
class="resource-card"
>

<img
v-if="resource.image_url"
:src="resource.image_url"
class="resource-image"
/>

<h3>{{ resource.title }}</h3>

<p>{{ resource.description }}</p>

<a
:href="resource.link_url"
target="_blank"
class="resource-btn"
>
View Recommendation
</a>

</div>

</div>

</div>

</template>

<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const sunnieResources = ref([])

onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('recommended_by','Sunnie')

sunnieResources.value = data || []

})

</script>

<style scoped>

.curator-wrapper{
padding:140px 40px;
max-width:1000px;
margin:auto;
}

.resource-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:40px;
margin-top:40px;
}

.resource-card{
background:white;
border-radius:16px;
padding:24px;
box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.resource-image{
width:100%;
height:180px;
object-fit:cover;
border-radius:10px;
margin-bottom:10px;
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