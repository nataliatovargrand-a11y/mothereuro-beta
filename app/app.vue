<template>
  <div class="app-wrapper">
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<script setup>
</script>

<style>

/* ============================= */
/* BRAND VARIABLES */
/* ============================= */

:root {
  --me-bg: #f6f3ee;
  --me-accent: #4b7c6b;
  --me-text: #111111;
  --me-muted: #8a8a8a;
  --me-card: #ffffff;
}

/* ============================= */
/* GLOBAL RESET */
/* ============================= */

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", sans-serif;
  background: var(--me-bg);
  color: var(--me-text);
  -webkit-font-smoothing: antialiased;
}

/* ============================= */
/* GLOBAL LAYOUT */
/* ============================= */

.app-wrapper {
  min-height: 100vh;
}

.me-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 80px 40px;
}

/* ============================= */
/* HEADINGS */
/* ============================= */

h1 {
  font-size: 48px;
  font-weight: 500;
  margin-bottom: 40px;
}

h2 {
  font-weight: 500;
}

/* ============================= */
/* BUTTON SYSTEM */
/* ============================= */

button {
  font-family: inherit;
}

.me-button {
  background: black;
  color: white;
  border: none;
  padding: 14px 26px;
  border-radius: 40px;
  font-size: 13px;
  letter-spacing: 1px;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.25s ease;
}

.me-button:hover {
  background: var(--me-accent);
  transform: translateY(-2px);
}

/* ============================= */
/* CARD BASE */
/* ============================= */

.me-card {
  background: var(--me-card);
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.06);
}

/* ============================= */
/* RESPONSIVE */
/* ============================= */

@media (max-width: 768px) {
  .me-container {
    padding: 60px 20px;
  }

  h1 {
    font-size: 36px;
  }
}

</style>
