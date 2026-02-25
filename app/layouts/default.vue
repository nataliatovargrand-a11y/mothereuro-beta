<template>
  <div>

    <!-- Top Greeting Bar -->
    <div v-if="user && firstName" class="member-bar">
      Hi, {{ firstName }}
    </div>

    <NuxtPage />

  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'

const user = ref(null)
const firstName = ref(null)

onMounted(async () => {

  const { data } = await supabase.auth.getUser()

  if (data.user) {

    user.value = data.user

    const { data: member } = await supabase
      .from('members')
      .select('first_name')
      .eq('email', data.user.email)
      .single()

    firstName.value = member?.first_name

  }

})

</script>

<style scoped>

.member-bar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: #FAF3EA;
  border-bottom: 1px solid #E5DCD2;
  padding: 16px 40px;
  font-size: 15px;
  letter-spacing: 1px;
  z-index: 1000;
}

@media (max-width: 768px) {
  .member-bar {
    padding: 14px 20px;
  }
}

</style>