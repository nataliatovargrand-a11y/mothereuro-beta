<template>

<div class="page-wrapper">
  <div class="page-container">

    <!-- HEADER -->

    <h1 class="page-title-main">
      WELLNESS
    </h1>

    <p class="page-subtitle">
      Trusted wellness recommendations across Europe — from clinics to spas and holistic experiences.
    </p>


    <!-- CLINICS -->

    <h2 class="section-title">CLINICS</h2>

    <div class="carousel">

      <div
        v-for="item in clinics"
        :key="item.id"
        class="wellness-card large"
      >

        <div class="wellness-name">
          {{ item.name || item.title }}
        </div>

        <div class="wellness-description">
          {{ item.description }}
        </div>

        <div class="wellness-location">
          {{ item.city || item.location }}
        </div>

        <a
          :href="item.website || item.website_url || item.url"
          target="_blank"
          class="wellness-link"
        >
          Visit →
        </a>

      </div>

    </div>


    <!-- SPAS -->

    <h2 class="section-title">SPAS</h2>

    <div class="carousel">

      <div
        v-for="item in spas"
        :key="item.id"
        class="wellness-card"
      >

        <div class="wellness-name">
          {{ item.name || item.title }}
        </div>

        <div class="wellness-location">
          {{ item.city || item.location }}
        </div>

        <a
          :href="item.website || item.website_url || item.url"
          target="_blank"
          class="wellness-link"
        >
          Visit →
        </a>

      </div>

    </div>


    <!-- WOO -->

    <h2 class="section-title">WOO</h2>

    <div class="carousel">

      <div
        v-for="item in woo"
        :key="item.id"
        class="wellness-card"
      >

        <div class="wellness-name">
          {{ item.name || item.title }}
        </div>

        <div class="wellness-location">
          {{ item.city || item.location }}
        </div>

        <a
          :href="item.website || item.website_url || item.url"
          target="_blank"
          class="wellness-link"
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

const clinics = ref([])
const spas = ref([])
const woo = ref([])

onMounted(async () => {

  const { data: resources } = await supabase
    .from('resources')
    .select('*')
    .eq('category', 'wellness')
    .eq('active', true)

  const { data: partners } = await supabase
    .from('partners')
    .select('*')
    .eq('category', 'wellness')
    .eq('active', true)

  const combined = [
    ...(resources || []),
    ...(partners || [])
  ]

  clinics.value = combined.filter(item =>
    item.subcategory?.toLowerCase().includes('clinic')
  )

  spas.value = combined.filter(item =>
    item.subcategory?.toLowerCase().includes('spa')
  )

  woo.value = combined.filter(item =>
    item.subcategory?.toLowerCase().includes('woo')
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

.wellness-card{
  min-width:240px;
  max-width:240px;
  height:140px;

  background:white;
  border-radius:16px;
  padding:18px;

  display:flex;
  flex-direction:column;
  justify-content:space-between;

  box-shadow:0 8px 25px rgba(0,0,0,0.04);
}

/* LARGER FOR CLINICS */

.wellness-card.large{
  height:200px;
}


/* TEXT */

.wellness-name{
  font-size:15px;
}

.wellness-description{
  font-size:13px;
  opacity:.7;
}

.wellness-location{
  font-size:12px;
  opacity:.5;
}

.wellness-link{
  font-size:12px;
  letter-spacing:1px;
}


/* MOBILE */

@media (max-width:768px){

  .page-title-main{
    font-size:30px;
  }

  .wellness-card{
    min-width:200px;
    max-width:200px;
  }

}

</style>