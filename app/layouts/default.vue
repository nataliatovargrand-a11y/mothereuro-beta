<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Editorial Glass Footer -->
    <nav class="bottom-nav">

      <NuxtLink to="/upcoming">EVENTS</NuxtLink>
      <NuxtLink to="/partners">PARTNERS</NuxtLink>

      <!-- Center Logo -->
      <NuxtLink to="/" class="home-logo">
        <img src="/images/logo.png" alt="Mother Euro" />
      </NuxtLink>

      <NuxtLink to="/resources">RESOURCES</NuxtLink>
      <NuxtLink to="/account">ACCOUNT</NuxtLink>

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
  padding-bottom: 100px;
}

/* Glass Bar */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;

  display: flex;
  justify-content: space-around;
  align-items: center;

  padding: 16px 12px;

  backdrop-filter: blur(26px);
  -webkit-backdrop-filter: blur(26px);

  background: rgba(255, 255, 255, 0.35);

  border-top: 1px solid rgba(255,255,255,0.6);

  box-shadow:
    0 -6px 20px rgba(0,0,0,0.05),
    inset 0 1px 0 rgba(255,255,255,0.5);
}

/* Editorial Nav Text */
.bottom-nav a {
  text-decoration: none;
  color: #2E2B29;

  font-size: 11px;
  letter-spacing: 2px;
  font-weight: 400;

  transition: 0.3s ease;
}

.bottom-nav a.router-link-active {
  color: #A8985F;
}

.bottom-nav a:hover {
  color: #A8985F;
}

/* Center Logo (no break) */
.home-logo img {
  width: 52px;
  height: auto;
  transition: 0.3s ease;
}

.home-logo img:hover {
  transform: scale(1.05);
}

</style>
