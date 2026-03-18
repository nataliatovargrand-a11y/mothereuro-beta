<template>

<div class="page-wrapper">
  <div class="page-container">

    <!-- HEADER -->

    <h1 class="page-title-main">
      EDUCATION
    </h1>

    <p class="page-subtitle">
      Trusted education pathways, advisors, and programs for families living in Europe.
    </p>


    <!-- EDUCATION ADVISOR -->

    <h2 class="section-title">EDUCATION</h2>

    <div class="hero-card">

      <div class="hero-content">

        <h2 class="hero-title">
          Education Advisor
        </h2>

        <p class="hero-description">
          Personalized School Guidance<br><br>
          Our education advisor helps families navigate European school systems, international programs, and university pathways with personalized guidance.
        </p>

        <a
          href="mailto:emily@mothereuro.com"
          class="hero-button"
        >
          Learn More
        </a>

      </div>

    </div>


    <!-- SUMMER CAMPS -->

    <h2 class="section-title">SUMMER CAMPS</h2>

    <div class="hero-card split">

      <img
        src="/images/summer.jpg"
        class="hero-image"
      />

      <div class="hero-content">

        <h2 class="hero-title">
          European Summer Society
        </h2>

        <p class="hero-description">
          Curated summer experiences across Europe designed for global families.
        </p>

        <a
          href="mailto:emily@mothereuro.com"
          class="hero-button"
        >
          Learn More
        </a>

      </div>

    </div>


    <!-- CHILDREN SPACES -->

    <h2 class="section-title">CHILDREN SPACES</h2>

    <div class="carousel">

      <div
        v-for="item in childrenSpaces"
        :key="item.id"
        class="education-card"
      >

        <div class="education-name">
          {{ item.name || item.title }}
        </div>

        <div class="education-description">
          {{ item.description }}
        </div>

        <div class="education-location">
          {{ item.city || item.location }}
        </div>

        <a
          :href="item.website || item.website_url || item.url"
          target="_blank"
          class="education-link"
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

const childrenSpaces = ref([])

onMounted(async () => {

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('category', 'education')
    .eq('active', true)

  childrenSpaces.value = data?.filter(item => {

    const sub = item.subcategory?.toLowerCase() || ''

    return sub.includes('children spaces') || sub.includes('children')

  }) || []

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
  margin-top:50px;
}


/* HERO */

.hero-card{
  width:100%;
  max-width:720px;
  background:#f6f4f1;
  padding:40px;
  border-radius:20px;
  margin-bottom:60px;
}

/* SPLIT HERO (IMAGE + TEXT) */

.hero-card.split{
  display:flex;
  gap:30px;
  align-items:center;
}

.hero-image{
  width:160px;
  height:160px;
  object-fit:cover;
  border-radius:16px;
}

.hero-content{
  max-width:520px;
}

.hero-title{
  font-size:28px;
  margin-bottom:12px;
}

.hero-description{
  font-size:15px;
  opacity:.7;
  margin-bottom:20px;
  line-height:1.6;
}

.hero-button{
  background:#A8985F;
  color:white;
  padding:12px 24px;
  border-radius:30px;
  text-decoration:none;
  font-size:12px;
  letter-spacing:1px;
}


/* CAROUSEL */

.carousel{
  display:flex;
  gap:20px;
  overflow-x:auto;
  padding-bottom:10px;
  scroll-snap-type:x mandatory;
}

.carousel::-webkit-scrollbar{
  display:none;
}


/* CARD */

.education-card{
  flex:0 0 auto;
  min-width:240px;
  max-width:240px;
  height:180px;

  background:white;
  border-radius:16px;
  padding:18px;

  display:flex;
  flex-direction:column;
  justify-content:space-between;

  box-shadow:0 8px 25px rgba(0,0,0,0.04);

  scroll-snap-align:start;
}


/* TEXT */

.education-name{
  font-size:15px;
}

.education-description{
  font-size:13px;
  opacity:.7;
}

.education-location{
  font-size:12px;
  opacity:.5;
}

.education-link{
  font-size:12px;
}


/* MOBILE */

@media (max-width:768px){

  .page-title-main{
    font-size:30px;
  }

  .hero-card{
    padding:24px;
    max-width:100%;
  }

  .hero-card.split{
    flex-direction:column;
    text-align:center;
  }

  .hero-image{
    width:120px;
    height:120px;
  }

  .hero-title{
    font-size:22px;
  }

  .education-card{
    min-width:200px;
    max-width:200px;
  }

}

</style>