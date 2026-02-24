<template>
  <div class="home">

    <div class="hero">

      <img src="/images/logo.png" alt="Mother Euro Logo" class="hero-logo" />

      <div class="brand-name">
        MOTHER EURO
      </div>

      <p class="tagline">
        A curated community supporting women building life,
        business, and belonging abroad
      </p>

      <NuxtLink to="/account" class="cta">
        LOGIN / SIGN UP
      </NuxtLink>

    </div>

  </div>
</template>

<script setup>
</script>

<style>

.home {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 40px 20px;
}

.hero-logo {
  width: 110px;
  margin-bottom: 18px;
}

/* THIS is the ISOLA-style replacement */
.brand-name {
  font-family: 'IBM Plex Mono', monospace;
  font-size: 14px;
  letter-spacing: 4px;
  font-weight: 400;
  text-transform: uppercase;
  margin-bottom: 22px;
  color: #2E2B29;
}

/* Editorial serif tagline */
.tagline {
  font-family: 'Cormorant Garamond', serif;
  font-size: 20px;
  font-weight: 300;
  max-width: 480px;
  margin: 0 auto 40px auto;
  line-height: 1.5;
}

.cta {
  display: inline-block;
  padding: 14px 30px;
  background: #A8985F;
  color: white;
  text-decoration: none;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  transition: 0.3s ease;
}

.cta:hover {
  background: #5E5130;
}

</style>
