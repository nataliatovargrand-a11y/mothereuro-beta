<template>
  <div class="page">

    <!-- HERO -->
    <section class="hero">
      <div class="hero-inner">
        <img src="/logome.png" class="logo" />

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
      </div>
    </section>

    <!-- VALUE PILLARS -->
    <section class="pillars">
      <div class="pillar">
        <h3>Community</h3>
        <p>Meaningful connection in every city.</p>
      </div>

      <div class="pillar">
        <h3>Wellness</h3>
        <p>Movement, mindfulness, and motherhood aligned.</p>
      </div>

      <div class="pillar">
        <h3>Growth</h3>
        <p>Business, creativity, and expansion abroad.</p>
      </div>
    </section>

    <!-- MEMBERSHIP POSITIONING -->
    <section class="membership">
      <h2>Not Just Events.</h2>
      <h2>A Private Network.</h2>

      <p>
        Mother Euro is a carefully cultivated space for
        women transitioning to life in Europe.
        We move intentionally. We gather thoughtfully.
        We build slowly.
      </p>
    </section>

    <!-- CTA -->
    <section class="cta">
      <button class="secondary-btn">
        View Upcoming Events
      </button>
    </section>

  </div>
</template>

<style scoped>
.page {
  display: flex;
  flex-direction: column;
}

/* HERO */
.hero {
  padding: 100px 20px 80px;
  text-align: center;
}

.hero-inner {
  max-width: 600px;
  margin: 0 auto;
}

.logo {
  width: 110px;
  margin-bottom: 40px;
}

.headline {
  font-size: 40px;
  line-height: 1.2;
}

.tagline {
  margin: 30px 0 40px;
  font-weight: 300;
  font-size: 16px;
}

/* PRIMARY BUTTON */
.primary-btn {
  background: var(--me-dark);
  color: white;
  border: none;
  padding: 14px 32px;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.primary-btn:hover {
  background: var(--me-gold);
}

/* PILLARS */
.pillars {
  display: flex;
  flex-direction: column;
  gap: 60px;
  padding: 80px 20px;
  text-align: center;
  background: white;
}

.pillar h3 {
  font-size: 22px;
  letter-spacing: 2px;
}

.pillar p {
  font-weight: 300;
  margin-top: 10px;
}

/* MEMBERSHIP */
.membership {
  padding: 100px 20px;
  text-align: center;
}

.membership h2 {
  font-size: 30px;
  margin: 0;
}

.membership p {
  max-width: 600px;
  margin: 40px auto 0;
  font-weight: 300;
}

/* CTA */
.cta {
  padding: 80px 20px 120px;
  text-align: center;
}

.secondary-btn {
  background: transparent;
  border: 1px solid var(--me-dark);
  padding: 14px 32px;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
  transition: 0.3s ease;
}

.secondary-btn:hover {
  background: var(--me-dark);
  color: white;
}
</style>
