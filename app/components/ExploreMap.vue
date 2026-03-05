<template>
  <div ref="mapContainer" class="explore-map"></div>
</template>

<script setup>

import { ref, onMounted } from 'vue'
import mapboxgl from 'mapbox-gl'

const mapContainer = ref(null)

const config = useRuntimeConfig()

onMounted(() => {

  mapboxgl.accessToken = config.public.mapboxToken

  const map = new mapboxgl.Map({
    container: mapContainer.value,
    style: 'mapbox://styles/mapbox/light-v11',
    center: [10, 48],
    zoom: 3.5
  })

})

</script>

<style scoped>

.explore-map{
width:100%;
height:420px;
border-radius:20px;
margin-bottom:140px;
}

</style>