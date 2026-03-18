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


/* ✅ FIXED GROUPING (NORMALIZED) */

const groupedPartners = computed(() => {

  const groups = {}

  partners.value.forEach(partner => {

    const category = (partner.category || "other")
      .toLowerCase()
      .trim()

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


<style scoped>

.partners-wrapper{
  padding:120px 24px;
  max-width:1200px;
  margin:auto;
}


/* HEADER */

.partners-header{
  margin-bottom:60px;
}

.partners-title{
  font-size:42px;
  letter-spacing:0.02em;
  text-transform:uppercase;
  margin-bottom:14px;
  line-height:1.1;
}

.partners-subtitle{
  font-size:16px;
  opacity:.65;
  max-width:420px;
  line-height:1.5;
}


/* CATEGORY */

.category-section{
  margin-bottom:60px;
}

.category-title{
  font-size:14px;
  letter-spacing:3px;
  text-transform:uppercase;
  opacity:.6;
  margin-bottom:20px;
}


/* CAROUSEL */

.partners-carousel{
  display:flex;
  gap:20px;
  overflow-x:auto;
  padding-bottom:10px;
}

.partners-carousel::-webkit-scrollbar{
  display:none;
}


/* CARD */

.partner-card{
  min-width:240px;
  max-width:240px;
  height:300px;

  background:white;
  border-radius:18px;
  padding:20px;

  display:flex;
  flex-direction:column;
  justify-content:space-between;

  box-shadow:0 10px 30px rgba(0,0,0,0.05);
}


/* LOGO */

.partner-logo{
  width:80px;
  margin-bottom:10px;
}


/* NAME */

.partner-name{
  font-size:16px;
  margin-bottom:10px;
}


/* BENEFIT */

.benefit-box{
  background:#f6f6f6;
  padding:10px;
  border-radius:10px;
  margin-bottom:10px;
}

.benefit-title{
  font-size:10px;
  letter-spacing:1px;
  opacity:.6;
  margin-bottom:4px;
}

.benefit-text{
  font-size:13px;
}


/* CODE */

.code-section{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.discount-code{
  font-family:monospace;
  font-size:12px;
}

.copy-btn{
  border:1px solid black;
  background:white;
  padding:5px 10px;
  border-radius:6px;
  font-size:11px;
}


/* LINK */

.visit-btn{
  font-size:12px;
  margin-top:8px;
}


/* MOBILE */

@media (max-width:768px){

  .partners-title{
    font-size:30px;
  }

}

</style>