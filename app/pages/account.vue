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

    <!-- PROFILE CARD -->

    <div class="card">

      <div class="profile-top">

        <button
          v-if="!editing"
          @click="startEdit"
          class="edit-btn"
        >
          Edit Profile
        </button>

      </div>

      <div class="profile-card">

        <!-- AVATAR -->

        <div class="avatar-block">

          <img
            v-if="member?.avatar_url"
            :src="member.avatar_url"
            class="avatar"
          />

          <div v-else class="avatar-placeholder"></div>

          <label class="upload-btn">
            Upload Photo
            <input type="file" @change="uploadAvatar" hidden />
          </label>

        </div>

        <!-- INFO -->

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

      <div v-if="savedResources.length === 0" class="empty">
        No saved resources yet.
      </div>

      <div v-for="resource in savedResources" :key="resource.id" class="resource-card">
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

      <div v-if="upcomingEvents.length === 0" class="empty">
        No upcoming events yet.
      </div>

      <div v-for="event in upcomingEvents" :key="event.id" class="event-card">
        <div>{{ event.event_title }}</div>
        <div class="event-date">{{ formatDate(event.event_date) }}</div>
      </div>

    </div>

  </div>

</div>

</template>


<style scoped>

.account-wrapper{
padding:120px 24px;
max-width:900px;
margin:auto;
}

/* HEADER */

.account-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:60px;
}

.greeting{
font-size:44px;
}

.welcome{
opacity:.6;
}

/* CARD */

.card{
background:white;
border-radius:20px;
padding:30px;
margin-bottom:30px;
box-shadow:0 10px 30px rgba(0,0,0,0.04);
}

/* PROFILE */

.profile-top{
display:flex;
justify-content:flex-start;
margin-bottom:20px;
}

.profile-card{
display:flex;
gap:40px;
}

.avatar{
width:110px;
height:110px;
border-radius:50%;
object-fit:cover;
}

.avatar-placeholder{
width:110px;
height:110px;
border-radius:50%;
background:#eee;
}

.avatar-block{
display:flex;
flex-direction:column;
align-items:center;
gap:10px;
}

.profile-info{
flex:1;
}

.profile-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

label{
font-size:11px;
letter-spacing:2px;
opacity:.5;
text-transform:uppercase;
}

span{
font-size:16px;
}

/* BUTTONS */

.logout-btn{
padding:10px 18px;
border-radius:999px;
background:white;
border:1px solid rgba(0,0,0,0.1);
}

.edit-btn{
border:1px solid rgba(0,0,0,0.1);
padding:8px 14px;
border-radius:999px;
background:white;
}

.upload-btn{
font-size:12px;
border:1px solid rgba(0,0,0,0.1);
padding:6px 12px;
border-radius:999px;
cursor:pointer;
}

.save-btn{
background:black;
color:white;
padding:10px 16px;
border-radius:10px;
border:none;
}

.section-title{
font-size:28px;
margin-bottom:20px;
}

.resource-card{
display:flex;
justify-content:space-between;
padding:16px 0;
border-top:1px solid rgba(0,0,0,0.05);
}

.view-btn{
background:black;
color:white;
padding:6px 12px;
border-radius:6px;
text-decoration:none;
margin-right:8px;
}

.remove-btn{
color:#c33;
background:none;
border:none;
}

.event-card{
padding:16px 0;
border-top:1px solid rgba(0,0,0,0.05);
}

.event-date{
opacity:.6;
font-size:14px;
}

/* PASSWORD */

.password-card{
text-align:center;
max-width:400px;
margin:auto;
}

.password-input{
width:100%;
padding:14px;
margin-bottom:12px;
border-radius:10px;
border:1px solid rgba(0,0,0,0.1);
}

.password-btn{
background:#A8985F;
color:white;
padding:14px;
border-radius:999px;
width:100%;
border:none;
}

.password-error{
color:#c33;
margin-bottom:10px;
}

/* MOBILE */

@media (max-width:768px){
.profile-card{
flex-direction:column;
align-items:center;
text-align:center;
}
.profile-grid{
grid-template-columns:1fr;
}
}
</style>