<template>

<div class="category-page">

<h1>Education</h1>

<p class="intro">
Trusted schools and summer programs across Europe recommended by the Mother Euro community.
</p>


<!-- SCHOOLS -->

<div class="section">

<h2>Schools</h2>

<div class="grid">

<div
v-for="r in schools"
:key="r.id"
class="resource-card"
>

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
Visit
</a>

</div>

</div>

</div>


<!-- SUMMER CAMPS -->

<div class="section">

<h2>Summer Camps</h2>

<div class="grid">

<div
v-for="r in camps"
:key="r.id"
class="resource-card"
>

<img v-if="r.image_url" :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
Visit
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
.eq('category','education')
.eq('active',true)

resources.value = data || []

})

const schools = computed(() =>
resources.value.filter(r => r.subcategory === 'schools')
)

const camps = computed(() =>
resources.value.filter(r => r.subcategory === 'summer-camps')
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