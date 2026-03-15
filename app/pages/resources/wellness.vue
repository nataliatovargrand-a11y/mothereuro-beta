<template>

<div class="category-page">

<h1>Wellness</h1>

<p class="intro">
Trusted doctors, clinics, spas and holistic practitioners across Europe recommended by the Mother Euro network.
</p>


<!-- DOCTORS -->

<div class="section">

<h2>Doctors</h2>

<div class="grid">

<div
v-for="r in doctors"
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


<!-- CLINICS -->

<div class="section">

<h2>Clinics</h2>

<div class="grid">

<div
v-for="r in clinics"
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


<!-- SPAS -->

<div class="section">

<h2>Spas</h2>

<div class="grid">

<div
v-for="r in spas"
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


<!-- WOO -->

<div class="section">

<h2>Woo</h2>

<div class="grid">

<div
v-for="r in woo"
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
.eq('category','wellness')
.eq('active',true)

resources.value = data || []

})

const doctors = computed(() =>
resources.value.filter(r => r.subcategory === 'doctors')
)

const clinics = computed(() =>
resources.value.filter(r => r.subcategory === 'clinics')
)

const spas = computed(() =>
resources.value.filter(r => r.subcategory === 'spas')
)

const woo = computed(() =>
resources.value.filter(r => r.subcategory === 'woo')
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