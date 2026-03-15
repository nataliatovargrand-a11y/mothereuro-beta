<template>

<div class="curator-page">

<!-- HERO -->

<div class="curator-hero">

<img
src="/images/sunnie.jpg"
class="curator-photo"
/>

<h1>Sunnie Brook</h1>

<div class="handle">
@sunniebrook
</div>

<p class="bio">
Celebrity hairstylist Sunnie Brook shares her curated beauty
recommendations across skincare, makeup and hair.
</p>

<div class="hero-buttons">

<a
href="https://sunniebrook.com/"
target="_blank"
class="website-btn"
>
Visit Website
</a>

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

<img
v-if="r.image_url"
:src="r.image_url"
/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a
:href="r.link_url"
target="_blank"
class="product-btn"
>
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

<img
v-if="r.image_url"
:src="r.image_url"
/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a
:href="r.link_url"
target="_blank"
class="product-btn"
>
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

<img
v-if="r.image_url"
:src="r.image_url"
/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a
:href="r.link_url"
target="_blank"
class="product-btn"
>
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

onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('recommended_by','sunnie')
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

</script>



<style scoped>

.curator-page{
padding:140px 40px;
max-width:1100px;
margin:auto;
}

/* HERO */

.curator-hero{
text-align:center;
margin-bottom:80px;
}

.curator-photo{
width:160px;
height:160px;
border-radius:50%;
object-fit:cover;
margin-bottom:20px;
}

.handle{
font-size:14px;
opacity:.6;
margin-bottom:16px;
}

.bio{
max-width:520px;
margin:auto;
opacity:.7;
line-height:1.6;
margin-bottom:20px;
}

.website-btn{
display:inline-block;
padding:12px 28px;
border-radius:30px;
background:#A8985F;
color:white;
text-decoration:none;
font-size:13px;
letter-spacing:.5px;
}

.website-btn:hover{
transform:translateY(-2px);
box-shadow:0 10px 24px rgba(0,0,0,0.15);
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

.product-btn{
display:inline-block;
margin-top:12px;
padding:8px 16px;
background:black;
color:white;
font-size:12px;
letter-spacing:1px;
text-decoration:none;
border-radius:6px;
}

</style>