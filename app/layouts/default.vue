<template>
  <div class="app-wrapper">

    <!-- Page Content -->
    <div class="page-content">
      <slot />
    </div>

    <!-- Bottom Glass Navigation -->
    <nav class="bottom-nav">
  <div class="bottom-nav-inner">

    <NuxtLink to="/upcoming" class="nav-item">
      Events
    </NuxtLink>

    <NuxtLink to="/partners" class="nav-item">
      Partners
    </NuxtLink>

    <NuxtLink to="/" class="nav-item logo-item">
      <img src="/images/logo.png" class="footer-logo" />
    </NuxtLink>

    <NuxtLink to="/resources" class="nav-item">
      Explore
    </NuxtLink>

    <NuxtLink to="/account" class="nav-item">
      Account
    </NuxtLink>

  </div>
</nav>

  </div>
</template>

<style scoped>

.app-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.page-content {
  flex: 1;
  padding-bottom: 100px; /* space for nav */
}

/* Glass Bar */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 70px;
  background: rgba(255,255,255,0.75);
  backdrop-filter: blur(25px);
  -webkit-backdrop-filter: blur(25px);
  border-top: 1px solid rgba(0,0,0,0.05);
  display: flex;
  justify-content: center;
  align-items: center;
}

.bottom-nav-inner {
  width: 100%;
  max-width: 900px;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  align-items: center;
  text-align: center;
}

.nav-item {
  font-size: 11px;
  letter-spacing: 2px;
  text-decoration: none;
  color: black;
  opacity: 0.7;
}

.logo-item {
  display: flex;
  justify-content: center;
}

.footer-logo {
  width: 34px;
}

</style>