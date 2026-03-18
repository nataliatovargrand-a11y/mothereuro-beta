<template>

<div class="page-wrapper">
  <div class="page-container">

    <!-- HEADER -->

    <h1 class="page-title-main">
      BEAUTY
    </h1>

    <p class="page-subtitle">
      Private recommendations across skincare, makeup, and hair curated for European living.
    </p>


    <!-- FEATURED CURATOR (UNCHANGED) -->

    <div class="hero-card">

      <img
        src="/images/sunnie.jpg"
        class="curator-photo"
      />

      <div class="hero-content">

        <div class="hero-label">
          Featured Curator
        </div>

        <h2>
          Sunnie's Recommendations
        </h2>

        <p class="hero-description">
          Celebrity hairstylist Sunnie Brook shares her curated beauty recommendations across skincare, makeup, and hair for European living.<br>
          <strong>@sunniebrook</strong>
        </p>

        <a
          href="https://sunniebrook.substack.com/"
          target="_blank"
          class="hero-button"
        >
          Visit Site
        </a>

      </div>

    </div>


    <!-- SKINCARE -->

    <h2 class="section-title">SKINCARE</h2>

    <div class="carousel">

      <div
        v-for="item in skincare"
        :key="item.id"
        class="beauty-card"
      >

        <div class="beauty-name">
          {{ item.title }}
        </div>

        <a
          :href="item.website_url"
          target="_blank"
          class="beauty-link"
        >
          View →
        </a>

      </div>

    </div>


    <!-- HAIR -->

    <h2 class="section-title">HAIR</h2>

    <div class="carousel">

      <div
        v-for="item in hair"
        :key="item.id"
        class="beauty-card"
      >

        <div class="beauty-name">
          {{ item.title }}
        </div>

        <a
          :href="item.website_url"
          target="_blank"
          class="beauty-link"
        >
          View →
        </a>

      </div>

    </div>


    <!-- MAKEUP -->

    <h2 class="section-title">MAKEUP</h2>

    <div class="carousel">

      <div
        v-for="item in makeup"
        :key="item.id"
        class="beauty-card"
      >

        <div class="beauty-name">
          {{ item.title }}
        </div>

        <a
          :href="item.website_url"
          target="_blank"
          class="beauty-link"
        >
          View →
        </a>

      </div>

    </div>

  </div>
</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const skincare = ref([])
const hair = ref([])
const makeup = ref([])

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('category', 'beauty')
    .eq('active', true)

  if (!data) return

  skincare.value = data.filter(i =>
    i.subcategory === 'skincare' || !i.subcategory
  )

  hair.value = data.filter(i =>
    i.subcategory === 'hair'
  )

  makeup.value = data.filter(i =>
    i.subcategory === 'makeup'
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


/* HERO (UNCHANGED STYLE) */

.hero-card{
  display:flex;
  gap:40px;
  align-items:center;
  background:#f6f4f1;
  padding:50px;
  border-radius:20px;
  margin-bottom:80px;
}

.curator-photo{
  width:160px;
  height:160px;
  border-radius:50%;
  object-fit:cover;
}

.hero-label{
  letter-spacing:4px;
  font-size:12px;
  margin-bottom:10px;
  opacity:.6;
}

.hero-content h2{
  font-size:40px;
  margin-bottom:10px;
}

.hero-description{
  font-size:18px;
  opacity:.7;
  max-width:520px;
  margin-bottom:20px;
}

.hero-button{
  background:#A8985F;
  color:white;
  padding:14px 28px;
  border-radius:30px;
  text-decoration:none;
  font-size:14px;
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

.beauty-card{
  min-width:220px;
  max-width:220px;
  height:120px;

  background:white;
  border-radius:16px;
  padding:18px;

  display:flex;
  flex-direction:column;
  justify-content:space-between;

  box-shadow:0 8px 25px rgba(0,0,0,0.04);
}


/* TEXT */

.beauty-name{
  font-size:15px;
}

.beauty-link{
  font-size:12px;
  letter-spacing:1px;
}


/* MOBILE */

@media (max-width:768px){

  .page-title-main{
    font-size:30px;
  }

  .hero-card{
    flex-direction:column;
    text-align:center;
  }

}

</style>