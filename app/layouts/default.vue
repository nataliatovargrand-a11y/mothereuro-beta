<template>
  <div class="app-wrapper">

    <!-- Page Content -->
    <div class="page-content">
      <slot />
    </div>

    <!-- Bottom Glass Navigation -->
<nav class="bottom-nav">

<NuxtLink to="/account" class="nav-item">
Account
</NuxtLink>

<NuxtLink to="/explore" class="nav-item">
Explore
</NuxtLink>

<div class="nav-logo">
<img src="/logo-icon.svg" />
</div>

<NuxtLink to="/events" class="nav-item">
Events
</NuxtLink>

<NuxtLink to="/partners" class="nav-item">
Partners
</NuxtLink>

</nav>

  </div>
</template>

<style scoped>

.app-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.page-content {
  flex: 1;
  padding-bottom: 100px; /* space for nav */
}

/* Glass Bar */
.bottom-nav{
position:fixed;
bottom:0;
left:0;
right:0;
height:70px;
background:white;
display:flex;
align-items:center;
justify-content:space-around;
border-top:1px solid rgba(0,0,0,.08);
}

.nav-item{
font-size:12px;
letter-spacing:2px;
text-decoration:none;
color:#444;
}

.router-link-active{
color:black;
font-weight:500;
}

.nav-logo img{
width:32px;
height:32px;
}

</style>