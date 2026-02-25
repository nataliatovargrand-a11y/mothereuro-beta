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
      <div class="bottom-nav-inner">

        <NuxtLink
          to="/upcoming"
          class="nav-item"
          :class="{ active: route.path === '/upcoming' }"
        >
          Events
        </NuxtLink>

        <NuxtLink
          to="/partners"
          class="nav-item"
          :class="{ active: route.path === '/partners' }"
        >
          Partners
        </NuxtLink>

        <div class="logo-center">
          <NuxtLink to="/">
            <img src="/images/logo.png" class="footer-logo" />
          </NuxtLink>
        </div>

        <NuxtLink
          to="/resources"
          class="nav-item"
          :class="{ active: route.path === '/resources' }"
        >
          Explore
        </NuxtLink>

        <NuxtLink
          to="/account"
          class="nav-item"
          :class="{ active: route.path === '/account' }"
        >
          Account
        </NuxtLink>

      </div>
    </nav>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { supabase } from '~/utils/supabase'

const route = useRoute()

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
  padding-bottom: 90px;
}

/* Glass bar */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 70px;
  background: rgba(255,255,255,0.6);
  backdrop-filter: blur(30px);
  -webkit-backdrop-filter: blur(30px);
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
  opacity: 0.5;
  transition: 0.2s ease;
}

.nav-item.active {
  opacity: 1;
  font-weight: 500;
}

.logo-center {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.footer-logo {
  width: 36px;
}

</style>