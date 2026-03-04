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

        <div
          v-for="member in group"
          :key="member.id"
          class="member-card"
        >

          <img
            v-if="member.avatar_url"
            :src="member.avatar_url"
            class="member-avatar"
          />

          <div
            v-else
            class="member-avatar-placeholder"
          ></div>

          <div class="member-name">
            {{ member.first_name }}
          </div>

          <div class="member-industry">
            {{ member.industry }}
          </div>

        </div>

      </div>

    </div>

  </div>

</template>

<script setup>

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const members = ref([])

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('id, first_name, city, industry, avatar_url, membership_status')
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
  grid-template-columns:repeat(auto-fill,minmax(140px,1fr));
  gap:35px;
}

.member-card{
  text-align:center;
}

.member-avatar{
  width:90px;
  height:90px;
  border-radius:50%;
  object-fit:cover;
  margin-bottom:10px;
}

.member-avatar-placeholder{
  width:90px;
  height:90px;
  border-radius:50%;
  background:#eee;
  margin-bottom:10px;
}

.member-name{
  font-size:14px;
  letter-spacing:1px;
}

.member-industry{
  font-size:12px;
  opacity:.6;
}

</style>