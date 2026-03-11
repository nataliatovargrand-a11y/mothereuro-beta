<template>
  <div>

    <!-- Page Content -->
    <div class="page-content">
      <NuxtPage />
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
      <div class="bottom-nav-inner">

        <NuxtLink to="/account" class="nav-item">
          Account
        </NuxtLink>

        <NuxtLink to="/explore" class="nav-item">
          Explore
        </NuxtLink>

        <div class="logo-center">
          <NuxtLink to="/">
            <img src="/images/logo.png" class="footer-logo" />
          </NuxtLink>
        </div>

        <NuxtLink to="/events" class="nav-item">
          Events
        </NuxtLink>

        <NuxtLink to="/partners" class="nav-item">
          Partners
        </NuxtLink>

      </div>
    </nav>

  </div>
</template>

<style scoped>

.page-content {
  padding-bottom: 90px;
}

/* NAV BAR */

.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 70px;
  background: rgba(255,255,255,0.65);
  backdrop-filter: blur(25px);
  border-top: 1px solid rgba(0,0,0,0.05);
  display: flex;
  justify-content: center;
  align-items: center;
}

.bottom-nav-inner {
  width: 100%;
  max-width: 900px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 40px;
  position: relative;
}

.nav-item {
  font-size: 11px;
  letter-spacing: 2px;
  text-decoration: none;
  color: black;
  opacity: 0.6;
}

.logo-center {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.footer-logo {
  width: 36px;
  height: auto;
}

</style>