<template>

  <div class="members-wrapper">

    <div class="members-header">
      <h1>Members</h1>
      <p class="members-subtitle">
        Women building life and business across Europe
      </p>
    </div>

    <div class="members-grid">

      <div
        v-for="member in members"
        :key="member.id"
        class="member-card"
        @click="toggleMember(member.id)"
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

        <!-- EXPANDED DETAILS -->

        <div
          v-if="expandedMember === member.id"
          class="member-details"
        >

          <div class="detail-row">
            <span class="label">Industry</span>
            <span>{{ member.industry || '—' }}</span>
          </div>

          <div class="detail-row">
            <span class="label">City</span>
            <span>{{ member.city || '—' }}</span>
          </div>

          <div class="detail-row">
            <span class="label">Membership</span>
            <span>{{ member.membership_tier || 'Member' }}</span>
          </div>

        </div>

      </div>

    </div>

  </div>

</template>

<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const members = ref([])
const expandedMember = ref(null)

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('*')
    .order('first_name')

  members.value = data || []

})

const toggleMember = (id) => {

  if (expandedMember.value === id) {
    expandedMember.value = null
  } else {
    expandedMember.value = id
  }

}

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
  background:white;
  border-radius:20px;
  padding:26px;
  text-align:center;
  box-shadow:0 10px 30px rgba(0,0,0,0.05);
  transition:all .25s ease;
  cursor:pointer;
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

.member-details{
  margin-top:18px;
  padding-top:18px;
  border-top:1px solid rgba(0,0,0,0.08);
  display:flex;
  flex-direction:column;
  gap:8px;
}

.detail-row{
  display:flex;
  justify-content:space-between;
  font-size:13px;
}

.label{
  opacity:.6;
}

</style>