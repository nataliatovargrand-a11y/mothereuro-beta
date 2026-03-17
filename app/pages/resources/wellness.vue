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

<div class="hero-card">

<div class="card-content">

<h2>International Women's Health Center</h2>

<p class="location">
Madrid
</p>

<a
href="https://iwhcm.com/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>


<div class="hero-card">

<div class="card-content">

<h2>Clinica Cloe</h2>

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

<div class="hero-card">

<div class="card-content">

<h2>Eva Ometz</h2>

<a
href="https://www.evaometz.com/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>


<div class="hero-card">

<div class="card-content">

<h2>Six Harmonies</h2>

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

<p class="empty">
Coming soon.
</p>



<!-- WOO -->

<div class="section-title">
Woo
</div>

<p class="empty">
Coming soon.
</p>


</div>

</template>



<style scoped>

.resources-wrapper{
padding:140px 40px;
max-width:900px;
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
font-size:18px;
margin-top:60px;
margin-bottom:20px;
opacity:.7;
}


/* HERO CARD */

.hero-card{
background:white;
border-radius:16px;
padding:40px;
margin-bottom:24px;
box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

.card-content{
display:flex;
flex-direction:column;
gap:12px;
}

.hero-card h2{
font-size:22px;
font-weight:600;
}

.location{
opacity:.6;
font-size:14px;
}


/* BUTTON */

.card-button{
display:inline-block;
margin-top:10px;
background:black;
color:white;
padding:12px 22px;
border-radius:30px;
font-size:12px;
letter-spacing:1px;
text-decoration:none;
width:fit-content;
}


/* EMPTY */

.empty{
opacity:.5;
font-size:14px;
}

</style>