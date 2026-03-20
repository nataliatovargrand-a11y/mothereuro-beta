<template>

  <div class="members-wrapper">

    <div class="members-header">
      <h1>Members</h1>
      <p class="members-subtitle">
        Women building life and business across Europe
      </p>
    </div>

    <!-- SEARCH -->

    <div class="search-bar">
      <input
        v-model="searchQuery"
        placeholder="Search members..."
        class="search-input"
      />
    </div>

    <!-- MEMBERS GRID -->

    <div class="members-grid">

      <NuxtLink
        v-for="member in filteredMembers"
        :key="member.id"
        :to="'/members/' + member.id"
        class="member-card"
        v-if="member.first_name"
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

        <div v-if="member.industry" class="member-meta">
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

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const members = ref([])
const searchQuery = ref("")

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('*')
    .not('first_name', 'is', null)
    .not('first_name', 'eq', '')

  members.value = data || []

})


const filteredMembers = computed(() => {

  // no search → show all
  if (!searchQuery.value) {
    return members.value
  }

  const query = searchQuery.value.toLowerCase()

  const results = members.value.filter(member =>
    member.first_name?.toLowerCase().includes(query)
  )

  // exact match → ONLY that person
  const exactMatch = results.find(m =>
    m.first_name?.toLowerCase() === query
  )

  if (exactMatch) {
    return [exactMatch]
  }

  // otherwise → show best match ONLY
  return results.slice(0, 1)

})

</script>


<style scoped>

.members-wrapper{
  padding:120px 40px 140px;
  max-width:1100px;
  margin:0 auto;
}

.members-header{
  margin-bottom:40px;
}

.members-header h1{
  font-size:40px;
  letter-spacing:2px;
  margin-bottom:10px;
}

.members-subtitle{
  opacity:.6;
}


/* SEARCH */

.search-bar{
  margin-bottom:30px;
}

.search-input{
  width:100%;
  border:none;
  border-bottom:1px solid rgba(0,0,0,0.2);
  padding:14px 0;
  font-size:16px;
  background:transparent;
}

.search-input:focus{
  outline:none;
  border-bottom:1px solid #A8985F;
}


/* GRID */

.members-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
  gap:24px;
  margin-top:40px;
}


/* CARD */

.member-card{
  background:white;
  border-radius:20px;
  padding:28px 20px;
  text-align:center;
  box-shadow:0 10px 30px rgba(0,0,0,0.04);
  transition:transform .2s ease, box-shadow .2s ease;
  text-decoration:none;
  color:inherit;
}

.member-card:hover{
  transform:translateY(-4px);
  box-shadow:0 20px 40px rgba(0,0,0,0.06);
}


/* AVATAR */

.member-avatar{
  width:80px;
  height:80px;
  border-radius:50%;
  object-fit:cover;
  margin:0 auto 14px;
}

.member-avatar-placeholder{
  width:80px;
  height:80px;
  border-radius:50%;
  background:#eee;
  margin:0 auto 14px;
}


/* TEXT */

.member-name{
  font-size:16px;
  margin-bottom:6px;
}

.member-meta{
  font-size:13px;
  opacity:.7;
}

.member-city{
  font-size:11px;
  letter-spacing:2px;
  text-transform:uppercase;
  opacity:.5;
  margin-top:6px;
}


/* MOBILE */

@media (max-width:768px){

  .members-wrapper{
    padding:100px 20px 120px;
  }

  .members-header h1{
    font-size:30px;
  }

}

</style>