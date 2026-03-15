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
      <img src="/images/sunnie.jpg" alt="Sunnie"/>
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

<img v-if="r.image_url" :src="r.image_url"/>

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

<img v-if="r.image_url" :src="r.image_url"/>

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

<img v-if="r.image_url" :src="r.image_url"/>

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

<img v-if="r.image_url" :src="r.image_url"/>

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
.eq('active', true)

resources.value = data || []

})


const skincare = computed(() =>
resources.value.filter(r => r.category === 'skincare')
)

const makeup = computed(() =>
resources.value.filter(r => r.category === 'makeup')
)

const hair = computed(() =>
resources.value.filter(r => r.category === 'hair')
)

const supplements = computed(() =>
resources.value.filter(r => r.category === 'supplements')
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
font-size:16px;
line-height:1.6;
}



/* FEATURED CURATOR */

.featured-curator{
margin-bottom:90px;
}

.curator-inner{
display:flex;
align-items:center;
gap:50px;
background:rgba(255,255,255,0.4);
backdrop-filter:blur(20px);
border-radius:20px;
padding:40px;
border:1px solid rgba(255,255,255,0.6);
}

.curator-image img{
width:140px;
height:140px;
border-radius:50%;
object-fit:cover;
}

.curator-label{
font-size:11px;
letter-spacing:3px;
opacity:.6;
margin-bottom:10px;
}

.curator-text h2{
font-size:28px;
margin-bottom:10px;
}

.curator-text p{
opacity:.75;
max-width:420px;
margin-bottom:20px;
}



/* BUTTON */

.sunnie-btn{
display:inline-block;
padding:12px 28px;
border-radius:30px;
background:#A8985F;
color:white;
text-decoration:none;
font-size:13px;
letter-spacing:.5px;
transition:.25s;
}

.sunnie-btn:hover{
transform:translateY(-2px);
box-shadow:0 10px 24px rgba(0,0,0,0.15);
}



/* SECTIONS */

.section{
margin-bottom:90px;
}

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
gap:30px;
}

.resource-card{
background:white;
padding:22px;
border-radius:16px;
box-shadow:0 10px 30px rgba(0,0,0,0.06);
transition:.25s;
}

.resource-card:hover{
transform:translateY(-4px);
box-shadow:0 20px 40px rgba(0,0,0,0.08);
}

.resource-card img{
width:100%;
height:180px;
object-fit:cover;
border-radius:10px;
margin-bottom:12px;
}

.resource-card h3{
font-size:16px;
margin-bottom:6px;
}

.resource-card p{
font-size:14px;
opacity:.7;
}

.resource-card a{
display:inline-block;
margin-top:10px;
font-size:13px;
letter-spacing:1px;
text-decoration:none;
color:black;
border-bottom:1px solid black;
}

</style>