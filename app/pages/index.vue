<template>
  <section class="hero">
    <div class="hero-inner">
      <img src="/logome.png" class="logo" />

      <h1 class="headline">
        Embrace.<br />
        Connect.<br />
        Thrive.
      </h1>

      <p class="tagline">
        A curated community for women building life across Europe.
      </p>

      <button class="primary-btn">
        Join the Community
      </button>
    </div>
  </section>

  <section class="about">
    <h2>Why Mother Euro</h2>
    <p>
      We bring together women navigating motherhood, career,
      and life transitions across Europe.
    </p>
  </section>
</template>

<style scoped>
.hero {
  background: var(--me-bg);
  padding: 80px 20px;
  text-align: center;
}

.hero-inner {
  max-width: 500px;
  margin: 0 auto;
}

.logo {
  width: 120px;
  margin-bottom: 40px;
}

.headline {
  font-size: 40px;
  line-height: 1.2;
  margin: 0;
}

.tagline {
  margin: 30px 0 40px;
  font-weight: 300;
  font-size: 16px;
}

.primary-btn {
  background: var(--me-dark);
  color: white;
  border: none;
  padding: 14px 32px;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s ease;
}

.primary-btn:hover {
  background: var(--me-gold);
}

.about {
  padding: 60px 20px;
  text-align: center;
  background: white;
}

.about h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

.about p {
  max-width: 500px;
  margin: 0 auto;
  font-weight: 300;
}
</style>
