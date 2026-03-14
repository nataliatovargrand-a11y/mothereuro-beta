<template>

<div class="library-wrapper">

<!-- HERO -->

<div class="library-hero">

<h1>Relocation Library</h1>

<p>
A curated guide for aspiring members preparing to move to Europe.
These guides help you navigate relocation, culture, healthcare,
schools and building a life abroad.
</p>

</div>


<!-- RESOURCE GRID -->

<div class="resource-grid">

<div
v-for="resource in resources"
:key="resource.id"
class="resource-card"
>

<h3>{{ resource.title }}</h3>

<p>{{ resource.description }}</p>

<div class="resource-actions">

<a
:href="resource.link_url"
target="_blank"
class="resource-btn"
>
Open Guide
</a>

<button
@click="saveResource(resource.id)"
class="save-btn"
>
Save
</button>

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


const saveResource = async (resourceId) => {

const { data:{ session } } = await supabase.auth.getSession()

if(!session) return

await supabase
.from('saved_resources')
.insert({
user_id: session.user.id,
resource_id: resourceId
})

}

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



/* GRID */

.resource-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:28px;
}



/* CARD */

.resource-card{

background:rgba(255,255,255,0.35);

backdrop-filter:blur(18px);

border-radius:18px;

padding:28px;

border:1px solid rgba(255,255,255,0.4);

box-shadow:0 10px 30px rgba(0,0,0,0.05);

display:flex;

flex-direction:column;

justify-content:space-between;

}


.resource-card h3{
margin-bottom:10px;
font-size:20px;
}

.resource-card p{
font-size:14px;
opacity:.7;
margin-bottom:20px;
}



/* BUTTONS */

.resource-actions{
display:flex;
gap:10px;
}


.resource-btn{
display:inline-block;
background:black;
color:white;
padding:10px 18px;
text-decoration:none;
font-size:12px;
letter-spacing:1px;
border-radius:8px;
}


.save-btn{

padding:10px 18px;

border-radius:8px;

border:1px solid rgba(0,0,0,0.1);

background:rgba(255,255,255,0.6);

cursor:pointer;

font-size:12px;

}

.save-btn:hover{
background:white;
}

</style>