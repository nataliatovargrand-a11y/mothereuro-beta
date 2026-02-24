<template>
  <div>

    <section class="me-container hero">

      <img src="/images/logo.png" class="logo" />

      <h1 class="headline">
        Mindful Motherhood<br />
        Across Europe
      </h1>

      <p class="subtitle">
        A curated community supporting women building
        life, business, and belonging abroad.
      </p>

      <button class="me-button">
        Explore Membership
      </button>

    </section>

  </div>
</template>

<style scoped>

.hero {
  text-align: center;
}

.logo {
  width: 110px;
  margin-bottom: 40px;
}

.headline {
  font-size: 42px;
  line-height: 1.2;
  margin-bottom: 30px;
}

.subtitle {
  font-weight: 300;
  max-width: 500px;
  margin: 0 auto 40px;
  color: var(--me-muted);
}

@media (max-width: 768px) {
  .headline {
    font-size: 32px;
  }
}

</style>
