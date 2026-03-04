<template>

  <div class="members-wrapper">

    <div class="members-header">
      <h1>Members</h1>
      <p class="members-subtitle">
        Women building life and business across Europe
      </p>
    </div>

    <div
      v-for="(group, city) in groupedMembers"
      :key="city"
      class="city-group"
    >

      <h2 class="city-title">
        {{ city }}
      </h2>

      <div class="members-grid">

<NuxtLink
  v-for="member in group"
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

  <div class="member-info">

    <div class="member-name">
      {{ member.first_name }}
    </div>

    <div v-if="member.industry" class="member-industry">
      {{ member.industry }}
    </div>

    <div v-if="member.city" class="member-city">
      {{ member.city }}
    </div>

  </div>

</NuxtLink>


</template>

<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const members = ref([])

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('id, first_name, city, industry, avatar_url')
    .order('city')

  members.value = data || []

})

const groupedMembers = computed(() => {

  const groups = {}

  members.value.forEach(member => {

    const city = member.city || "Other"

    if (!groups[city]) {
      groups[city] = []
    }

    groups[city].push(member)

  })

  return groups

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

.city-group{
  margin-bottom:70px;
}

.city-title{
  font-size:22px;
  margin-bottom:25px;
  letter-spacing:1px;
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
  cursor:pointer;
}

.member-card:hover{
  transform:translateY(-6px);
  box-shadow:0 25px 50px rgba(0,0,0,0.08);
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

.member-info{
  display:flex;
  flex-direction:column;
  gap:4px;
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