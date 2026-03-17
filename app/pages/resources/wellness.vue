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

<img src="/images/iwhc.jpg" class="card-image"/>

<div class="card-content">

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

</div>


<div class="wellness-card">

<img src="/images/clinica-cloe.jpg" class="card-image"/>

<div class="card-content">

<h3>Clinica Cloe</h3>

<p class="location">Odontología Especializada • Madrid</p>

<a
href="https://www.clinicacloe.com/en/clinica-cloe-english/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>

</div>



<!-- SPAS -->

<div class="section-title">
Spas
</div>

<div class="carousel">

<div class="wellness-card">

<img src="/images/eva-ometz.jpg" class="card-image"/>

<div class="card-content">

<h3>Eva Ometz</h3>

<a
href="https://www.evaometz.com/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>


<div class="wellness-card">

<img src="/images/six-harmonies.jpg" class="card-image"/>

<div class="card-content">

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
min-width:260px;
background:white;
border-radius:16px;
overflow:hidden;
flex-shrink:0;
box-shadow:0 8px 24px rgba(0,0,0,0.05);
}


/* IMAGE */

.card-image{
width:100%;
height:180px;
object-fit:cover;
}


/* CONTENT */

.card-content{
padding:20px;
}

.wellness-card h3{
font-size:18px;
font-weight:600;
margin-bottom:8px;
}

.location{
font-size:14px;
opacity:.6;
margin-bottom:16px;
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
}


/* COMING SOON */

.coming-soon{
opacity:.5;
font-size:14px;
margin-bottom:60px;
}

</style>