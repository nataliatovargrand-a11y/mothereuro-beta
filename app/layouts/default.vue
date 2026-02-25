<template>
  <div>

    <!-- Top Greeting -->
    <div v-if="user && firstName" class="member-bar">
      Hi, {{ firstName }}
    </div>

    <!-- Page Content -->
    <div class="page-content">
      <NuxtPage />
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
      <NuxtLink to="/" class="nav-item">Home</NuxtLink>
      <NuxtLink to="/upcoming" class="nav-item">Events</NuxtLink>

      <div class="logo-center">
        <NuxtLink to="/">
          <img src="/images/logo.png" class="footer-logo" />
        </NuxtLink>
      </div>

      <NuxtLink to="/partners" class="nav-item">Partners</NuxtLink>
      <NuxtLink to="/account" class="nav-item">Account</NuxtLink>
    </nav>

  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const firstName = ref(null)

onMounted(async () => {

  const { data } = await supabase.auth.getUser()

  if (data.user) {

    user.value = data.user

    const { data: member } = await supabase
      .from('members')
      .select('first_name')
      .eq('email', data.user.email)
      .single()

    firstName.value = member?.first_name
  }

})

</script>

<style scoped>

.member-bar {
  position: fixed;
  top: 0;
  width: 100%;
  background: #FAF3EA;
  border-bottom: 1px solid #E5DCD2;
  padding: 16px 40px;
  font-size: 15px;
  letter-spacing: 1px;
  z-index: 1000;
}

.page-content {
  padding-top: 70px;
  padding-bottom: 120px;
}

.bottom-nav {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  width: 90%;
  max-width: 700px;
  background: rgba(255,255,255,0.7);
  backdrop-filter: blur(20px);
  border-radius: 40px;
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 16px 20px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.nav-item {
  font-size: 12px;
  letter-spacing: 2px;
  text-decoration: none;
  color: black;
}

.logo-center {
  width: 60px;
  display: flex;
  justify-content: center;
}

.footer-logo {
  width: 40px;
}

@media (max-width: 768px) {
  .member-bar {
    padding: 14px 20px;
  }
}

</style>