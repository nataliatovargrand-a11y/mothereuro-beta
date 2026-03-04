<template>

  <div class="members-wrapper">

    <div class="members-header">
      <h1>Members</h1>
      <p class="members-subtitle">
        Women building life and business across Europe
      </p>
    </div>

    <div class="members-grid">

      <NuxtLink
        v-for="member in members"
        :key="member.id"
        :to="`/members/${member.id}`"
        class="member-card"
      >

        <img
          v-if="member.avatar_url"
          :src="member.avatar_url"
          class="member-avatar"
        />

        <div v-else class="member-avatar-placeholder"></div>

        <div class="member-name">
          {{ member.first_name }}
        </div>

        <div v-if="member.industry" class="member-industry">
          {{ member.industry }}
        </div>

        <div v-if="member.city" class="member-city">
          {{ member.city }}
        </div>

      </NuxtLink>

    </div>

  </div>

</template>

<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const members = ref([])

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('id, first_name, city, industry, avatar_url')

  members.value = data || []

})

</script>

<style scoped>

.members-wrapper{
  padding:120px 40px 140px;
  max-width:1100px;
  margin:0 auto;
}

.members-header{
  margin-bottom:60px;
}

.members-header h1{
  font-size:40px;
  letter-spacing:2px;
  margin-bottom:10px;
}

.members-subtitle{
  opacity:.6;
}

.members-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
  gap:30px;
}

.member-card{
  display:block;
  background:white;
  border-radius:18px;
  padding:24px;
  text-align:center;
  box-shadow:0 10px 30px rgba(0,0,0,0.05);
  transition:all .25s ease;
  text-decoration:none;
  color:inherit;
}

.member-card:hover{
  transform:translateY(-4px);
  box-shadow:0 20px 40px rgba(0,0,0,0.08);
}

.member-avatar{
  width:96px;
  height:96px;
  border-radius:50%;
  object-fit:cover;
  margin:0 auto 14px;
}

.member-avatar-placeholder{
  width:96px;
  height:96px;
  border-radius:50%;
  background:#eee;
  margin:0 auto 14px;
}

.member-name{
  font-size:16px;
  letter-spacing:.5px;
  font-weight:500;
}

.member-industry{
  font-size:13px;
  opacity:.7;
}

.member-city{
  font-size:11px;
  letter-spacing:1px;
  opacity:.5;
  text-transform:uppercase;
}

</style>