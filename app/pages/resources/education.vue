<template>

<div class="resources-wrapper">

<h1>Education</h1>

<p class="intro">
Trusted education advisors and curated summer programs across Europe.
</p>


<!-- EDUCATION & SCHOOLS -->

<div class="section-title">
Education & Schools
</div>

<div class="advisor-card">

<img
src="/images/education-advisor.jpg"
class="advisor-photo"
/>

<div class="advisor-content">

<div class="advisor-label">
EDUCATION ADVISOR
</div>

<h2>Advisor Name</h2>

<p class="advisor-contact">
advisor@email.com<br>
+34 XXX XXX XXX
</p>

<a
href="mailto:advisor@email.com"
class="advisor-button"
>
Contact Now
</a>

</div>

</div>


<!-- SUMMER CAMPS -->

<div class="section-title">
Summer Camps
</div>

<div class="summer-card">

<div class="summer-content">

<div class="summer-label">
Summer Camps
</div>

<h2>European Summer Society</h2>

<p>
Immersive summer experiences across Europe where children build global friendships,
discover new cultures, and return home with confidence, independence, and lifelong connections.
</p>

<a
href="https://europeansummersociety.com"
target="_blank"
rel="noopener noreferrer"
class="summer-button"
>
Explore Programs
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


/* SECTION TITLES */

.section-title{
letter-spacing:6px;
font-size:12px;
margin-bottom:30px;
opacity:.6;
}


/* ADVISOR CARD */

.advisor-card{
display:flex;
align-items:center;
gap:40px;
margin-bottom:100px;
}

.advisor-photo{
width:160px;
height:160px;
border-radius:50%;
object-fit:cover;
}

.advisor-content{
max-width:520px;
}

.advisor-label{
letter-spacing:4px;
font-size:12px;
opacity:.6;
margin-bottom:10px;
}

.advisor-content h2{
margin-bottom:10px;
}

.advisor-contact{
font-size:16px;
opacity:.7;
line-height:1.6;
margin-bottom:20px;
}

.advisor-button{
background:#A8985F;
color:white;
padding:14px 26px;
border-radius:40px;
text-decoration:none;
font-size:14px;
letter-spacing:1px;
display:inline-block;
}


/* SUMMER CARD */

.summer-card{
height:420px;
border-radius:20px;
padding:70px;
display:flex;
align-items:center;
background-image:url('/images/european-summer.jpg');
background-size:cover;
background-position:center;
color:white;
position:relative;
margin-bottom:40px;
}

.summer-card::after{
content:"";
position:absolute;
inset:0;
background:rgba(0,0,0,0.35);
border-radius:20px;
}

.summer-content{
position:relative;
z-index:2;
max-width:520px;
}

.summer-label{
letter-spacing:4px;
font-size:12px;
opacity:.8;
margin-bottom:14px;
}

.summer-card h2{
font-size:36px;
margin-bottom:16px;
}

.summer-card p{
line-height:1.6;
margin-bottom:26px;
opacity:.9;
}

.summer-button{
background:white;
color:black;
padding:14px 26px;
border-radius:40px;
text-decoration:none;
font-size:13px;
letter-spacing:2px;
display:inline-block;
}

</style>