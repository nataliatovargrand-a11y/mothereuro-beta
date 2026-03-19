<template>
  <div>

    <div class="page-content">
      <NuxtPage />
    </div>

    <nav class="bottom-nav">

      <NuxtLink
        to="/account"
        class="nav-item"
        :class="{ hidden: !isLoggedIn }"
      >
        Account
      </NuxtLink>

      <NuxtLink
        to="/explore"
        class="nav-item"
        :class="{ hidden: !isLoggedIn }"
      >
        Explore
      </NuxtLink>

      <div class="logo-center">
        <NuxtLink to="/">
          <img src="/images/logo.png" class="footer-logo" />
        </NuxtLink>
      </div>

      <NuxtLink
        to="/events"
        class="nav-item"
        :class="{ hidden: !isLoggedIn }"
      >
        Events
      </NuxtLink>

      <NuxtLink
        to="/partners"
        class="nav-item"
        :class="{ hidden: !isLoggedIn }"
      >
        Partners
      </NuxtLink>

    </nav>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { supabase } from '~/utils/supabase'

const isLoggedIn = ref(false)
let listener = null

onMounted(async () => {

  // initial check
  const { data: { session } } = await supabase.auth.getSession()
  isLoggedIn.value = !!session

  // listen for login/logout changes
  const { data } = supabase.auth.onAuthStateChange((_event, session) => {
    isLoggedIn.value = !!session
  })

  listener = data.subscription

})

onUnmounted(() => {
  if (listener) listener.unsubscribe()
})
</script>

<style scoped>

.page-content{
  padding-bottom:90px;
}

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

.hidden{
  visibility:hidden;
}

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