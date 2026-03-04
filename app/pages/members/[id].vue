<template>

  <div class="profile-wrapper" v-if="member">

    <div class="profile-card">

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
    .select('first_name, industry, city, avatar_url')
    .eq('first_name', route.params.id)
    .single()

  member.value = data

})

</script>

<style scoped>

.profile-wrapper{
  padding:140px 40px;
  display:flex;
  justify-content:center;
}

.profile-card{
  text-align:center;
  max-width:400px;
}

.profile-avatar{
  width:120px;
  height:120px;
  border-radius:50%;
  object-fit:cover;
  margin-bottom:20px;
}

.profile-name{
  font-size:28px;
  letter-spacing:1px;
  margin-bottom:8px;
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

</style>