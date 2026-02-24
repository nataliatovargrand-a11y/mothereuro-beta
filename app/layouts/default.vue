<template>
  <div class="me-root">
    <slot />
  </div>
</template>

<style>
:root {
  --me-bg: #FAF3EA;
  --me-dark: #2E2B29;
  --me-gold: #A8985F;
  --me-gold-deep: #5E5130;
  --me-grey: #9AA1A7;
}

html, body {
  margin: 0;
  padding: 0;
  background: var(--me-bg);
  color: var(--me-dark);
  font-family: "Helvetica Neue", sans-serif;
}

.me-root {
  min-height: 100vh;
  background: var(--me-bg);
}

.me-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 60px 40px;
}

h1 {
  font-size: 48px;
  font-weight: 300;
  letter-spacing: -0.5px;
}

.me-button {
  background: var(--me-dark);
  color: white;
  padding: 14px 24px;
  border-radius: 40px;
  border: none;
  font-size: 12px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.me-button:hover {
  background: var(--me-gold);
  color: var(--me-dark);
}
</style>
