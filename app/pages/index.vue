<template>
  <div class="home">

    <div class="hero">

      <img src="/images/logo.png" alt="Mother Euro Logo" class="logo" />

      <h1>Mother Euro</h1>

      <p class="tagline">
        A curated community supporting women building life, business, and belonging abroad
      </p>

      <button class="cta" @click="goMembership">
        Explore Membership
      </button>

    </div>

    <footer class="footer">
      <NuxtLink to="/">Home</NuxtLink>
      <NuxtLink to="/upcoming">Upcoming</NuxtLink>
      <NuxtLink to="/partners">Partners</NuxtLink>
      <NuxtLink to="/account">Account</NuxtLink>
    </footer>

  </div>
</template>

<script setup>
const router = useRouter()

const goMembership = () => {
  router.push('/account')
}
</script>

<style scoped>

.home {
  min-height: 100vh;
  background: #FAF3EA;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  text-align: center;
  padding: 60px 20px;
}

.hero {
  margin-top: 60px;
}

.logo {
  width: 80px;
  margin-bottom: 30px;
}

h1 {
  font-size: 42px;
  font-weight: 300;
  margin-bottom: 20px;
  color: #2E2B29;
}

.tagline {
  max-width: 600px;
  margin: 0 auto 40px auto;
  font-size: 18px;
  color: #2E2B29;
  line-height: 1.6;
}

.cta {
  background: #2E2B29;
  color: white;
  padding: 14px 30px;
  border-radius: 40px;
  border: none;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.cta:hover {
  background: #A8985F;
  color: #2E2B29;
}

.footer {
  margin-top: 80px;
  display: flex;
  gap: 30px;
  padding-bottom: 30px;
}

.footer a {
  text-decoration: none;
  color: #2E2B29;
  font-size: 14px;
}

.footer a:hover {
  color: #A8985F;
}

</style>
