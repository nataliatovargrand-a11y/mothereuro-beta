<template>

<div class="page-wrapper">

  <div class="page-container">

<!-- PAGE TITLE -->

<h1 class="page-title">
Beauty
</h1>

<p class="page-intro">
Private recommendations across skincare, makeup, hair, and supplements curated for European living.
</p>


<!-- HERO CURATOR -->

<div class="hero-card">

<img
src="/images/sunnie.jpg"
class="curator-photo"
/>

<div class="hero-content">

<div class="hero-label">
Featured Curator
</div>

<h2>
Sunnie's Recommendations
</h2>

<p class="hero-description">
Celebrity hairstylist Sunnie Brook shares her curated beauty recommendations across skincare, makeup, hair and supplements for European living.<br>
<strong>@sunniebrook</strong>
</p>

<a
href="https://sunniebrook.substack.com/"
target="_blank"
class="hero-button"
>
Visit Site
</a>

</div>

</div>


<!-- SKINCARE -->

<h2 class="category-title">
Skincare
</h2>

<div class="card-grid">

<div
v-for="item in skincare"
:key="item.id"
class="beauty-card"
>

<h3>{{ item.title }}</h3>

<p class="description">
{{ item.description }}
</p>

<a
:href="item.website_url"
target="_blank"
class="product-link"
>
View Product
</a>

</div>

</div>



<!-- HAIR -->

<h2 class="category-title">
Hair
</h2>

<div class="card-grid">

<div
v-for="item in hair"
:key="item.id"
class="beauty-card"
>

<h3>{{ item.title }}</h3>

<p class="description">
{{ item.description }}
</p>

<a
:href="item.website_url"
target="_blank"
class="product-link"
>
View Product
</a>

</div>

</div>



<!-- MAKEUP -->

<h2 class="category-title">
Makeup
</h2>

<div class="card-grid">

<div
v-for="item in makeup"
:key="item.id"
class="beauty-card"
>

<h3>{{ item.title }}</h3>

<p class="description">
{{ item.description }}
</p>

<a
:href="item.website_url"
target="_blank"
class="product-link"
>
View Product
</a>

</div>

</div>



<!-- SUPPLEMENTS -->

<h2 class="category-title">
Supplements
</h2>

<div class="card-grid">

<div
v-for="item in supplements"
:key="item.id"
class="beauty-card"
>

<h3>{{ item.title }}</h3>

<p class="description">
{{ item.description }}
</p>

<a
:href="item.website_url"
target="_blank"
class="product-link"
>
View Product
</a>

</div>

</div>

</div>

</template>



<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const skincare = ref([])
const hair = ref([])
const makeup = ref([])
const supplements = ref([])

onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('category','beauty')

if(!data) return

// separate results
skincare.value = data.filter(i => i.subcategory === 'skincare' || !i.subcategory)
hair.value = data.filter(i => i.subcategory === 'hair')
makeup.value = data.filter(i => i.subcategory === 'makeup')
supplements.value = data.filter(i => i.subcategory === 'supplements')

})

</script>



<style scoped>

.resources-wrapper{
padding:140px 40px;
max-width:1200px;
margin:auto;
}


/* PAGE HEADER */

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


/* HERO */

.hero-card{
display:flex;
gap:40px;
align-items:center;
background:#f6f4f1;
padding:50px;
border-radius:20px;
margin-bottom:80px;
}

.curator-photo{
width:160px;
height:160px;
border-radius:50%;
object-fit:cover;
}

.hero-label{
letter-spacing:4px;
font-size:12px;
margin-bottom:10px;
opacity:.6;
}

.hero-content h2{
font-size:40px;
margin-bottom:10px;
}

.hero-description{
font-size:18px;
opacity:.7;
max-width:520px;
margin-bottom:20px;
}

.hero-button{
background:#A8985F;
color:white;
padding:14px 28px;
border-radius:30px;
text-decoration:none;
font-size:14px;
letter-spacing:1px;
}


/* CATEGORY TITLES */

.category-title{
font-size:36px;
margin-top:70px;
margin-bottom:30px;
}


/* CARDS */

.card-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:30px;
}

.beauty-card{
background:white;
padding:30px;
border-radius:18px;
box-shadow:0 4px 20px rgba(0,0,0,0.04);
}

.beauty-card h3{
font-size:20px;
margin-bottom:12px;
}

.description{
font-size:15px;
opacity:.7;
margin-bottom:16px;
}

.product-link{
text-decoration:underline;
font-size:14px;
}

</style>