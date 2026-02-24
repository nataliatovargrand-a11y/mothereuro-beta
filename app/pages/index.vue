<template>
  <div class="home">

    <div class="hero">

      <img src="/images/logo.png" alt="Mother Euro Logo" class="logo" />

      <h1 class="brand-title">
        MOTHER EURO
      </h1>

      <p class="tagline">
        A curated community supporting women
        <br />
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

    <nav class="bottom-nav">
      <NuxtLink to="/">Home</NuxtLink>
      <NuxtLink to="/upcoming">Upcoming</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>
      <NuxtLink to="/account">Account</NuxtLink>
    </nav>

  </div>
</template>

<script setup>
</script>

<style scoped>

.home {
  min-height: 100vh;
  background: #D8D0C6;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  text-align: center;
  padding-top: 100px;
}

/* LOGO */
.logo {
  width: 120px;
  margin-bottom: 50px;
}

/* TITLE */
.brand-title {
  font-size: 34px;
  letter-spacing: 12px;
  font-weight: 300;
  margin-bottom: 30px;
  color: #2E2B29;
}

/* TAGLINE */
.tagline {
  font-size: 18px;
  line-height: 1.6;
  color: #4A4745;
  margin-bottom: 50px;
}

/* CTA BUTTONS */
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

/* BOTTOM NAV */
.bottom-nav {
  width: 100%;
  display: flex;
  justify-content: space-around;
  padding: 20px 0;
  background: #E3DED7;
  border-top: 1px solid rgba(0,0,0,0.05);
}

.bottom-nav a {
  text-decoration: none;
  color: #2E2B29;
  font-size: 16px;
}

.bottom-nav a:hover {
  color: #A8985F;
}

</style>
