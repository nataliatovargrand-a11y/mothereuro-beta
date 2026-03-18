<template>

<div class="account-wrapper">

  <div v-if="loading" class="loading">
    Loading your account...
  </div>

  <div v-else>

    <!-- PASSWORD FLOW -->

    <div v-if="needsPassword" class="password-wrapper">

      <div class="password-card">

        <div class="password-label">Private Access</div>

        <h2 class="password-title">Complete Your Access</h2>

        <p class="password-sub">
          Create your password to enter the Mother Euro platform
        </p>

        <input v-model="password" type="password" placeholder="Create password" class="password-input"/>
        <input v-model="confirmPassword" type="password" placeholder="Confirm password" class="password-input"/>

        <p v-if="passwordError" class="password-error">{{ passwordError }}</p>

        <button @click="setPassword" class="password-btn">
          ENTER THE PLATFORM
        </button>

      </div>

    </div>

    <!-- ACCOUNT CONTENT -->

    <div v-else>

      <!-- HEADER -->

      <div class="account-header">

        <div>
          <h1 class="greeting">Hi, {{ firstName }}</h1>
          <p class="welcome">Welcome back to Mother Euro</p>
        </div>

        <button class="logout-btn" @click="logout">
          Log Out
        </button>

      </div>

      <!-- PROFILE -->

      <div class="card">

        <div class="profile-top">
          <button v-if="!editing" @click="startEdit" class="edit-btn">
            Edit Profile
          </button>
        </div>

        <div class="profile-card">

          <div class="avatar-block">

            <img v-if="member?.avatar_url" :src="member.avatar_url" class="avatar"/>
            <div v-else class="avatar-placeholder"></div>

            <label class="upload-btn">
              Upload Photo
              <input type="file" @change="uploadAvatar" hidden />
            </label>

          </div>

          <div class="profile-info">

            <div v-if="!editing" class="profile-grid">

              <div><label>Name</label><span>{{ member?.name }}</span></div>
              <div><label>Email</label><span>{{ member?.email }}</span></div>
              <div><label>Membership</label><span>{{ member?.membership_tier }}</span></div>
              <div><label>Renewal</label><span>{{ member?.renewal_date }}</span></div>
              <div><label>Industry</label><span>{{ member?.industry }}</span></div>
              <div><label>City</label><span>{{ member?.city }}</span></div>

            </div>

            <div v-else class="edit-form">

              <input v-model="name" placeholder="Name" />
              <input v-model="city" placeholder="City" />
              <input v-model="industry" placeholder="Industry" />

              <div class="edit-actions">
                <button @click="saveProfile" class="save-btn">Save</button>
                <button @click="cancelEdit" class="cancel-btn">Cancel</button>
              </div>

            </div>

          </div>

        </div>

      </div>

      <!-- SAVED -->

      <div class="card">

        <h2 class="section-title">Saved Resources</h2>

        <div v-if="!safeSavedResources.length" class="empty">
          No saved resources yet.
        </div>

        <div
          v-for="resource in safeSavedResources"
          :key="resource.id"
          class="resource-card"
        >
          <div>{{ resource.title }}</div>
          <div>
            <a :href="resource.link_url" target="_blank" class="view-btn">View</a>
            <button @click="removeSaved(resource.id)" class="remove-btn">Remove</button>
          </div>
        </div>

      </div>

      <!-- EVENTS -->

      <div class="card">

        <h2 class="section-title">Your Upcoming Events</h2>

        <div v-if="!safeEvents.length" class="empty">
          No upcoming events yet.
        </div>

        <div
          v-for="event in safeEvents"
          :key="event.id"
          class="event-card"
        >
          <div>{{ event.event_title }}</div>
          <div class="event-date">{{ formatDate(event.event_date) }}</div>
        </div>

      </div>

    </div>

  </div>

</div>

</template>

<script setup>

import { ref, computed, onMounted } from 'vue'
import { supabase } from '~/utils/supabase'
import { useRouter } from 'vue-router'

const router = useRouter()

const loading = ref(true)
const member = ref(null)
const user = ref(null)

const editing = ref(false)

const name = ref('')
const city = ref('')
const industry = ref('')

const savedResources = ref([])
const upcomingEvents = ref([])

const needsPassword = ref(false)
const password = ref('')
const confirmPassword = ref('')
const passwordError = ref('')

const safeSavedResources = computed(() => savedResources.value || [])
const safeEvents = computed(() => upcomingEvents.value || [])

const firstName = computed(() => {
  if (!member.value?.name) return 'Member'
  return member.value.name.split(' ')[0]
})

onMounted(async () => {

  const hash = window.location.hash

  // Restore session from email link
  if (hash.includes('access_token')) {
    await supabase.auth.exchangeCodeForSession(window.location.href)
  }

  const { data:{ session } } = await supabase.auth.getSession()

  if (!session) {
    router.push('/login')
    return
  }

  user.value = session.user

  // Decide if password screen should show
  if (
    hash.includes('type=invite') ||
    hash.includes('type=recovery') ||
    !session.user.user_metadata?.password_set
  ) {
    needsPassword.value = true
  }

  // Load profile
  const { data } = await supabase
    .from('members')
    .select('*')
    .eq('id', user.value.id)
    .single()

  member.value = data

  name.value = data?.name
  city.value = data?.city
  industry.value = data?.industry

  const { data: saved } = await supabase
    .from('saved_resources')
    .select(`resources (*)`)
    .eq('member_id', user.value.id)

  savedResources.value = saved?.map(s => s.resources) || []

  loading.value = false

})

const setPassword = async () => {

  passwordError.value = ''

  if (!password.value || !confirmPassword.value) {
    passwordError.value = 'Please fill both fields'
    return
  }

  if (password.value !== confirmPassword.value) {
    passwordError.value = 'Passwords do not match'
    return
  }

  if (password.value.length < 6) {
    passwordError.value = 'Password must be at least 6 characters'
    return
  }

  const { error } = await supabase.auth.updateUser({
    password: password.value,
    data: { password_set: true }
  })

  if (error) {
    passwordError.value = error.message
    return
  }

  needsPassword.value = false
  password.value = ''
  confirmPassword.value = ''

  window.history.replaceState({}, document.title, window.location.pathname)

}

const removeSaved = async(id)=>{
  await supabase
    .from('saved_resources')
    .delete()
    .eq('resource_id', id)
    .eq('member_id', user.value.id)

  savedResources.value =
    safeSavedResources.value.filter(r=>r.id!==id)
}

const startEdit = ()=> editing.value=true
const cancelEdit = ()=> editing.value=false

const saveProfile = async ()=>{
  await supabase
    .from('members')
    .update({
      name:name.value,
      city:city.value,
      industry:industry.value
    })
    .eq('id',user.value.id)

  member.value.name=name.value
  member.value.city=city.value
  member.value.industry=industry.value

  editing.value=false
}

const uploadAvatar = async(e)=>{
  const file=e.target.files[0]
  if(!file) return

  const path=`${user.value.id}/${file.name}`

  await supabase.storage.from('avatars').upload(path,file,{upsert:true})

  const { data } =
    supabase.storage.from('avatars').getPublicUrl(path)

  await supabase
    .from('members')
    .update({avatar_url:data.publicUrl})
    .eq('id',user.value.id)

  member.value.avatar_url=data.publicUrl
}

const logout = async()=>{
  await supabase.auth.signOut()
  router.push('/login')
}

const formatDate=(d)=>{
  return new Date(d).toLocaleDateString()
}

</script>