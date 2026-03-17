<template>

<div class="resources-wrapper">

<h1>Wellness</h1>

<p class="intro">
A curated guide to trusted wellness spaces across Europe — from clinics and restorative spas to exceptional studios and holistic practitioners.
</p>


<!-- CLINICS -->

<div class="section-title">Clinics</div>

<div class="carousel">

<div
v-for="item in clinics"
:key="item.id"
class="wellness-card"
>

<h3>{{ item.name }}</h3>

<p class="location">
{{ item.city }}
</p>

<a
:href="item.website_url"
target="_blank"
class="link"
>
View Website
</a>

</div>

</div>


<!-- SPAS -->

<div class="section-title">Spas</div>

<div class="carousel">

<div
v-for="item in spas"
:key="item.id"
class="wellness-card"
>

<h3>{{ item.name }}</h3>

<p class="location">
{{ item.city }}
</p>

<a
:href="item.website_url"
target="_blank"
class="link"
>
View Website
</a>

</div>

</div>


<!-- STUDIOS -->

<div class="section-title">Studios</div>

<div class="carousel">

<div
v-for="item in studios"
:key="item.id"
class="wellness-card"
>

<h3>{{ item.name }}</h3>

<p class="location">
{{ item.city }}
</p>

<a
:href="item.website_url"
target="_blank"
class="link"
>
View Website
</a>

</div>

</div>


<!-- WOO -->

<div class="section-title">Woo</div>

<div class="carousel">

<div
v-for="item in woo"
:key="item.id"
class="wellness-card"
>

<h3>{{ item.name }}</h3>

<p class="location">
{{ item.city }}
</p>

<a
:href="item.website_url"
target="_blank"
class="link"
>
View Website
</a>

</div>

</div>

</div>

</template>



<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const clinics = ref([])
const spas = ref([])
const studios = ref([])
const woo = ref([])

onMounted(async () => {

/* CLINICS */

const { data: clinicData } = await supabase
.from('resources')
.select('*')
.eq('category','wellness')
.eq('subcategory','Clinics')

clinics.value = clinicData || []


/* SPAS */

const { data: spaData } = await supabase
.from('resources')
.select('*')
.eq('category','wellness')
.eq('subcategory','Spas')

spas.value = spaData || []


/* STUDIOS */

const { data: studioData } = await supabase
.from('resources')
.select('*')
.eq('category','wellness')
.eq('subcategory','Studios')

studios.value = studioData || []


/* WOO */

const { data: wooData } = await supabase
.from('resources')
.select('*')
.eq('category','wellness')
.eq('subcategory','Woo')

woo.value = wooData || []

})

</script>



<style scoped>

.resources-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}

.intro{
font-size:18px;
opacity:.7;
max-width:620px;
margin-bottom:80px;
line-height:1.6;
}

/* SECTION TITLES */

.section-title{
font-family:'Inter', sans-serif;
font-size:18px;
font-weight:400;
color:var(--me-text);
margin-top:60px;
margin-bottom:24px;
opacity:.7;
}

/* CAROUSEL */

.carousel{
display:flex;
gap:24px;
overflow-x:auto;
padding-bottom:20px;
margin-bottom:60px;
}

.carousel::-webkit-scrollbar{
display:none;
}

/* CARDS */

.wellness-card{
min-width:320px;
background:white;
padding:34px;
border-radius:18px;
flex-shrink:0;
box-shadow:0 4px 18px rgba(0,0,0,0.04);
}

.wellness-card h3{
font-size:22px;
font-weight:600;
margin-bottom:10px;
}

.location{
opacity:.55;
margin-bottom:20px;
font-size:15px;
}

.link{
text-decoration:underline;
font-size:14px;
}

</style>