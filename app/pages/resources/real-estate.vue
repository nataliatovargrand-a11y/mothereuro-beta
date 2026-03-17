<template>

<div class="resources-wrapper">

<h1>Real Estate</h1>

<p class="intro">
Trusted real estate partners helping families find and invest in exceptional homes across Europe.
</p>


<!-- ICONIC LIVING -->

<div class="hero-card iconic">

<div class="card-content">

<div class="card-label">
Real Estate Partner
</div>

<h2>ICONIC Living</h2>

<p>
Rossana Jaramillo & Claudia Razabal
</p>

<a
href="https://www.iconicliving.site/en"
target="_blank"
class="card-button"
>
Explore ICONIC Living
</a>

</div>

</div>



<!-- PERSEPOLIS -->

<div class="hero-card persepolis">

<div class="card-content">

<div class="card-label">
Investment Partner
</div>

<h2>Persepolis Investments</h2>

<p>
Elana Lowenthal
</p>

<a
href="https://persepolis-investments.com/"
target="_blank"
class="card-button"
>
Explore Persepolis
</a>

</div>

</div>



<!-- PRACTICA -->

<div class="hero-card practica">

<div class="card-content">

<div class="card-label">
Architectural & Design Studio
</div>

<h2>Practica</h2>

<p>
Practica is an architectural and design studio known for refined modern spaces and thoughtful residential design across Europe.
</p>

<a
href="https://studiopractica.com/"
target="_blank"
class="card-button"
>
Visit Website
</a>

</div>

</div>

</div>

</template>



<style scoped>

.resources-wrapper{
padding:140px 40px;
max-width:1000px;
margin:auto;
}

.intro{
font-size:18px;
opacity:.7;
max-width:620px;
margin-bottom:80px;
line-height:1.6;
}


/* HERO CARDS */

.hero-card{
height:360px;
border-radius:18px;
margin-bottom:60px;
display:flex;
align-items:center;
padding:60px;
color:white;
background-size:cover;
background-position:center;
position:relative;
}

.hero-card::after{
content:"";
position:absolute;
inset:0;
background:rgba(0,0,0,0.35);
border-radius:18px;
}

.card-content{
position:relative;
z-index:2;
max-width:480px;
}

.card-label{
letter-spacing:4px;
font-size:12px;
margin-bottom:14px;
opacity:.8;
}

.hero-card h2{
font-size:34px;
margin-bottom:16px;
}

.hero-card p{
line-height:1.6;
margin-bottom:24px;
opacity:.9;
}


/* BUTTON */

.card-button{
display:inline-block;
background:white;
color:black;
padding:12px 22px;
border-radius:30px;
font-size:12px;
letter-spacing:2px;
text-decoration:none;
}


/* BACKGROUNDS */

.iconic{
background-image:url('/images/iconic-living.jpg');
}

.persepolis{
background-image:url('/images/persepolis.jpg');
}

.practica{
background-image:url('/images/practica.jpg');
}

</style>