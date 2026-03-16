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
:key="restaurant.name"
class="gastronomy-card"
>

<h3>{{ restaurant.name }}</h3>

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
:key="cafe.name"
class="gastronomy-card"
>

<h3>{{ cafe.name }}</h3>

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

const restaurants = [

{
name: "Saddle",
city: "Madrid",
website: "https://www.saddle-madrid.com"
},

{
name: "Bouchon Racine",
city: "London",
website: "https://www.bouchonracine.co.uk"
},

{
name: "Septime",
city: "Paris",
website: "https://www.septime-charonne.fr"
},

{
name: "Da Vittorio",
city: "Bergamo",
website: "https://www.davittorio.com"
}

]


const cafes = [

{
name: "Toma Café",
city: "Madrid",
website: "https://www.instagram.com/tomacafe"
},

{
name: "Holybelly",
city: "Paris",
website: "https://holybellycafe.com"
},

{
name: "Feya",
city: "London",
website: "https://feya.co.uk"
},

{
name: "Nomade",
city: "Lisbon",
website: "https://nomade.pt"
}

]

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


/* SECTION */

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
background:#F4F2EE;
padding:34px;
border-radius:18px;
flex-shrink:0;
}

.gastronomy-card h3{
font-size:22px;
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