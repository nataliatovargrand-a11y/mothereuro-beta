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
          EVENTS
        </NuxtLink>

        <NuxtLink to="/partners" class="nav-item">
          PARTNERS
        </NuxtLink>

        <!-- Center Logo -->
        <NuxtLink to="/" class="logo-center">
          <img src="/images/logo.png" class="footer-logo" />
        </NuxtLink>

        <NuxtLink to="/resources" class="nav-item">
          EXPLORE
        </NuxtLink>

        <NuxtLink to="/account" class="nav-item">
          ACCOUNT
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
  height: 72px;

  background: rgba(255,255,255,0.55);
  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);

  border-top: 1px solid rgba(0,0,0,0.06);

  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.bottom-nav-inner {
  width: 100%;
  max-width: 900px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 0 40px;
  position: relative;
}

.nav-item {
  font-size: 11px;
  letter-spacing: 2px;
  text-decoration: none;
  color: black;
  opacity: 0.6;
  transition: 0.3s ease;
}

.nav-item:hover {
  opacity: 1;
}

/* Center Logo */
.logo-center {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.footer-logo {
  width: 44px;
  display: block;
}

</style>