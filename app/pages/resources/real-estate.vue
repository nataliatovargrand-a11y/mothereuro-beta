<template>

<div class="resources-wrapper">

<h1>Real Estate</h1>

<p class="intro">
Trusted real estate partners helping women and families find exceptional homes and investments across Europe.
</p>


<!-- ICONIC LIVING -->

<div class="realestate-card iconic">

<div class="card-content">

<div class="card-label">
Real Estate Partner
</div>

<h2>ICONIC Living</h2>

<p class="agents">
Rossana Jaramillo<br>
Claudia Razabal
</p>

<a
href="https://www.iconicliving.site/en"
target="_blank"
rel="noopener noreferrer"
class="card-button"
>
Explore ICONIC Living
</a>

</div>

</div>


<!-- PERSEPOLIS -->

<div class="realestate-card persepolis">

<div class="card-content">

<div class="card-label">
Investment Partner
</div>

<h2>Persepolis Investments</h2>

<p class="agents">
Elana Lowenthal
</p>

<a
href="https://persepolis-investments.com/"
target="_blank"
rel="noopener noreferrer"
class="card-button"
>
Explore Persepolis
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

.realestate-card{
height:420px;
border-radius:20px;
padding:70px;
display:flex;
align-items:center;
color:white;
background-size:cover;
background-position:center;
position:relative;
margin-bottom:60px;
}

.realestate-card::after{
content:"";
position:absolute;
inset:0;
background:rgba(0,0,0,0.35);
border-radius:20px;
}

.card-content{
position:relative;
z-index:2;
max-width:520px;
}

.card-label{
letter-spacing:4px;
font-size:12px;
margin-bottom:14px;
opacity:.8;
}

.realestate-card h2{
font-size:36px;
margin-bottom:16px;
}

.agents{
line-height:1.7;
margin-bottom:26px;
opacity:.9;
}

.card-button{
background:white;
color:black;
padding:14px 26px;
border-radius:40px;
text-decoration:none;
font-size:13px;
letter-spacing:2px;
display:inline-block;
}


/* BACKGROUNDS */

.iconic{
background-image:url('/images/iconic-living.jpg');
}

.persepolis{
background-image:url('/images/persepolis.jpg');
}

</style>