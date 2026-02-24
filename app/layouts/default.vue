<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Clean Luxury Glass Footer -->
    <nav class="bottom-nav">

      <NuxtLink to="/upcoming">Events</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>

      <!-- Center Logo -->
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

.page-content {
  padding-bottom: 120px;
}

/* GLASS BAR */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;

  display: flex;
  justify-content: space-around;
  align-items: center;

  padding: 14px 10px;

  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);

  background: rgba(255, 255, 255, 0.35);

  border-top: 1px solid rgba(255,255,255,0.6);

  box-shadow:
    0 -6px 25px rgba(0,0,0,0.05),
    inset 0 1px 0 rgba(255,255,255,0.5);

  overflow: visible;
}

/* NAV TEXT */
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

/* CENTER LOGO */
.home-logo {
  position: relative;
  transform: translateY(-22px); /* slight break above bar */
  z-index: 2;
}

.home-logo img {
  width: 80px; /* bigger */
  height: auto;
  filter: drop-shadow(0 14px 20px rgba(0,0,0,0.12));
  transition: 0.3s ease;
}

.home-logo img:hover {
  transform: scale(1.03);
}

</style>
