<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Luxury Thin Glass Footer -->
    <nav class="bottom-nav">

      <NuxtLink to="/upcoming">Events</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>

      <!-- Center Logo (Home) -->
      <NuxtLink to="/" class="home-logo">
        <img src="/images/logo.png" alt="Mother Euro" />
      </NuxtLink>

      <NuxtLink to="/resources">Resources</NuxtLink>
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

/* Space for footer */
.page-content {
  padding-bottom: 85px;
}

/* THINNER GLASS FOOTER */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;

  display: flex;
  justify-content: space-around;
  align-items: center;

  padding: 12px 10px;

  backdrop-filter: blur(18px);
  background: rgba(255, 255, 255, 0.45);

  border-top: 1px solid rgba(255,255,255,0.6);
  box-shadow: 0 -4px 15px rgba(0,0,0,0.04);
}

/* Nav text */
.bottom-nav a {
  text-decoration: none;
  color: #2E2B29;
  font-size: 12px;
  letter-spacing: 1.2px;
  font-weight: 500;
  transition: 0.3s;
}

.bottom-nav a.router-link-active {
  color: #A8985F;
}

.bottom-nav a:hover {
  color: #A8985F;
}

/* CENTER LOGO (NO BACKGROUND) */
.home-logo {
  transform: translateY(-4px);
}

.home-logo img {
  width: 38px;
  height: auto;
  transition: 0.3s;
}

.home-logo img:hover {
  transform: scale(1.05);
}

</style>
