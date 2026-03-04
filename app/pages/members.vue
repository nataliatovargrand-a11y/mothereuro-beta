<template>
  <div class="members-wrapper">

    <h1>Members</h1>

    <div
      v-for="member in members"
      :key="member.id"
      class="member-card"
    >
      {{ member.first_name }}
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
    .select('id, first_name')

  members.value = data || []

})

</script>