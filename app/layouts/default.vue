<template>
  <div class="app-wrapper">

    <main class="page-content">
      <slot />
    </main>

    <!-- Luxury Editorial Footer -->
    <nav class="bottom-nav">

      <NuxtLink to="/upcoming" class="nav-link">
        EVENTS
      </NuxtLink>

      <NuxtLink to="/partners" class="nav-link">
        PARTNERS
      </NuxtLink>

      <NuxtLink to="/" class="home-logo">
        <img src="/images/logo.png" alt="Mother Euro" />
      </NuxtLink>

      <NuxtLink to="/resources" class="nav-link">
        RESOURCES
      </NuxtLink>

      <NuxtLink to="/account" class="nav-link">
        ACCOUNT
      </NuxtLink>

    </nav>

  </div>
</template>

<script setup>
</script>

<style>

.app-wrapper {
  min-height: 100vh;
  background: #FAF3EA;
}

.page-content {
  padding-bottom: 100px;
}

/* Glass Footer */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;

  display: flex;
  justify-content: space-around;
  align-items: center;

  padding: 18px 12px;

  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);

  background: rgba(255, 255, 255, 0.35);

  border-top: 1px solid rgba(255,255,255,0.6);

  box-shadow:
    0 -6px 20px rgba(0,0,0,0.05),
    inset 0 1px 0 rgba(255,255,255,0.5);
}

/* Editorial Navigation */
.nav-link {
  text-decoration: none;
  color: #2E2B29;

  font-family: 'IBM Plex Mono', monospace;
  font-size: 11px;
  letter-spacing: 2px;
  font-weight: 400;
  text-transform: uppercase;

  transition: 0.3s ease;
}

.nav-link.router-link-active {
  color: #A8985F;
}

.nav-link:hover {
  color: #A8985F;
}

/* Center Logo */
.home-logo img {
  width: 52px;
  height: auto;
  transition: 0.3s ease;
}

.home-logo img:hover {
  transform: scale(1.05);
}

</style>
