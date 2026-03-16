<template>

<div ref="mapContainer" class="map"></div>

</template>

<script setup>

import { onMounted, ref, watch } from 'vue'
import mapboxgl from 'mapbox-gl'

const props = defineProps({
resources: Array,
partners: Array
})

const emit = defineEmits(['citySelected'])

const mapContainer = ref(null)
let map = null

onMounted(() => {

mapboxgl.accessToken = useRuntimeConfig().public.mapboxToken

map = new mapboxgl.Map({
container: mapContainer.value,
style: 'mapbox://styles/mapbox/light-v11',
center: [10,50],
zoom: 3
})

map.on('load', () => {
renderMarkers()
})

})


const renderMarkers = () => {

if(!map) return

/* RESOURCES */

props.resources?.forEach(resource => {

if(!resource.latitude || !resource.longitude) return

const el = document.createElement('div')
el.className = 'resource-marker'

new mapboxgl.Marker(el)
.setLngLat([resource.longitude, resource.latitude])
.addTo(map)

})


/* PARTNERS */

props.partners?.forEach(partner => {

if(!partner.latitude || !partner.longitude) return

const el = document.createElement('div')
el.className = 'partner-marker'

new mapboxgl.Marker(el)
.setLngLat([partner.longitude, partner.latitude])
.addTo(map)

})

}


/* WATCH FOR DATA UPDATES */

watch(
() => [props.resources, props.partners],
() => {
renderMarkers()
}
)

</script>

<style scoped>

.map{
width:100%;
height:420px;
border-radius:16px;
}


/* RESOURCE MARKERS */

.resource-marker{
width:10px;
height:10px;
background:black;
border-radius:50%;
border:2px solid white;
box-shadow:0 0 6px rgba(0,0,0,0.25);
}


/* PARTNER MARKERS */

.partner-marker{
width:14px;
height:14px;
background:#A8985F;
border-radius:50%;
border:2px solid white;
box-shadow:0 0 8px rgba(168,152,95,0.4);
}

</style>