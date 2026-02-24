<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Refined Glass Footer -->
    <nav class="bottom-nav">

      <NuxtLink to="/upcoming">Events</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>

      <!-- Center Logo (naturally breaking above bar) -->
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

/* Leave space for bar */
.page-content {
  padding-bottom: 110px;
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

  padding: 10px 10px;

  backdrop-filter: blur(30px);
  -webkit-backdrop-filter: blur(30px);

  background: rgba(255, 255, 255, 0.35);

  border-top: 1px solid rgba(255,255,255,0.7);

  box-shadow:
    0 -8px 30px rgba(0,0,0,0.06),
    inset 0 1px 0 rgba(255,255,255,0.6);
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

/* CENTER LOGO */
.home-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: -28px; /* allows logo to break above */
}

.home-logo img {
  width: 70px; /* larger logo */
  height: auto;
  filter: drop-shadow(0 12px 18px rgba(0,0,0,0.15));
  transition: 0.3s ease;
}

.home-logo img:hover {
  transform: scale(1.04);
}

</style>
