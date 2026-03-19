<template>
  <div>

    <!-- Page Content -->
    <div class="page-content">
      <NuxtPage />
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">

      <!-- LEFT SIDE (only if logged in) -->
      <template v-if="isLoggedIn">

        <NuxtLink to="/account" class="nav-item">
          Account
        </NuxtLink>

        <NuxtLink to="/explore" class="nav-item">
          Explore
        </NuxtLink>

      </template>

      <!-- CENTER LOGO -->
      <div class="logo-center">
        <NuxtLink to="/">
          <img src="/images/logo.png" class="footer-logo" />
        </NuxtLink>
      </div>

      <!-- RIGHT SIDE (only if logged in) -->
      <template v-if="isLoggedIn">

        <NuxtLink to="/events" class="nav-item">
          Events
        </NuxtLink>

        <NuxtLink to="/partners" class="nav-item">
          Partners
        </NuxtLink>

      </template>

      <!-- LOGGED OUT STATE -->
      <template v-else>

        <NuxtLink to="/login" class="nav-item">
          Log In
        </NuxtLink>

        <div></div>

        <div></div>

        <div></div>

      </template>

    </nav>

  </div>
</template>


<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const isLoggedIn = ref(false)

onMounted(async () => {
  const { data: { session } } = await supabase.auth.getSession()
  isLoggedIn.value = !!session
})

</script>


<style scoped>

/* PAGE CONTENT */

.page-content{
  padding-bottom:90px;
}

/* NAV BAR */

.bottom-nav{

  position:fixed;
  bottom:0;
  left:0;
  width:100%;
  height:72px;

  display:grid;
  grid-template-columns:1fr 1fr auto 1fr 1fr;
  align-items:center;

  background:rgba(255,255,255,0.65);
  backdrop-filter:blur(25px);

  border-top:1px solid rgba(0,0,0,0.05);

  z-index:1000;

}

/* NAV ITEMS */

.nav-item{

  text-align:center;

  font-size:11px;
  letter-spacing:2px;

  text-decoration:none;
  color:black;

  opacity:.6;

  display:flex;
  justify-content:center;
  align-items:center;

  transition:opacity .2s ease;

}

.nav-item:hover{
  opacity:1;
}

/* CENTER LOGO */

.logo-center{

  display:flex;
  justify-content:center;
  align-items:center;

}

.footer-logo{

  width:36px;
  height:auto;

  transition:transform .25s ease;

}

.footer-logo:hover{
  transform:scale(1.05);
}

</style>