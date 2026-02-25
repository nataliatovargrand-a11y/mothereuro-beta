<template>
  <div class="home">

    <div class="hero">

      <img src="/images/logo.png" alt="Mother Euro Logo" class="hero-logo" />

      <div class="brand-name">
        MOTHER EURO
      </div>

      <p class="tagline">
        A curated community for women<br />
        building life across Europe.
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

/* Logo */
.hero-logo {
  width: 130px;
  margin-bottom: 30px;
}

/* ISOLA-style title refinement */
.brand-name {
  font-family: 'IBM Plex Mono', monospace;
  font-size: 34px;          /* Bigger */
  letter-spacing: 14px;     /* More editorial spacing */
  font-weight: 300;
  text-transform: uppercase;
  margin-bottom: 38px;
  color: #2E2B29;
}

/* Elegant serif tagline */
.tagline {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 300;
  max-width: 520px;
  margin: 0 auto 50px auto;
  line-height: 1.6;
  color: #5E5130;
}

/* Button */
.cta {
  display: inline-block;
  padding: 16px 40px;
  background: #A8985F;
  color: white;
  text-decoration: none;
  letter-spacing: 3px;
  font-size: 12px;
  text-transform: uppercase;
  transition: 0.3s ease;
}

.cta:hover {
  background: #5E5130;
}

</style>
