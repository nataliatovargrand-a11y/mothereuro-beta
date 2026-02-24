<template>
  <div class="app-wrapper">

    <!-- Page Content -->
    <main class="page-content">
      <slot />
    </main>

    <!-- Global Fixed Bottom Nav -->
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
  padding-bottom: 90px;
}

/* FIXED FOOTER */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  display: flex;
  justify-content: space-around;
  padding: 18px 0;
  background: #E3DED7;
  border-top: 1px solid rgba(0,0,0,0.05);
}

.bottom-nav a {
  text-decoration: none;
  color: #2E2B29;
  font-size: 15px;
  font-weight: 500;
}

.bottom-nav a.router-link-active {
  color: #A8985F;
}

</style>
