<template>

<div class="page-wrapper">
  <div class="page-container">

    <h1 class="page-title">Travel</h1>

    <p class="page-subtitle">
      Curated hotels and travel experiences across Europe trusted by the Mother Euro community.
    </p>


    <!-- HOTELS -->

    <h2 class="section-title">Hotels</h2>

    <div class="grid">

      <div
        v-for="item in hotels"
        :key="item.id"
        class="card"
      >

        <div class="card-content">

          <div class="card-title">
            {{ item.name || item.title }}
          </div>

          <div class="card-sub" v-if="item.description">
            {{ item.description }}
          </div>

          <a
            v-if="item.website"
            :href="item.website"
            target="_blank"
          >
            Visit Website
          </a>

        </div>

      </div>

    </div>


    <!-- EXPERIENCES -->

    <h2 class="section-title">Experiences</h2>

    <div class="grid">

      <div
        v-for="item in experiences"
        :key="item.id"
        class="card"
      >

        <div class="card-content">

          <div class="card-title">
            {{ item.name || item.title }}
          </div>

          <div class="card-sub" v-if="item.description">
            {{ item.description }}
          </div>

          <a
            v-if="item.website"
            :href="item.website"
            target="_blank"
          >
            Visit Website
          </a>

        </div>

      </div>

    </div>

  </div>
</div>

</template>



<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const hotels = ref([])
const experiences = ref([])

onMounted(async () => {

/* LOAD RESOURCES */

const { data: resources } = await supabase
.from('resources')
.select('*')
.eq('category','travel')
.eq('active', true)


/* LOAD PARTNERS */

const { data: partners } = await supabase
.from('partners')
.select('*')
.eq('active', true)


/* MERGE DATA */

const combined = [
...(resources || []).map(item => ({
...item,
website: item.website || item.website_url || item.url
})),

...(partners || []).map(item => ({
...item,
website: item.website || item.website_url || item.url
}))
]


/* FILTER */

hotels.value = combined.filter(item =>
item.subcategory &&
item.subcategory.toLowerCase().includes('hotel')
)

experiences.value = combined.filter(item =>
item.subcategory &&
item.subcategory.toLowerCase().includes('experience')
)

})

</script>



<style scoped>


.page-title{
font-size:48px;
margin-bottom:10px;
}

.page-intro{
font-size:18px;
opacity:.7;
max-width:640px;
line-height:1.6;
margin-bottom:80px;
}

.section-title{
font-size:18px;
letter-spacing:2px;
text-transform:uppercase;
opacity:.7;
margin-top:70px;
margin-bottom:30px;
}

.card-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:30px;
}

.travel-card{
background:white;
padding:28px;
border-radius:18px;
box-shadow:0 4px 20px rgba(0,0,0,0.04);
}

.travel-card h3{
font-size:20px;
margin-bottom:10px;
}

.travel-card p{
font-size:14px;
opacity:.7;
margin-bottom:14px;
}

.travel-card a{
text-decoration:underline;
font-size:14px;
}

</style>