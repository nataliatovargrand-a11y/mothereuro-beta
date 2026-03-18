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

        <p class="partner-description">
          {{ partner.description }}
        </p>

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

  if (!category) return ''

  return category.toUpperCase()

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
  overflow-x:hidden;
}


/* HEADER */

.partners-header{
  margin-bottom:60px;
}

.partners-title{
  font-size:18px;
  letter-spacing:3px;
  text-transform:uppercase;
  margin-bottom:10px;
}

.partners-subtitle{
  font-size:14px;
  opacity:.6;
  max-width:480px;
}


/* CATEGORY */

.category-section{
  margin-bottom:70px;
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
  scroll-snap-type:x mandatory;
}

.partners-carousel::-webkit-scrollbar{
  display:none;
}


/* CARD */

.partner-card{
  min-width:260px;
  background:white;
  border-radius:18px;
  padding:24px;
  box-shadow:0 10px 30px rgba(0,0,0,0.05);
  transition:.25s ease;
  scroll-snap-align:start;
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
  margin-bottom:18px;
  opacity:.8;
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
  margin-bottom:16px;
}

.discount-code{
  font-family:monospace;
  font-size:14px;
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


/* LINK */

.visit-btn{
  text-decoration:none;
  font-size:13px;
  letter-spacing:1px;
}


/* MOBILE */

@media (max-width:768px){

  .partner-card{
    min-width:220px;
    padding:20px;
  }

}

</style>