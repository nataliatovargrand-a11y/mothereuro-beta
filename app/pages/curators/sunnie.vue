<template>

<div class="curator-page">

<!-- HERO -->

<div class="curator-hero">

<div class="curator-card">

<img
src="/images/sunnie.jpg"
alt="Sunnie Brook"
class="curator-photo"
/>

<div class="curator-info">

<h1>Sunnie Brook</h1>

<p class="curator-bio">
Celebrity hairstylist and beauty expert Sunnie Brook shares the skincare,
hair, makeup and supplement products she trusts after more than two decades
working with clients, celebrities and global beauty brands.
</p>

<div class="curator-socials">

<a
href="https://www.instagram.com/sunniebrook/"
target="_blank"
class="instagram-handle"
>
@sunniebrook
</a>

</div>

<a
href="https://sunniebrook.com/"
target="_blank"
class="website-btn"
>
Visit Sunnie's Website
</a>

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

<img
v-if="r.image_url"
:src="r.image_url"
/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a
:href="r.link_url"
target="_blank"
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
>
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

<img
v-if="r.image_url"
:src="r.image_url"
/>

<h3>{{ r.title }}</h3>

<p>{{ r.description }}</p>

<a
:href="r.link_url"
target="_blank"
>
View Product
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

onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('recommended_by','Sunnie')
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

.curator-page{
padding:140px 40px;
max-width:1100px;
margin:auto;
}



/* HERO */

.curator-hero{
margin-bottom:90px;
}

.curator-card{
display:flex;
align-items:center;
gap:40px;

background:rgba(255,255,255,0.4);
backdrop-filter:blur(20px);

border-radius:22px;
padding:40px;

border:1px solid rgba(255,255,255,0.6);
}

.curator-photo{
width:140px;
height:140px;
border-radius:50%;
object-fit:cover;
}

.curator-info h1{
font-size:32px;
margin-bottom:8px;
}

.curator-bio{
opacity:.75;
max-width:520px;
margin-bottom:16px;
}



/* SOCIALS */

.curator-socials{
display:flex;
gap:18px;
margin-bottom:16px;
}

.curator-socials a{
font-size:14px;
text-decoration:none;
border-bottom:1px solid black;
}



/* WEBSITE BUTTON */

.website-btn{
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

.website-btn:hover{
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



/* RESOURCE CARD */

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
.instagram-handle{
font-size:14px;
text-decoration:none;
color:black;
border-bottom:1px solid black;
transition:.2s;
}

.instagram-handle:hover{
opacity:.7;
}

</style>