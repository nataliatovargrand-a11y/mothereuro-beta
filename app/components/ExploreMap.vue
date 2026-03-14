<template>

<div ref="mapContainer" class="map"></div>

</template>

<script setup>

import { onMounted, ref } from 'vue'
import mapboxgl from 'mapbox-gl'

const props = defineProps({
resources:Array
})

const emit = defineEmits(['citySelected'])

const mapContainer = ref(null)

onMounted(() => {

mapboxgl.accessToken = useRuntimeConfig().public.mapboxToken

const map = new mapboxgl.Map({
container: mapContainer.value,
style: 'mapbox://styles/mapbox/light-v11',
center: [10,50],
zoom: 3
})

props.resources?.forEach(resource => {

if(!resource.latitude) return

const el = document.createElement('div')
el.className = 'gold-pin'

new mapboxgl.Marker(el)
.setLngLat([resource.longitude, resource.latitude])
.addTo(map)

})

})

</script>

<style scoped>

.map{
width:100%;
height:420px;
border-radius:16px;
}

.gold-pin{
width:14px;
height:14px;
background:#A8985F;
border-radius:50%;
border:2px solid white;
box-shadow:0 0 6px rgba(0,0,0,0.3);
}

</style>