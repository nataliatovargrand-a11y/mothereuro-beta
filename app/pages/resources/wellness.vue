<template>

<div class="resources-wrapper">

<!-- PAGE TITLE -->

<h1 class="page-title">
Wellness
</h1>

<p class="page-intro">
A curated collection of clinics, spas, studios and holistic wellness spaces across Europe trusted by the Mother Euro community.
</p>


<!-- CLINICS -->

<h2 class="section-title">
CLINICS
</h2>

<div class="card-grid">

<div class="wellness-card">
<h3>International Women’s Health Center</h3>
<p>Madrid</p>
<a href="https://iwhcm.com/" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>Clinica Cloe</h3>
<p>Odontologia Especializada Madrid</p>
<a href="https://www.clinicacloe.com/en/clinica-cloe-english/" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>Domicilio</h3>
<p>At-home wellness services</p>
</div>

</div>


<!-- SPAS -->

<h2 class="section-title">
SPAS
</h2>

<div class="card-grid">

<div class="wellness-card">
<h3>Eva Ometz</h3>
<a href="https://www.evaometz.com/" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>Six Harmonies</h3>
<a href="https://www.sixharmonies.es/es" target="_blank">Visit Website</a>
</div>

</div>


<!-- STUDIOS -->

<h2 class="section-title">
STUDIOS
</h2>

<div class="card-grid">

<div class="wellness-card">
<h3>Luci's FitHouse</h3>
<a href="https://lucisfithouse.com" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>Casa Kavi</h3>
<a href="https://casakavi.com" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>Nubya</h3>
<a href="https://nubya.es" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>AMA Studio</h3>
<a href="https://amastudio.es" target="_blank">Visit Website</a>
</div>

<div class="wellness-card">
<h3>Six Harmonies</h3>
<a href="https://sixharmonies.es" target="_blank">Visit Website</a>
</div>

</div>


<!-- WOO -->

<h2 class="section-title">
WOO
</h2>

<div class="card-grid">

<div
v-for="item in woo"
:key="item.id"
class="wellness-card"
>

<h3>{{ item.name }}</h3>

<p v-if="item.description">
{{ item.description }}
</p>

<a
v-if="item.website_url"
:href="item.website_url"
target="_blank"
>
Visit Website
</a>

</div>

</div>

</div>

</template>



<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const woo = ref([])

onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('category','wellness')
.eq('subcategory','woo')
.eq('active',true)

woo.value = data || []

})

</script>



<style scoped>

.resources-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}

/* PAGE */

.page-title{
font-size:48px;
margin-bottom:10px;
}

.page-intro{
font-size:18px;
opacity:.7;
max-width:640px;
line-height:1.6;
margin-bottom:80px;
}

/* SECTION TITLES */

.section-title{
font-size:18px;
letter-spacing:2px;
text-transform:uppercase;
opacity:.7;
margin-top:70px;
margin-bottom:30px;
}

/* CARDS */

.card-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:30px;
}

.wellness-card{
background:white;
padding:28px;
border-radius:18px;
box-shadow:0 4px 20px rgba(0,0,0,0.04);
}

.wellness-card h3{
font-size:20px;
margin-bottom:10px;
}

.wellness-card p{
font-size:14px;
opacity:.7;
margin-bottom:14px;
}

.wellness-card a{
text-decoration:underline;
font-size:14px;
}

</style>