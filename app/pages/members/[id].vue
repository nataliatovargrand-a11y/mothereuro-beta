<template>

  <div class="profile-wrapper" v-if="member">

    <div class="profile-header">

      <img
        v-if="member.avatar_url"
        :src="member.avatar_url"
        class="profile-avatar"
      />

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

import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const route = useRoute()
const member = ref(null)

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('*')
    .eq('id', route.params.id)
    .single()

  member.value = data

})

</script>

<style scoped>

.profile-wrapper{
  padding:140px 40px;
  max-width:800px;
  margin:0 auto;
}

.profile-header{
  text-align:center;
  margin-bottom:60px;
}

.profile-avatar{
  width:140px;
  height:140px;
  border-radius:50%;
  object-fit:cover;
  margin-bottom:20px;
}

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
}

.profile-body{
  display:flex;
  flex-direction:column;
  gap:40px;
}

.profile-section h3{
  font-size:18px;
  margin-bottom:10px;
}

.profile-link{
  display:inline-block;
  margin-right:20px;
  text-decoration:none;
  border-bottom:1px solid black;
  padding-bottom:2px;
}

</style>