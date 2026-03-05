<template>
  <div class="map-wrapper">
    <div ref="mapContainer" class="map"></div>
  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'
import mapboxgl from 'mapbox-gl'
import { supabase } from '~/utils/supabase'

const mapContainer = ref(null)
const config = useRuntimeConfig()

onMounted(async () => {

  mapboxgl.accessToken = config.public.mapboxToken

  const map = new mapboxgl.Map({
    container: mapContainer.value,
    style: 'mapbox://styles/mapbox/light-v11',
    center: [10, 48],
    zoom: 3
  })

  map.addControl(new mapboxgl.NavigationControl())

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)

  if (!data) return

  data.forEach(resource => {

    if (!resource.latitude || !resource.longitude) return

    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(`
      <strong>${resource.title}</strong><br/>
      ${resource.city || ''}
    `)

    new mapboxgl.Marker({ color: "#A8985F" })
      .setLngLat([resource.longitude, resource.latitude])
      .setPopup(popup)
      .addTo(map)

  })

})

</script>

<style scoped>

.map-wrapper{
  width:100%;
  margin-bottom:140px;
}

.map{
  width:100%;
  height:420px;
  border-radius:20px;
}

</style>