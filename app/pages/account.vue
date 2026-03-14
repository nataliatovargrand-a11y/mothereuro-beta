<template>

<div class="account-wrapper">

<!-- LOADING -->

<div v-if="loading" class="loading">
Loading your account...
</div>

<div v-else>

<!-- HEADER -->

<div class="account-header">

<h1 class="greeting">
Hi, {{ member?.name || 'Member' }}
</h1>

<div class="welcome">
Welcome back to Mother Euro
</div>

<button class="logout-btn" @click="logout">
Log Out
</button>

</div>


<!-- PROFILE -->

<div class="section">

<div class="section-header">

<h2>Profile</h2>

<button v-if="!editing" @click="startEdit" class="edit-btn">
Edit Profile
</button>

</div>

<div class="profile-card">

<div class="avatar-block">

<img
v-if="member?.avatar_url"
:src="member.avatar_url"
class="avatar"
/>

<div v-else class="avatar-placeholder"></div>

<input
type="file"
class="file-input"
@change="uploadAvatar"
/>

</div>

<div class="profile-info">

<!-- VIEW MODE -->

<div v-if="!editing">

<div><strong>Name:</strong> {{ member?.name }}</div>
<div><strong>Email:</strong> {{ member?.email }}</div>
<div><strong>Membership:</strong> {{ member?.membership_tier }}</div>
<div><strong>Renewal:</strong> {{ member?.renewal_date || '—' }}</div>
<div><strong>Industry:</strong> {{ member?.industry || '—' }}</div>
<div><strong>City:</strong> {{ member?.city || '—' }}</div>

</div>

<!-- EDIT MODE -->

<div v-else class="edit-fields">

<input v-model="name" placeholder="Name" />
<input v-model="city" placeholder="City" />
<input v-model="industry" placeholder="Industry" />

<div class="edit-actions">

<button @click="saveProfile" class="save-btn">
Save
</button>

<button @click="cancelEdit" class="cancel-btn">
Cancel
</button>

</div>

</div>

</div>

</div>

</div>


<!-- MEMBERSHIP -->

<div class="section">

<h2>Your Membership</h2>

<div class="membership-card">

<div class="membership-row">

<div class="membership-item">
<div class="label">Tier</div>
<div class="value">{{ member?.membership_tier }}</div>
</div>

<div class="membership-item">
<div class="label">Renewal</div>
<div class="value">{{ member?.renewal_date || '—' }}</div>
</div>

<div v-if="member?.membership_tier === 'global'" class="membership-item">
<div class="label">Events Remaining</div>
<div class="value">{{ remainingEvents }} / 4</div>
</div>

</div>

</div>

</div>


<!-- EVENTS -->

<div class="section">

<h2>Your Upcoming Events</h2>

<div v-if="upcomingEvents.length === 0" class="empty">
No upcoming events yet.
</div>

<div v-for="event in upcomingEvents" :key="event.id" class="event-card">

<div class="event-title">
{{ event.event_title }}
</div>

<div class="event-date">
{{ formatDate(event.event_date) }}
</div>

</div>

</div>


<!-- BENEFITS -->

<div class="section">

<h2>Your Membership Benefits</h2>

<div class="benefits-card">

<div v-if="member?.membership_tier === 'aspiring'">
• Community events<br>
• Relocation resources<br>
• Member introductions
</div>

<div v-if="member?.membership_tier === 'resident'">
• Full resource library<br>
• Unlimited events<br>
• Partner benefits
</div>

<div v-if="member?.membership_tier === 'global'">
• Exclusive member dinners<br>
• Global network access<br>
• Partner privileges<br>
• Up to 4 events per year
</div>

</div>

</div>

</div>

</div>

</template>


<script setup>

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { supabase } from '~/utils/supabase'

const router = useRouter()

const member = ref(null)
const user = ref(null)

const loading = ref(true)
const editing = ref(false)

const name = ref('')
const city = ref('')
const industry = ref('')

const upcomingEvents = ref([])
const remainingEvents = ref(4)



onMounted(async () => {

const { data:{ session } } = await supabase.auth.getSession()

if(!session){
router.push('/login')
return
}

user.value = session.user

const { data, error } = await supabase
.from('members')
.select('*')
.eq('id', user.value.id)
.single()

if(error){
console.error(error)
}

member.value = data

name.value = data?.name
city.value = data?.city
industry.value = data?.industry

loading.value = false

})


const startEdit = () => {
editing.value = true
}

const cancelEdit = () => {
editing.value = false
}

const saveProfile = async () => {

await supabase
.from('members')
.update({
name:name.value,
city:city.value,
industry:industry.value
})
.eq('id',user.value.id)

member.value.name = name.value
member.value.city = city.value
member.value.industry = industry.value

editing.value = false

}


const uploadAvatar = async (event) => {

const file = event.target.files[0]

if(!file) return

const filePath = `${user.value.id}/${file.name}`

await supabase.storage
.from('avatars')
.upload(filePath,file,{upsert:true})

const { data } = supabase.storage
.from('avatars')
.getPublicUrl(filePath)

await supabase
.from('members')
.update({ avatar_url:data.publicUrl })
.eq('id',user.value.id)

member.value.avatar_url = data.publicUrl

}


const logout = async () => {

await supabase.auth.signOut()

router.push('/login')

}


const formatDate = (date) => {
return new Date(date).toLocaleDateString()
}

</script>