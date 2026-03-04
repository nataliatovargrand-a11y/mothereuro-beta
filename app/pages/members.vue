<template>

  <div class="members-wrapper">

    <div class="members-header">
      <h1>Members</h1>
      <p class="members-subtitle">
        Women building life and business across Europe
      </p>
    </div>
<div class="search-bar">
  <input
    v-model="searchQuery"
    placeholder="Search members..."
    class="search-input"
  />
</div>

    <!-- FILTERS -->

    <div class="filters">

      <div class="filter-group">

        <div class="filter-title">City</div>

        <button
          class="filter-pill"
          :class="{ active: selectedCity === 'All' }"
          @click="selectedCity = 'All'"
        >
          All
        </button>

        <button
          v-for="city in cities"
          :key="city"
          class="filter-pill"
          :class="{ active: selectedCity === city }"
          @click="selectedCity = city"
        >
          {{ city }}
        </button>

      </div>

      <div class="filter-group">

        <div class="filter-title">Industry</div>

        <button
          class="filter-pill"
          :class="{ active: selectedIndustry === 'All' }"
          @click="selectedIndustry = 'All'"
        >
          All
        </button>

        <button
          v-for="industry in industries"
          :key="industry"
          class="filter-pill"
          :class="{ active: selectedIndustry === industry }"
          @click="selectedIndustry = industry"
        >
          {{ industry }}
        </button>

      </div>

    </div>

    <!-- MEMBERS GRID -->

    <div class="members-grid">

      <div
        v-for="member in filteredMembers"
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

        <!-- EXPANDED -->

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

import { ref, onMounted, computed } from 'vue'
import { supabase } from '~/utils/supabase'

const members = ref([])
const members = ref([])
const expandedMember = ref(null)
const selectedCity = ref("All")
const selectedIndustry = ref("All")
const searchQuery = ref("")
const expandedMember = ref(null)

const selectedCity = ref("All")
const selectedIndustry = ref("All")

onMounted(async () => {

  const { data } = await supabase
    .from('members')
    .select('*')

  members.value = data || []

})

const toggleMember = (id) => {

  if (expandedMember.value === id) {
    expandedMember.value = null
  } else {
    expandedMember.value = id
  }

}

const cities = computed(() => {

  const unique = [...new Set(members.value.map(m => m.city).filter(Boolean))]
  return unique.sort()

})

const industries = computed(() => {

  const unique = [...new Set(members.value.map(m => m.industry).filter(Boolean))]
  return unique.sort()

})

const filteredMembers = computed(() => {

  return members.value.filter(member => {

    const cityMatch =
      selectedCity.value === "All" || member.city === selectedCity.value

    const industryMatch =
      selectedIndustry.value === "All" || member.industry === selectedIndustry.value

    const searchMatch =
      member.first_name?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      member.city?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      member.industry?.toLowerCase().includes(searchQuery.value.toLowerCase())

    return cityMatch && industryMatch && searchMatch

  })

})

  return members.value.filter(member => {

    const cityMatch =
      selectedCity.value === "All" || member.city === selectedCity.value

    const industryMatch =
      selectedIndustry.value === "All" || member.industry === selectedIndustry.value

    return cityMatch && industryMatch

  })

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

/* FILTERS */

.filters{
  margin-bottom:50px;
  display:flex;
  flex-direction:column;
  gap:20px;
}

.filter-group{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  align-items:center;
}

.filter-title{
  margin-right:10px;
  font-size:12px;
  letter-spacing:1px;
  opacity:.6;
}

.filter-pill{
  border:1px solid rgba(0,0,0,0.15);
  background:white;
  padding:6px 14px;
  border-radius:20px;
  font-size:12px;
  letter-spacing:1px;
  cursor:pointer;
}

.filter-pill.active{
  background:black;
  color:white;
  border-color:black;
}
/* SEARCH */

.search-bar{
  margin-bottom:30px;
}

.search-input{
  width:100%;
  padding:12px 16px;
  border-radius:12px;
  border:1px solid rgba(0,0,0,0.15);
  font-size:14px;
}

.search-input:focus{
  outline:none;
  border-color:black;
}/* SEARCH */

.search-bar{
  margin-bottom:30px;
}

.search-input{
  width:100%;
  padding:12px 16px;
  border-radius:12px;
  border:1px solid rgba(0,0,0,0.15);
  font-size:14px;
}

.search-input:focus{
  outline:none;
  border-color:black;
}
</style>