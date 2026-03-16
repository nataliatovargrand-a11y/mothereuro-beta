<template>
  <div ref="mapContainer" class="map"></div>
</template>

<script setup>

import { ref, onMounted, watch } from "vue"
import mapboxgl from "mapbox-gl"

const props = defineProps({
  resources: Array,
  partners: Array
})

const mapContainer = ref(null)
let map
let markers = []

function clearMarkers() {
  markers.forEach(m => m.remove())
  markers = []
}

function drawMarkers() {

  if (!map) return

  clearMarkers()

  /* RESOURCES */

  props.resources?.forEach(resource => {

    if (!resource.latitude || !resource.longitude) return

    const el = document.createElement("div")
    el.className = "resource-pin"

    const marker = new mapboxgl.Marker(el)
      .setLngLat([resource.longitude, resource.latitude])
      .addTo(map)

    markers.push(marker)

  })

  /* PARTNERS */

  props.partners?.forEach(partner => {

    if (!partner.latitude || !partner.longitude) return

    const el = document.createElement("div")
    el.className = "partner-pin"

    const marker = new mapboxgl.Marker(el)
      .setLngLat([partner.longitude, partner.latitude])
      .addTo(map)

    markers.push(marker)

  })

}

onMounted(() => {

  mapboxgl.accessToken = useRuntimeConfig().public.mapboxToken

  map = new mapboxgl.Map({
    container: mapContainer.value,
    style: "mapbox://styles/mapbox/light-v11",
    center: [10, 50],
    zoom: 3
  })

  map.on("load", () => {
    drawMarkers()
  })

})

/* react when data arrives */

watch(
  () => [props.resources, props.partners],
  () => drawMarkers(),
  { deep: true }
)

</script>

<style scoped>

.map{
  width:100%;
  height:420px;
  border-radius:16px;
}

/* resources */

.resource-pin{
  width:10px;
  height:10px;
  background:black;
  border-radius:50%;
  border:2px solid white;
}

/* partners */

.partner-pin{
  width:14px;
  height:14px;
  background:#A8985F;
  border-radius:50%;
  border:2px solid white;
  box-shadow:0 0 8px rgba(168,152,95,0.4);
}

</style>