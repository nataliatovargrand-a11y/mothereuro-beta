<template>
  <div class="partners-wrapper">

    <div class="partners-header">
      <h1>Our Strategic Partners</h1>
      <p>
        Mother Euro collaborates with curated brands across Europe
        to support our members' transition, growth, and belonging.
      </p>
    </div>

    <div class="partners-grid">

      <div
        v-for="partner in partners"
        :key="partner.id"
        class="partner-card"
      >

        <img
          v-if="partner.logo_url"
          :src="partner.logo_url"
          class="partner-logo"
        />

        <div class="partner-content">

          <h2>{{ partner.name }}</h2>

          <p class="partner-description">
            {{ partner.description }}
          </p>

          <div class="discount-box" v-if="partner.discount_code">
            <span>Member Benefit</span>
            <strong>{{ partner.discount_code }}</strong>
          </div>

          <a
            :href="partner.website_url"
            target="_blank"
            class="partner-btn"
          >
            Visit Partner
          </a>

        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const partners = ref([])

onMounted(async () => {
  const { data } = await supabase
    .from('partners')
    .select('*')
    .eq('active', true)

  partners.value = data || []
})
</script>

<style scoped>

.partners-wrapper {
  padding: 120px 40px 140px 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.partners-header {
  max-width: 700px;
  margin-bottom: 60px;
}

.partners-header h1 {
  font-size: 42px;
  margin-bottom: 20px;
}

.partners-header p {
  font-size: 16px;
  line-height: 1.6;
  opacity: 0.8;
}

.partners-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 40px;
}

.partner-card {
  background: white;
  border-radius: 24px;
  padding: 40px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
  transition: 0.3s ease;
}

.partner-card:hover {
  transform: translateY(-6px);
}

.partner-logo {
  max-width: 140px;
  margin-bottom: 25px;
}

.partner-content h2 {
  font-size: 22px;
  margin-bottom: 12px;
}

.partner-description {
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 25px;
}

.discount-box {
  background: #F3EBDD;
  border: 1px solid #A8985F;
  padding: 16px;
  margin-bottom: 25px;
  text-align: center;
}

.discount-box span {
  display: block;
  font-size: 12px;
  letter-spacing: 1px;
  margin-bottom: 5px;
  opacity: 0.7;
}

.discount-box strong {
  font-size: 18px;
  letter-spacing: 2px;
}

.partner-btn {
  display: inline-block;
  padding: 14px 24px;
  background: black;
  color: white;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 2px;
  transition: 0.3s ease;
}

.partner-btn:hover {
  background: #A8985F;
}

@media (max-width: 768px) {
  .partners-wrapper {
    padding: 100px 20px 140px 20px;
  }
}

</style>