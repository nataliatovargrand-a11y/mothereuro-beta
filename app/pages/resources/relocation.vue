<template>

<div class="library-wrapper">

<div class="library-hero">
<h1>Relocation Library</h1>

<p>
A curated guide for women preparing to move to Europe.
Explore resources designed to help you confidently plan your relocation.
</p>
</div>


<div class="library-section">

<h2>Relocation Guides</h2>

<div class="resource-grid">

<div
v-for="resource in resources"
:key="resource.id"
class="resource-card"
>

<h3>{{ resource.title }}</h3>

<p>{{ resource.description }}</p>

<a
:href="resource.link_url"
target="_blank"
class="resource-btn"
>
Open Guide
</a>

</div>

</div>

</div>

</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const resources = ref([])

onMounted(async () => {

const { data } = await supabase
.from('resources')
.select('*')
.eq('category','relocation')
.eq('active',true)

resources.value = data || []

})

</script>


<style scoped>

.library-wrapper{
max-width:1100px;
margin:auto;
padding:140px 40px;
}

.library-hero{
max-width:650px;
margin-bottom:70px;
}

.library-hero h1{
font-size:44px;
margin-bottom:20px;
}

.library-hero p{
font-size:18px;
opacity:.7;
line-height:1.6;
}

.library-section{
margin-bottom:70px;
}

.resource-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:28px;
}

.resource-card{
background:rgba(255,255,255,0.35);
backdrop-filter:blur(18px);
border-radius:16px;
padding:28px;
border:1px solid rgba(255,255,255,0.4);
box-shadow:0 10px 30px rgba(0,0,0,0.05);
}

.resource-card h3{
margin-bottom:10px;
}

.resource-card p{
font-size:14px;
opacity:.7;
margin-bottom:16px;
}

.resource-btn{
display:inline-block;
background:black;
color:white;
padding:10px 18px;
text-decoration:none;
font-size:12px;
letter-spacing:1px;
}

</style>