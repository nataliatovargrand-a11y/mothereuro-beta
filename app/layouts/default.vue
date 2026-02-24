<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Luxury Glass Bottom Nav -->
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

.app-wrapper {
  min-height: 100vh;
  background: #D8D0C6;
}

/* Leave space for fixed nav */
.page-content {
  padding-bottom: 110px;
}

/* LUXURY GLASS NAV */
.bottom-nav {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  width: 92%;
  max-width: 520px;

  display: flex;
  justify-content: space-around;
  align-items: center;

  padding: 18px 10px;

  border-radius: 30px;

  backdrop-filter: blur(20px);
  background: rgba(255, 255, 255, 0.55);

  box-shadow:
    0 8px 30px rgba(0, 0, 0, 0.08),
    inset 0 1px 1px rgba(255,255,255,0.4);

  border: 1px solid rgba(255,255,255,0.5);
}

/* Nav Links */
.bottom-nav a {
  text-decoration: none;
  color: #2E2B29;
  font-size: 14px;
  letter-spacing: 1px;
  font-weight: 500;
  transition: 0.3s;
}

/* Active page */
.bottom-nav a.router-link-active {
  color: #A8985F;
}

/* Hover effect */
.bottom-nav a:hover {
  color: #A8985F;
}

</style>
