<template>
  <div class="app-container">
    <main class="content">
      <slot />
    </main>

    <nav class="bottom-nav">
      <NuxtLink to="/">Home</NuxtLink>
      <NuxtLink to="/upcoming">Upcoming</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>
      <NuxtLink to="/account">Account</NuxtLink>
    </nav>
  </div>
</template>

<style scoped>
.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.content {
  flex: 1;
  padding: 20px;
}

.bottom-nav {
  display: flex;
  justify-content: space-around;
  padding: 15px;
  border-top: 1px solid #eee;
  background: white;
  position: sticky;
  bottom: 0;
}

.bottom-nav a {
  text-decoration: none;
  color: #111;
  font-weight: 500;
}

.bottom-nav a.router-link-active {
  font-weight: bold;
}
</style>
