<template>

<div class="resources-wrapper">

<h1>Wellness</h1>

<p class="intro">
A curated selection of trusted clinics, restorative spas and wellness spaces across Europe.
</p>


<!-- CLINICS -->

<div class="section-title">
Clinics
</div>

<div class="carousel">

<div class="wellness-card">

<h3>International Women's Health Center</h3>

<p class="location">Madrid</p>

<a
href="https://iwhcm.com/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>


<div class="wellness-card">

<h3>Clinica Cloe</h3>

<p class="location">
Odontología Especializada • Madrid
</p>

<a
href="https://www.clinicacloe.com/en/clinica-cloe-english/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>



<!-- SPAS -->

<div class="section-title">
Spas
</div>

<div class="carousel">

<div class="wellness-card">

<h3>Eva Ometz</h3>

<a
href="https://www.evaometz.com/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>


<div class="wellness-card">

<h3>Six Harmonies</h3>

<a
href="https://www.sixharmonies.es/es"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>



<!-- STUDIOS -->

<div class="section-title">
Studios
</div>

<p class="coming-soon">
Coming soon
</p>



<!-- WOO -->

<div class="section-title">
Woo
</div>

<p class="coming-soon">
Coming soon
</p>


</div>

</template>



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
letter-spacing:2px;
font-size:16px;
margin-bottom:24px;
margin-top:60px;
opacity:.8;
}


/* CAROUSEL */

.carousel{
display:flex;
gap:24px;
overflow-x:auto;
padding-bottom:10px;
margin-bottom:60px;
}

.carousel::-webkit-scrollbar{
display:none;
}


/* CARD */

.wellness-card{
min-width:240px;
height:240px;
background:white;
border-radius:16px;
padding:30px;
flex-shrink:0;
display:flex;
flex-direction:column;
justify-content:space-between;
box-shadow:0 6px 18px rgba(0,0,0,0.04);
}

.wellness-card h3{
font-size:18px;
font-weight:600;
line-height:1.3;
}

.location{
font-size:14px;
opacity:.6;
}


/* BUTTON */

.card-button{
display:inline-block;
background:black;
color:white;
padding:10px 18px;
border-radius:30px;
font-size:11px;
letter-spacing:1px;
text-decoration:none;
width:fit-content;
}


/* COMING SOON */

.coming-soon{
opacity:.5;
font-size:14px;
margin-bottom:60px;
}

</style>