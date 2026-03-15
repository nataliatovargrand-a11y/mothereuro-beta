<template>

<div class="beauty-page">

<h1>Beauty</h1>

<p class="intro">
Private recommendations across skincare, makeup, hair, and supplements curated for European living.
</p>


<!-- FEATURED CURATOR -->

<div class="featured-curator">

  <div class="curator-inner">

    <div class="curator-image">
      <img src="/images/sunnie.jpg" alt="Sunnie" />
    </div>

    <div class="curator-text">

      <div class="curator-label">
        FEATURED CURATOR
      </div>

      <h2>
        Sunnie's Recommendations
      </h2>

      <p>
        Discover Sunnie's private beauty recommendations for skincare,
        makeup, hair and supplements.
      </p>

      <NuxtLink
        to="/curators/sunnie"
        class="sunnie-btn"
      >
        Explore Sunnie's Library
      </NuxtLink>

    </div>

  </div>

</div>


<!-- SKINCARE -->

<div class="section">

<h2>Skincare</h2>

<div class="grid">

<div
v-for="r in skincare"
:key="r.id"
class="resource-card"
>

<img :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View Product
</a>

</div>

</div>

</div>



<!-- MAKEUP -->

<div class="section">

<h2>Makeup</h2>

<div class="grid">

<div
v-for="r in makeup"
:key="r.id"
class="resource-card"
>

<img :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View Product
</a>

</div>

</div>

</div>



<!-- HAIR -->

<div class="section">

<h2>Hair</h2>

<div class="grid">

<div
v-for="r in hair"
:key="r.id"
class="resource-card"
>

<img :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View Product
</a>

</div>

</div>

</div>



<!-- SUPPLEMENTS -->

<div class="section">

<h2>Supplements</h2>

<div class="grid">

<div
v-for="r in supplements"
:key="r.id"
class="resource-card"
>

<img :src="r.image_url"/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a :href="r.link_url" target="_blank">
View Product
</a>

</div>

</div>

</div>

</div>

</template>



<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const resources = ref([])

onMounted(async()=>{

const { data } = await supabase
.from('resources')
.select('*')
.in('category', ['skincare','makeup','hair','supplements'])
.eq('active',true)

resources.value = data || []

})


const skincare = computed(() =>
resources.value.filter(r => r.subcategory === 'skincare')
)

const makeup = computed(() =>
resources.value.filter(r => r.subcategory === 'makeup')
)

const hair = computed(() =>
resources.value.filter(r => r.subcategory === 'hair')
)

const supplements = computed(() =>
resources.value.filter(r => r.subcategory === 'supplements')
)

</script>



<style scoped>

.beauty-page{
padding:140px 40px;
max-width:1100px;
margin:auto;
}

.intro{
opacity:.7;
margin-bottom:60px;
}



/* SUNNIE FEATURE */

.sunnie-feature{
display:flex;
justify-content:space-between;
align-items:center;
gap:40px;
margin-bottom:80px;
background:rgba(255,255,255,0.35);
border-radius:20px;
padding:40px;
backdrop-filter:blur(12px);
}

.feature-label{
font-size:11px;
letter-spacing:2px;
text-transform:uppercase;
opacity:.6;
margin-bottom:8px;
}

.feature-btn{
display:inline-block;
margin-top:18px;
padding:12px 26px;
border-radius:30px;
background:#A8985F;
color:white;
text-decoration:none;
}

.feature-image{
width:220px;
height:140px;
border-radius:14px;
background-image:url('/images/sunnie.jpg');
background-size:cover;
background-position:center;
}



/* SECTIONS */

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

.resource-card a{
display:inline-block;
margin-top:10px;
font-size:13px;
letter-spacing:1px;
}

</style>