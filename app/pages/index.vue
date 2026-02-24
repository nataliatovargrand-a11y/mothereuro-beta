<template>
  <div class="home">
    <img src="/logome.png" class="logo" />

    <h1>Embrace. Connect. Thrive.</h1>

    <p>
      A curated community for women building life across Europe.
    </p>

    <button class="primary-btn">
      Join the Community
    </button>
  </div>
</template>

<style scoped>
.home {
  text-align: center;
}

.logo {
  width: 120px;
  margin-bottom: 30px;
}

p {
  font-weight: 300;
  margin: 20px 0 40px;
}

.primary-btn {
  background: var(--me-dark);
  color: white;
  border: none;
  padding: 14px 28px;
  letter-spacing: 2px;
  font-size: 12px;
  text-transform: uppercase;
  cursor: pointer;
}

.primary-btn:hover {
  background: var(--me-gold);
}
</style>
