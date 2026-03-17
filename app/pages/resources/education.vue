<template>

<div class="resources-wrapper">

<!-- PAGE TITLE -->

<h1 class="page-title">
Education
</h1>

<p class="page-intro">
Trusted education advisors, summer programs, and thoughtfully designed spaces for children across Europe.
</p>


<!-- EDUCATION ADVISOR -->

<h2 class="section-title">
Education
</h2>

<div class="hero-card advisor-card">

<div class="card-content">

<div class="card-label">
Education Advisor
</div>

<h2>
Personalized School & University Guidance
</h2>

<p>
Our education advisor helps families navigate European school systems,
international programs, and university pathways with personalized guidance.
</p>

<a
href="mailto:emily@mothereuro.com"
class="card-button"
>
Contact Now
</a>

</div>

</div>



<!-- SUMMER CAMPS -->

<h2 class="section-title">
Summer Camps
</h2>

<div class="hero-card summer">

<div class="card-content">

<div class="card-label">
Summer Camps
</div>

<h2>
European Summer Society
</h2>

<p>
Immersive summer experiences across Europe where children build global friendships,
discover new cultures, and return home with confidence and independence.
</p>

<a
href="https://europeansummersociety.com"
target="_blank"
class="card-button"
>
Explore Programs
</a>

</div>

</div>



<!-- CHILDREN SPACES -->

<h2 class="section-title">
Children Spaces
</h2>

<div class="card-grid">


<!-- HOUSE OF MINI -->

<div class="resource-card">

<h3>House of Mini</h3>

<p>
Creative children's concept space focused on imagination,
learning and exploration.
</p>

<a
href="https://museumofmini.com/"
target="_blank"
class="card-link"
>
Visit Website
</a>

</div>



<!-- CAFE REGGIO -->

<div class="resource-card">

<h3>Cafe Reggio</h3>

<p>
A playful café space designed for children and parents to relax,
create and connect.
</p>

<a
href="https://www.instagram.com/cafe.reggio/"
target="_blank"
class="card-link"
>
Visit Instagram
</a>

</div>



<!-- TETE CONCEPT -->

<div class="resource-card">

<h3>Tete Concept</h3>

<p>
Design-driven children's spaces combining creativity,
education and modern aesthetics.
</p>

<a
href="https://teteconcept.es/?srsltid=AfmBOoqrP8hyp22THMXBkByvFy0AheZZJxzWWOXR-Rhs-wDfFkhfMj4b"
target="_blank"
class="card-link"
>
Visit Website
</a>

</div>

</div>

</div>

</template>



<style scoped>

.advisor-card{
background:#f6f4f1;
color:black;
}

.advisor-card::after{
display:none;
}

.advisor-card .card-button{
background:#A8985F;
color:white;
}

.resources-wrapper{
padding:140px 40px;
max-width:1100px;
margin:auto;
}


/* PAGE HEADER */

.page-title{
font-size:48px;
margin-bottom:12px;
}

.page-intro{
font-size:18px;
opacity:.7;
max-width:640px;
line-height:1.6;
margin-bottom:80px;
}


/* SECTION TITLES */

.section-title{
font-size:18px;
opacity:.7;
letter-spacing:2px;
text-transform:uppercase;
margin-top:70px;
margin-bottom:30px;
}


/* HERO CARDS */

.hero-card{
height:340px;
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
margin-bottom:12px;
opacity:.8;
}

.hero-card h2{
font-size:34px;
margin-bottom:14px;
}

.hero-card p{
line-height:1.6;
margin-bottom:22px;
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


/* CHILDREN SPACE CARDS */

.card-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:28px;
margin-top:20px;
}

.resource-card{
background:white;
padding:28px;
border-radius:16px;
box-shadow:0 4px 20px rgba(0,0,0,0.04);
}

.resource-card h3{
font-size:20px;
margin-bottom:12px;
}

.resource-card p{
font-size:15px;
opacity:.7;
margin-bottom:16px;
}

.card-link{
text-decoration:underline;
font-size:14px;
}


/* BACKGROUNDS */

.advisor{
background-image:url('/images/education-advisor.jpg');
}

.summer{
background-image:url('/images/european-summer.jpg');
}

</style>