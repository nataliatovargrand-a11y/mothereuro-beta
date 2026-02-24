<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Luxury Glass Footer -->
    <nav class="bottom-nav">

      <NuxtLink to="/upcoming">Upcoming</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>

      <!-- Center Logo = Home -->
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

/* Leave space for footer */
.page-content {
  padding-bottom: 100px;
}

/* FULL WIDTH GLASS FOOTER */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;

  display: flex;
  justify-content: space-around;
  align-items: center;

  padding: 18px 10px;

  backdrop-filter: blur(20px);
  background: rgba(255, 255, 255, 0.55);

  border-top: 1px solid rgba(255,255,255,0.6);
  box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
}

/* Nav links */
.bottom-nav a {
  text-decoration: none;
  color: #2E2B29;
  font-size: 13px;
  letter-spacing: 1px;
  font-weight: 500;
  transition: 0.3s;
}

/* Active state */
.bottom-nav a.router-link-active {
  color: #A8985F;
}

/* Hover */
.bottom-nav a:hover {
  color: #A8985F;
}

/* CENTER LOGO */
.home-logo {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transform: translateY(-10px);
}

.home-logo img {
  width: 24px;
  height: auto;
}

</style>
