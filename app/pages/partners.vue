<template>

<div class="partners-wrapper">

  <!-- HEADER -->

  <div class="partners-header">

    <h1 class="partners-title">
      PARTNER BENEFITS
    </h1>

    <p class="partners-subtitle">
      Exclusive benefits from brands we love.
    </p>

  </div>


  <!-- CATEGORY CAROUSELS -->

  <div
    v-for="(group, category) in groupedPartners"
    :key="category"
    class="category-section"
  >

    <h2 class="category-title">
      {{ formatCategory(category) }}
    </h2>

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

        <div class="benefit-box">

          <div class="benefit-title">
            MEMBER BENEFIT
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
    .eq('active', true)

  partners.value = data || []

})


const groupedPartners = computed(() => {

  const groups = {}

  partners.value.forEach(partner => {

    const category = partner.category || "other"

    if (!groups[category]) {
      groups[category] = []
    }

    groups[category].push(partner)

  })

  return groups

})


const formatCategory = (category) => {
  return category ? category.toUpperCase() : ''
}


const redeemPartner = async (partner) => {

  navigator.clipboard.writeText(partner.discount_code)

  const { data } = await supabase.auth.getUser()

  if (data.user) {

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


.partners-wrapper{
  padding:120px 24px;
  max-width:1200px;
  margin:auto;
}


/* HEADER */

.partners-header{
  margin-bottom:70px;
}

.partners-title{
  font-size:13px;
  letter-spacing:4px;
  text-transform:uppercase;
  margin-bottom:12px;
}

.partners-subtitle{
  font-size:15px;
  opacity:.6;
  max-width:420px;
  line-height:1.5;
}


/* CATEGORY */

.category-section{
  margin-bottom:80px;
}

.category-title{
  font-size:13px;
  letter-spacing:4px;
  text-transform:uppercase;
  opacity:.5;
  margin-bottom:24px;
}


/* CAROUSEL — LUXURY SCROLL */

.partners-carousel{
  display:flex;
  gap:24px;
  overflow-x:auto;
  padding-bottom:12px;

  scroll-snap-type:x mandatory;
  scroll-behavior:smooth;
}

.partners-carousel::-webkit-scrollbar{
  display:none;
}


/* CARD — PREMIUM */

.partner-card{
  min-width:260px;
  max-width:260px;
  height:320px;

  background:white;
  border-radius:20px;
  padding:22px;

  display:flex;
  flex-direction:column;
  justify-content:space-between;

  scroll-snap-align:start;

  box-shadow:0 8px 30px rgba(0,0,0,0.04);
  transition:all .25s ease;
}


/* HOVER (DESKTOP ONLY) */

@media (hover:hover){
  .partner-card:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 50px rgba(0,0,0,0.08);
  }
}


/* LOGO */

.partner-logo{
  width:85px;
  margin-bottom:12px;
}


/* NAME */

.partner-name{
  font-size:17px;
  margin-bottom:12px;
  line-height:1.2;
}


/* BENEFIT */

.benefit-box{
  background:#f7f6f4;
  padding:12px;
  border-radius:12px;
  margin-bottom:14px;
}

.benefit-title{
  font-size:10px;
  letter-spacing:1.5px;
  opacity:.5;
  margin-bottom:4px;
}

.benefit-text{
  font-size:13px;
  line-height:1.4;
}


/* CODE */

.code-section{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:10px;
}

.discount-code{
  font-family:'IBM Plex Mono', monospace;
  font-size:12px;
  opacity:.8;
}

.copy-btn{
  border:1px solid rgba(0,0,0,0.15);
  background:white;
  padding:5px 12px;
  border-radius:999px;
  font-size:11px;
  transition:.2s;
}

.copy-btn:hover{
  background:black;
  color:white;
  border-color:black;
}


/* LINK */

.visit-btn{
  font-size:12px;
  letter-spacing:1px;
  opacity:.7;
  transition:.2s;
}

.visit-btn:hover{
  opacity:1;
}


/* MOBILE */

@media (max-width:768px){

  .partners-wrapper{
    padding:90px 20px;
  }

  .partner-card{
    min-width:220px;
    max-width:220px;
    height:300px;
  }

}