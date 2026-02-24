<template>
  <div class="layout">
    <header class="header">
      <div class="brand">MOTHER EURO</div>
    </header>

    <main class="content">
      <NuxtPage />
    </main>

    <nav class="bottom-nav">
      <NuxtLink to="/">Home</NuxtLink>
      <NuxtLink to="/upcoming">Upcoming</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>
      <NuxtLink to="/account">Account</NuxtLink>
    </nav>
  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;500&family=Inter:wght@300;400;500&display=swap');

:root {
  --me-bg: #FAF3EA;
  --me-dark: #2E2B29;
  --me-grey: #9AA1A7;
  --me-gold: #A8985F;
  --me-olive: #5E5130;
}

html, body {
  margin: 0;
  padding: 0;
  background: var(--me-bg);
  color: var(--me-dark);
  font-family: 'Inter', sans-serif;
}

h1, h2, h3 {
  font-family: 'Playfair Display', serif;
  font-weight: 300;
  letter-spacing: 2px;
}

.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: var(--me-bg);
}

.header {
  text-align: center;
  padding: 20px;
  font-family: 'Playfair Display', serif;
  letter-spacing: 4px;
  font-size: 18px;
}

.content {
  flex: 1;
  padding: 40px 20px 80px;
}

.bottom-nav {
  position: fixed;
  bottom: 0;
  width: 100%;
  background: white;
  display: flex;
  justify-content: space-around;
  padding: 14px 0;
  font-size: 12px;
  letter-spacing: 1px;
  border-top: 1px solid #eee;
}

.bottom-nav a {
  text-decoration: none;
  color: var(--me-dark);
}

.bottom-nav a.router-link-active {
  color: var(--me-gold);
}
</style>
