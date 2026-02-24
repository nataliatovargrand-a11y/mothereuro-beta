<template>
  <div class="page">

    <section class="hero">
     <img src="/logo.png" class="logo" />

      <h1 class="headline">
        Mindful Motherhood<br />
        Across Europe
      </h1>

      <p class="tagline">
        A curated community supporting women building
        life, business, and belonging abroad.
      </p>

      <button class="primary-btn">
        Explore Membership
      </button>
    </section>

    <section class="pillars">
      <div>
        <h3>Community</h3>
        <p>Meaningful connection in every city.</p>
      </div>

      <div>
        <h3>Wellness</h3>
        <p>Movement, mindfulness, and motherhood aligned.</p>
      </div>

      <div>
        <h3>Growth</h3>
        <p>Business, creativity, and expansion abroad.</p>
      </div>
    </section>

  </div>
</template>

<style>
.page {
  display: flex;
  flex-direction: column;
  background: #FAF3EA;
}

/* HERO */
.hero {
  padding: 100px 20px 80px;
  text-align: center;
}

.logo {
  width: 110px;
  margin-bottom: 40px;
}

.headline {
  font-family: 'Playfair Display', serif;
  font-size: 40px;
  line-height: 1.2;
}

.tagline {
  margin: 30px 0 40px;
  font-weight: 300;
  font-family: 'Inter', sans-serif;
}

.primary-btn {
  background: #2E2B29;
  color: white;
  border: none;
  padding: 14px 32px;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
}

/* PILLARS */
.pillars {
  background: white;
  padding: 80px 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 60px;
}

.pillars h3 {
  font-family: 'Playfair Display', serif;
  font-size: 22px;
  letter-spacing: 2px;
}

.pillars p {
  font-family: 'Inter', sans-serif;
  font-weight: 300;
  margin-top: 10px;
}
</style>
