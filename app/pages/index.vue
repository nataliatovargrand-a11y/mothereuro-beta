<template>
  <div class="home">

    <img src="/images/logo.png" alt="Mother Euro Logo" class="logo" />

    <h1 class="brand-title">
      MOTHER EURO
    </h1>

    <p class="tagline">
      A curated community supporting women
      building life, business, and belonging abroad.
    </p>

    <div class="cta-group">
      <NuxtLink to="/login" class="btn-primary">
        Login
      </NuxtLink>

      <NuxtLink to="/signup" class="btn-secondary">
        Sign Up
      </NuxtLink>
    </div>

  </div>
</template>

<script setup>
</script>

<style scoped>

.home {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 40px;
  text-align: center;
}

.logo {
  width: 120px;
  margin-bottom: 50px;
}

.brand-title {
  font-size: 34px;
  letter-spacing: 12px;
  font-weight: 300;
  margin-bottom: 30px;
  color: #2E2B29;
}

.tagline {
  font-size: 18px;
  line-height: 1.6;
  color: #4A4745;
  margin-bottom: 50px;
  max-width: 420px;
}

.cta-group {
  display: flex;
  gap: 20px;
  justify-content: center;
}

.btn-primary {
  background: #2E2B29;
  color: white;
  padding: 12px 28px;
  border-radius: 30px;
  text-decoration: none;
  font-size: 14px;
  letter-spacing: 1px;
  transition: 0.3s;
}

.btn-primary:hover {
  background: #A8985F;
}

.btn-secondary {
  border: 1px solid #2E2B29;
  color: #2E2B29;
  padding: 12px 28px;
  border-radius: 30px;
  text-decoration: none;
  font-size: 14px;
  letter-spacing: 1px;
  transition: 0.3s;
}

.btn-secondary:hover {
  background: #2E2B29;
  color: white;
}

</style>
