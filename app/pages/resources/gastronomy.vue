<template>

<div class="resources-wrapper">

<h1>Gastronomy</h1>

<p class="intro">
A curated guide to exceptional restaurants and cafés across Europe loved by the Mother Euro community.
</p>


<!-- RESTAURANTS -->

<div class="section-title">
Restaurants
</div>

<div class="carousel">

<div
v-for="restaurant in restaurants"
:key="restaurant.id"
class="gastronomy-card"
>

<h3>{{ restaurant.title }}</h3>

<p class="location">
{{ restaurant.city }}
</p>

<a
:href="restaurant.website"
target="_blank"
class="link"
>
View Website
</a>

</div>

</div>



<!-- CAFES -->

<div class="section-title">
Cafés
</div>

<div class="carousel">

<div
v-for="cafe in cafes"
:key="cafe.id"
class="gastronomy-card"
>

<h3>{{ cafe.title }}</h3>

<p class="location">
{{ cafe.city }}
</p>

<a
:href="cafe.website"
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

const restaurants = ref([])
const cafes = ref([])

onMounted(async () => {

/* RESTAURANTS */

const { data: restaurantData } = await supabase
.from('resources')
.select('*')
.eq('category','gastronomy')
.eq('subcategory','restaurants')
.eq('active', true)

restaurants.value = restaurantData || []


/* CAFES */

const { data: cafeData } = await supabase
.from('resources')
.select('*')
.eq('category','gastronomy')
.eq('subcategory','cafes')
.eq('active', true)

cafes.value = cafeData || []

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

.section-title{
letter-spacing:6px;
font-size:12px;
margin-bottom:24px;
opacity:.6;
}


/* CAROUSEL */

.carousel{
display:flex;
gap:24px;
overflow-x:auto;
padding-bottom:20px;
margin-bottom:80px;
}

.carousel::-webkit-scrollbar{
display:none;
}


/* CARDS */

.gastronomy-card{
min-width:320px;
background:white;
padding:34px;
border-radius:18px;
flex-shrink:0;
box-shadow:0 4px 18px rgba(0,0,0,0.04);
}

.gastronomy-card h3{
font-size:22px;
font-weight:600;
margin-bottom:10px;
}

.location{
opacity:.6;
margin-bottom:20px;
}

.link{
text-decoration:underline;
font-size:14px;
}

</style>