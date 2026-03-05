<template>

<div class="partners-wrapper">

  <div class="partners-header">
    <h1>Partners</h1>

    <p class="partners-subtitle">
      Curated brands offering exclusive benefits
      for the Mother Euro community
    </p>
  </div>


  <!-- Category Filters -->

  <div class="partner-filters">

    <button
      :class="{ active: selectedCategory === null }"
      @click="selectedCategory = null"
    >
      All
    </button>

    <button
      v-for="category in categories"
      :key="category"
      :class="{ active: selectedCategory === category }"
      @click="selectedCategory = category"
    >
      {{ category }}
    </button>

  </div>


  <!-- Partners Grid -->

  <div class="partners-grid">

    <div
      v-for="partner in filteredPartners"
      :key="partner.id"
      class="partner-card"
    >

      <img
        v-if="partner.image_url"
        :src="partner.image_url"
        class="partner-image"
      />

      <div class="partner-content">

        <h2 class="partner-name">
          {{ partner.name }}
        </h2>

        <div class="partner-city">
          {{ partner.city }}
        </div>

        <p class="partner-description">
          {{ partner.description }}
        </p>


        <div
          v-if="partner.discount_description"
          class="partner-benefit"
        >

          <div class="benefit-label">
            Mother Euro Benefit
          </div>

          <div class="benefit-description">
            {{ partner.discount_description }}
          </div>

          <div
            v-if="partner.discount_code"
            class="discount-code"
          >
            CODE: {{ partner.discount_code }}
          </div>

        </div>


        <button
          class="redeem-btn"
          @click="redeemPartner(partner)"
        >
          Redeem Benefit
        </button>

      </div>

    </div>

  </div>

</div>

</template>



<script setup>

import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const partners = ref([])
const selectedCategory = ref(null)

const categories = [
  "Travel",
  "Fashion",
  "Wellness",
  "Gastronomy",
  "Beauty"
]


onMounted(async () => {

  const { data } = await supabase
    .from('partners')
    .select('*')
    .eq('active', true)

  partners.value = data || []

})


const filteredPartners = computed(() => {

  return partners.value.filter(p => {

    if (!selectedCategory.value) return true

    return p.category === selectedCategory.value

  })

})


const redeemPartner = async (partner) => {

  const { data } = await supabase.auth.getUser()

  if (!data.user) {
    alert("Please login first")
    return
  }

  await supabase
    .from('partner_redemptions')
    .insert({
      partner_id: partner.id,
      member_id: data.user.id
    })

  alert("Benefit redeemed! Use the code with the partner.")

}

</script>



<style scoped>

.partners-wrapper{
padding:120px 40px 140px;
max-width:1100px;
margin:0 auto;
}

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

/* FILTERS */

.partner-filters{
display:flex;
gap:16px;
margin-bottom:50px;
flex-wrap:wrap;
}

.partner-filters button{
border:1px solid rgba(0,0,0,0.15);
background:white;
padding:6px 14px;
border-radius:20px;
font-size:12px;
letter-spacing:1px;
cursor:pointer;
}

.partner-filters button.active{
background:black;
color:white;
border-color:black;
}


/* GRID */

.partners-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:40px;
}

/* CARD */

.partner-card{
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 20px 40px rgba(0,0,0,0.05);
transition:.25s;
}

.partner-card:hover{
transform:translateY(-6px);
box-shadow:0 30px 60px rgba(0,0,0,0.08);
}

.partner-image{
width:100%;
height:220px;
object-fit:cover;
}

.partner-content{
padding:24px;
}

.partner-name{
font-size:20px;
margin-bottom:6px;
}

.partner-city{
font-size:12px;
letter-spacing:1px;
opacity:.6;
margin-bottom:14px;
}

.partner-description{
font-size:14px;
margin-bottom:18px;
line-height:1.6;
}

/* BENEFIT */

.partner-benefit{
background:#faf8f3;
padding:14px;
border-radius:10px;
margin-bottom:16px;
}

.benefit-label{
font-size:11px;
letter-spacing:2px;
margin-bottom:4px;
opacity:.6;
}

.benefit-description{
font-size:14px;
margin-bottom:6px;
}

.discount-code{
font-size:13px;
letter-spacing:1px;
font-weight:500;
}

/* BUTTON */

.redeem-btn{
background:black;
color:white;
border:none;
padding:12px 18px;
font-size:12px;
letter-spacing:2px;
cursor:pointer;
}

.redeem-btn:hover{
background:#A8985F;
}

</style>