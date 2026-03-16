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

function updateMap() {
  if (!map) return

  const features = []

  props.resources?.forEach(r => {
    if (r.latitude && r.longitude) {
      features.push({
        type: "Feature",
        properties: { type: "resource" },
        geometry: {
          type: "Point",
          coordinates: [r.longitude, r.latitude]
        }
      })
    }
  })

  props.partners?.forEach(p => {
    if (p.latitude && p.longitude) {
      features.push({
        type: "Feature",
        properties: { 
  type: "partner",
  name: p.name
},
        geometry: {
          type: "Point",
          coordinates: [p.longitude, p.latitude]
        }
      })
    }
  })

  const geojson = {
    type: "FeatureCollection",
    features
  }

  if (map.getSource("locations")) {
    map.getSource("locations").setData(geojson)
  } else {
    map.addSource("locations", {
      type: "geojson",
      data: geojson
    })

map.addLayer({
  id: "partner-dots",
  type: "circle",
  source: "locations",
  filter: ["==", ["get", "type"], "partner"],
  paint: {
    "circle-radius": 7,
    "circle-color": "#A8985F"
  }
})
map.on("click", "partner-dots", (e) => {

const coordinates = e.features[0].geometry.coordinates.slice()
const name = e.features[0].properties.name

new mapboxgl.Popup()
.setLngLat(coordinates)
.setHTML(`<strong>${name}</strong>`)
.addTo(map)

})

    map.addLayer({
      id: "partner-dots",
      type: "circle",
      source: "locations",
      filter: ["==", ["get", "type"], "partner"],
      paint: {
        "circle-radius": 7,
        "circle-color": "#A8985F"
      }
    })
  }
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
    updateMap()
  })
})

watch(() => [props.resources, props.partners], updateMap, { deep: true })
</script>

<style scoped>
.map{
  width:100%;
  height:420px;
  border-radius:16px;
}
</style>