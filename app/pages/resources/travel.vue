<template>

<div class="page-wrapper">
  <div class="page-container">

    <!-- HEADER -->

    <h1 class="page-title-main">
      TRAVEL
    </h1>

    <p class="page-subtitle">
      Curated hotels and experiences across Europe, trusted by the Mother Euro community.
    </p>


    <!-- HOTELS -->

    <h2 class="section-title">HOTELS</h2>

    <div class="carousel">

      <div
        v-for="item in hotels"
        :key="item.id"
        class="travel-card"
      >

        <div class="travel-name">
          {{ item.name || item.title }}
        </div>

        <div class="travel-location">
          {{ item.city || item.location }}
        </div>

        <a
          :href="item.website || item.website_url || item.url"
          target="_blank"
          class="travel-link"
        >
          Visit →
        </a>

      </div>

    </div>


    <!-- EXPERIENCES -->

    <h2 class="section-title">EXPERIENCES</h2>

    <div class="carousel">

      <div
        v-for="item in experiences"
        :key="item.id"
        class="travel-card"
      >

        <div class="travel-name">
          {{ item.name || item.title }}
        </div>

        <div class="travel-location">
          {{ item.city || item.location }}
        </div>

        <a
          :href="item.website || item.website_url || item.url"
          target="_blank"
          class="travel-link"
        >
          Visit →
        </a>

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

  const { data: resources } = await supabase
    .from('resources')
    .select('*')
    .eq('category', 'travel')
    .eq('active', true)

  const { data: partners } = await supabase
    .from('partners')
    .select('*')
    .eq('category', 'travel')
    .eq('active', true)

  const combined = [
    ...(resources || []),
    ...(partners || [])
  ]

  hotels.value = combined.filter(item =>
    item.subcategory?.toLowerCase().includes('hotel')
  )

  experiences.value = combined.filter(item =>
    item.subcategory?.toLowerCase().includes('experience')
  )

})

</script>


<style scoped>

/* TITLE */

.page-title-main{
  font-size:42px;
  text-transform:uppercase;
  margin-bottom:14px;
}

.page-subtitle{
  font-size:16px;
  opacity:.65;
  margin-bottom:50px;
  max-width:500px;
}


/* SECTION */

.section-title{
  font-size:14px;
  letter-spacing:3px;
  text-transform:uppercase;
  opacity:.6;
  margin-bottom:20px;
  margin-top:40px;
}


/* CAROUSEL */

.carousel{
  display:flex;
  gap:20px;
  overflow-x:auto;
  padding-bottom:10px;
}

.carousel::-webkit-scrollbar{
  display:none;
}


/* CARD */

.travel-card{
  min-width:240px;
  max-width:240px;
  height:140px;

  background:white;
  border-radius:16px;
  padding:20px;

  display:flex;
  flex-direction:column;
  justify-content:space-between;

  box-shadow:0 8px 25px rgba(0,0,0,0.04);
}


/* TEXT */

.travel-name{
  font-size:16px;
}

.travel-location{
  font-size:13px;
  opacity:.6;
}

.travel-link{
  font-size:12px;
  letter-spacing:1px;
}


/* MOBILE */

@media (max-width:768px){

  .page-title-main{
    font-size:30px;
  }

  .travel-card{
    min-width:200px;
    max-width:200px;
  }

}

</style>