<template>

<div class="partners-wrapper">

  <div class="partners-header">
    <h1>Partner Benefits</h1>
    <p class="partners-subtitle">
      Exclusive benefits from brands we love.
    </p>
  </div>

  <!-- LOGO WALL -->

  <div class="logo-wall">

    <img
      v-for="partner in partners"
      :key="partner.id"
      :src="partner.logo_url"
      class="logo-wall-item"
    />

  </div>


  <!-- CATEGORY SECTIONS -->

  <div
    v-for="(group, category) in groupedPartners"
    :key="category"
    class="category-section"
  >

    <h2 class="category-title">
      {{ formatCategory(category) }}
    </h2>


    <!-- PARTNER CAROUSEL -->

    <div class="partners-carousel">

      <div
        v-for="partner in group"
        :key="partner.id"
        class="partner-card"
      >

        <img
          v-if="partner.logo_url"
          :src="partner.logo_url"
          class="partner-logo"
        />

        <div class="partner-name">
          {{ partner.name }}
        </div>

        <p class="partner-description">
          {{ partner.description }}
        </p>

        <div class="benefit-box">

          <div class="benefit-title">
            Member Benefit
          </div>

          <div class="benefit-text">
            {{ partner.benefit }}
          </div>

        </div>

        <div class="code-section">

          <div class="discount-code">
            {{ partner.discount_code }}
          </div>

          <button
            class="copy-btn"
            @click="redeemPartner(partner)"
          >
            Copy Code
          </button>

        </div>

        <a
          :href="partner.link_url"
          target="_blank"
          class="visit-btn"
        >
          Visit Partner →
        </a>

      </div>

    </div>

  </div>

</div>

</template>


<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const partners = ref([])

onMounted(async () => {

  const { data } = await supabase
    .from('partners')
    .select('*')

  partners.value = data || []

})

const formatCategory = (category) => {
  if (!category) return ''
  return category.charAt(0).toUpperCase() + category.slice(1)
}


const groupedPartners = computed(() => {

  const groups = {}

  partners.value.forEach(partner => {

    const category = partner.category || "Other"

    if (!groups[category]) {
      groups[category] = []
    }

    groups[category].push(partner)

  })

  return groups

})


const redeemPartner = async (partner) => {

  navigator.clipboard.writeText(partner.discount_code)

  const { data } = await supabase.auth.getUser()

  if(data.user){

    await supabase
      .from('partner_redemptions')
      .insert({
        partner_id: partner.id,
        user_email: data.user.email
      })

  }

  alert("Discount code copied")

}

</script>


<style scoped>

/* WRAPPER */

.partners-wrapper{
padding:120px 40px 140px;
max-width:1100px;
margin:0 auto;
}


/* HEADER */

.partners-header{
margin-bottom:60px;
}

.partners-header h1{
font-size:40px;
letter-spacing:2px;
margin-bottom:10px;
}

.partners-subtitle{
opacity:.6;
}


/* LOGO WALL */

.logo-wall{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(120px,1fr));
gap:30px;
margin-bottom:80px;
align-items:center;
}

.logo-wall-item{
max-width:120px;
margin:auto;
opacity:.7;
transition:.25s ease;
}

.logo-wall-item:hover{
opacity:1;
transform:scale(1.05);
}


/* CATEGORY */

.category-section{
margin-bottom:80px;
}

.category-title{
letter-spacing:2px;
text-transform:uppercase;
font-size:18px;
margin-bottom:24px;
}


/* CAROUSEL */

.partners-carousel{
display:flex;
gap:28px;
overflow-x:auto;
scroll-snap-type:x mandatory;
padding-bottom:10px;
}

.partners-carousel::-webkit-scrollbar{
display:none;
}


/* CARD */

.partner-card{

min-width:260px;
flex-shrink:0;
scroll-snap-align:start;

background:white;
border-radius:20px;
padding:28px;

box-shadow:0 10px 30px rgba(0,0,0,0.05);
transition:.25s ease;

}

.partner-card:hover{
transform:translateY(-4px);
box-shadow:0 20px 40px rgba(0,0,0,0.08);
}


.partner-logo{
width:100px;
margin-bottom:16px;
}


.partner-name{
font-size:18px;
font-weight:500;
margin-bottom:8px;
}


.partner-description{
font-size:14px;
margin-bottom:20px;
}


/* BENEFIT */

.benefit-box{
background:#f6f6f6;
padding:14px;
border-radius:12px;
margin-bottom:16px;
}

.benefit-title{
font-size:11px;
letter-spacing:1px;
opacity:.6;
margin-bottom:4px;
}

.benefit-text{
font-size:14px;
}


/* CODE */

.code-section{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:18px;
}

.discount-code{
font-family:monospace;
font-size:14px;
letter-spacing:1px;
}

.copy-btn{
border:1px solid black;
background:white;
padding:6px 12px;
border-radius:6px;
cursor:pointer;
font-size:12px;
}

.copy-btn:hover{
background:black;
color:white;
}


.visit-btn{
text-decoration:none;
font-size:13px;
letter-spacing:1px;
}

</style>