<template>
  <div class="partners-wrapper">

    <div class="hero">
      <h1>Trusted Partners</h1>
      <p>
        Strategic collaborators supporting the Mother Euro community
        across Europe.
      </p>
    </div>

    <!-- Community Partners -->
    <div class="section">
      <h2>Community Benefit Partners</h2>

      <div class="partners-grid">

        <div class="partner-card">
          <div class="partner-logo"></div>
          <h3>Relocation & Visa Services</h3>
          <p>Legal and residency support across Europe.</p>
          <span class="badge">Member Benefit</span>
        </div>

        <div class="partner-card">
          <div class="partner-logo"></div>
          <h3>Coworking Spaces</h3>
          <p>Curated workspaces in major European cities.</p>
          <span class="badge">Member Benefit</span>
        </div>

        <div class="partner-card">
          <div class="partner-logo"></div>
          <h3>Wellness & Therapy</h3>
          <p>Private mental health and wellness support.</p>
          <span class="badge">Member Benefit</span>
        </div>

      </div>
    </div>

    <!-- Brand Collaborators -->
    <div class="section">
      <h2>Brand Collaborations</h2>

      <div class="logo-grid">
        <div class="logo-placeholder"></div>
        <div class="logo-placeholder"></div>
        <div class="logo-placeholder"></div>
        <div class="logo-placeholder"></div>
      </div>
    </div>

    <!-- CTA -->
    <div class="cta">
      <h2>Become a Partner</h2>
      <p>
        Interested in collaborating with Mother Euro?
      </p>
      <button class="primary-btn">
        Apply to Partner
      </button>
    </div>

  </div>
</template>

<style scoped>

.partners-wrapper {
  max-width: 1100px;
  margin: 0 auto;
  padding: 120px 40px 140px;
}

.hero {
  text-align: center;
  margin-bottom: 100px;
}

.hero h1 {
  font-size: 42px;
  margin-bottom: 20px;
}

.hero p {
  max-width: 600px;
  margin: 0 auto;
  opacity: 0.7;
}

.section {
  margin-bottom: 100px;
}

.section h2 {
  font-size: 28px;
  margin-bottom: 40px;
}

.partners-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 40px;
}

.partner-card {
  background: white;
  padding: 40px;
  border-radius: 24px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

.partner-logo {
  width: 60px;
  height: 60px;
  background: #eee;
  margin-bottom: 20px;
}

.badge {
  font-size: 12px;
  letter-spacing: 2px;
  opacity: 0.6;
}

.logo-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 40px;
}

.logo-placeholder {
  height: 60px;
  background: #f2f2f2;
}

.cta {
  text-align: center;
  margin-top: 100px;
}

.primary-btn {
  margin-top: 20px;
  padding: 14px 28px;
  background: #A8985F;
  color: white;
  border: none;
  letter-spacing: 2px;
}

</style>