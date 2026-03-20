<template>

  <!-- LOADING -->

  <div v-if="loading" class="profile-wrapper">
    <div class="loading">Loading member...</div>
  </div>

  <!-- NOT FOUND -->

  <div v-else-if="!member" class="profile-wrapper">
    <div class="not-found">
      Member not found
    </div>
  </div>

  <!-- PROFILE -->

  <div v-else class="profile-wrapper">

    <div class="profile-header">

      <img
        v-if="member.avatar_url"
        :src="member.avatar_url"
        class="profile-avatar"
      />

      <div v-else class="profile-avatar-placeholder"></div>

      <div class="profile-name">
        {{ member.first_name }}
      </div>

      <div v-if="member.industry" class="profile-industry">
        {{ member.industry }}
      </div>

      <div v-if="member.city" class="profile-city">
        {{ member.city }}
      </div>

    </div>

    <div class="profile-body">

      <div v-if="member.bio" class="profile-section">
        <h3>About</h3>
        <p>{{ member.bio }}</p>
      </div>

      <div v-if="member.linkedin || member.website" class="profile-section">
        <h3>Links</h3>

        <a
          v-if="member.linkedin"
          :href="member.linkedin"
          target="_blank"
          class="profile-link"
        >
          LinkedIn
        </a>

        <a
          v-if="member.website"
          :href="member.website"
          target="_blank"
          class="profile-link"
        >
          Website
        </a>

      </div>

    </div>

  </div>

</template>


<script setup>

import { useRoute, useRouter } from 'vue-router'
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const route = useRoute()
const router = useRouter()

const member = ref(null)
const loading = ref(true)

onMounted(async () => {

  const id = route.params.id

  // guard against invalid ids
  if (!id || id.length < 10) {
    router.push('/members')
    return
  }

  const { data, error } = await supabase
    .from('members')
    .select('*')
    .eq('id', id)
    .single()

  if (error || !data) {
    router.push('/members')
    return
  }

  member.value = data
  loading.value = false

})

</script>


<style scoped>

.profile-wrapper{
  padding:140px 40px;
  max-width:800px;
  margin:0 auto;
}

/* STATES */

.loading{
  text-align:center;
  opacity:.6;
}

.not-found{
  text-align:center;
  opacity:.6;
}


/* HEADER */

.profile-header{
  text-align:center;
  margin-bottom:60px;
}


/* AVATAR */

.profile-avatar{
  width:140px;
  height:140px;
  border-radius:50%;
  object-fit:cover;
  margin-bottom:20px;
}

.profile-avatar-placeholder{
  width:140px;
  height:140px;
  border-radius:50%;
  background:#eee;
  margin:0 auto 20px;
}


/* TEXT */

.profile-name{
  font-size:32px;
  letter-spacing:1px;
  margin-bottom:6px;
}

.profile-industry{
  opacity:.7;
}

.profile-city{
  font-size:12px;
  letter-spacing:2px;
  opacity:.5;
  margin-top:6px;
  text-transform:uppercase;
}


/* BODY */

.profile-body{
  display:flex;
  flex-direction:column;
  gap:40px;
}


/* SECTIONS */

.profile-section h3{
  font-size:18px;
  margin-bottom:10px;
}


/* LINKS */

.profile-link{
  display:inline-block;
  margin-right:20px;
  text-decoration:none;
  border-bottom:1px solid black;
  padding-bottom:2px;
  font-size:14px;
}


/* MOBILE */

@media (max-width:768px){

  .profile-wrapper{
    padding:120px 20px;
  }

  .profile-name{
    font-size:26px;
  }

}

</style>