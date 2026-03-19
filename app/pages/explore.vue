<template>

<div class="explore-wrapper">

  <!-- HERO -->

  <div class="explore-hero">

    <h1 class="page-title-main">
      EXPLORE
    </h1>

    <p class="page-subtitle">
      Discover trusted people, places, and resources across Europe.
    </p>

    <div class="search-elevated">

      <input
        v-model="search"
        @input="searchPlatform"
        type="text"
        placeholder="Search members, partners, or resources..."
        class="search-minimal"
      />

    </div>

  </div>


  <!-- SEARCH RESULTS -->

  <div v-if="search.length" class="search-results">

    <!-- MEMBERS -->

    <div v-if="membersResults.length" class="search-section">

      <div class="section-title">MEMBERS</div>

      <NuxtLink
        v-for="member in membersResults"
        :key="member.id"
        :to="'/members/' + member.id"
        class="search-result"
      >

        <div class="result-left">

          <img
            :src="member.avatar_url || '/avatar-placeholder.png'"
            class="avatar"
          />

          <div>

            <strong>{{ member.name }}</strong>

            <div class="result-meta">
              {{ member.city }} • {{ member.industry }}
            </div>

          </div>

        </div>

        <span class="result-type">Member</span>

      </NuxtLink>

    </div>


    <!-- RESOURCES -->

    <div v-if="resourcesResults.length" class="search-section">

      <div class="section-title">RESOURCES</div>

      <NuxtLink
        v-for="resource in resourcesResults"
        :key="resource.id"
        :to="'/resources/' + resource.slug"
        class="search-result"
      >

        <strong>{{ resource.title }}</strong>

        <span class="result-type">Resource</span>

      </NuxtLink>

    </div>


    <!-- PARTNERS -->

    <div v-if="partnersResults.length" class="search-section">

      <div class="section-title">PARTNERS</div>

      <a
        v-for="partner in partnersResults"
        :key="partner.id"
        :href="partner.website"
        target="_blank"
        class="search-result"
      >

        <strong>{{ partner.name }}</strong>

        <span class="result-type">Partner</span>

      </a>

    </div>

  </div>


  <!-- MAP -->

  <div class="map-section">

    <div class="section-title">
      DISCOVER EUROPE
    </div>

    <ExploreMap
      :resources="resources"
      :partners="partners"
    />

  </div>


  <!-- CATEGORY CAROUSEL -->

  <div class="category-carousel">

    <NuxtLink to="/resources/beauty" class="category-card beauty">
      <span>Beauty</span>
    </NuxtLink>

    <NuxtLink to="/resources/travel" class="category-card travel">
      <span>Travel</span>
    </NuxtLink>

    <NuxtLink to="/resources/gastronomy" class="category-card gastronomy">
      <span>Gastronomy</span>
    </NuxtLink>

    <NuxtLink to="/resources/wellness" class="category-card wellness">
      <span>Wellness</span>
    </NuxtLink>

    <NuxtLink to="/resources/education" class="category-card education">
      <span>Education</span>
    </NuxtLink>

    <NuxtLink to="/resources/real-estate" class="category-card realestate">
      <span>Real Estate</span>
    </NuxtLink>

    <NuxtLink
      v-if="member && member.membership_tier === 'aspiring'"
      to="/resources/relocation"
      class="category-card relocation"
    >
      <span>Relocation</span>
    </NuxtLink>

  </div>

</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'
import ExploreMap from '~/components/ExploreMap.vue'

const search = ref('')

const resources = ref([])
const partners = ref([])

const resourcesResults = ref([])
const partnersResults = ref([])
const membersResults = ref([])

const member = ref(null)

onMounted(async () => {

  const { data:{ session } } = await supabase.auth.getSession()

  if(session){

    const { data: memberData } = await supabase
      .from('members')
      .select('*')
      .eq('id', session.user.id)
      .single()

    member.value = memberData

  }

  const { data: resourcesData } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)

  resources.value = resourcesData || []

  const { data: partnersData } = await supabase
    .from('partners')
    .select('*')
    .eq('active', true)
    .not('latitude', 'is', null)
    .not('longitude', 'is', null)

  partners.value = partnersData || []

})


const searchPlatform = async () => {

  if(!search.value){

    resourcesResults.value = []
    partnersResults.value = []
    membersResults.value = []

    return

  }

  const { data: resourcesData } = await supabase
    .from('resources')
    .select('*')
    .ilike('title', `%${search.value}%`)
    .limit(6)

  const { data: partnersData } = await supabase
    .from('partners')
    .select('*')
    .ilike('name', `%${search.value}%`)
    .limit(6)

  const { data: membersData } = await supabase
    .from('members')
    .select('id,name,city,industry,avatar_url')
    .or(`name.ilike.%${search.value}%,city.ilike.%${search.value}%,industry.ilike.%${search.value}%`)
    .limit(6)

  resourcesResults.value = resourcesData || []
  partnersResults.value = partnersData || []
  membersResults.value = membersData || []

}

</script>


<style scoped>

/* KEEP YOUR EXISTING STYLES EXACTLY AS IS */

</style>