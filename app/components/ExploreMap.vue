<template>

<div ref="mapContainer" class="map"></div>

</template>

<script setup>

import { ref, onMounted } from 'vue'
import mapboxgl from 'mapbox-gl'
import { supabase } from '~/utils/supabase'

const mapContainer = ref(null)

mapboxgl.accessToken = 'YOUR_MAPBOX_PUBLIC_KEY'

onMounted(async () => {

const map = new mapboxgl.Map({
container: mapContainer.value,
style: 'mapbox://styles/mapbox/light-v11',
center: [2.3522,48.8566],
zoom: 4
})

const { data } = await supabase
.from('resources')
.select('*')

data.forEach(resource => {

if(resource.latitude && resource.longitude){

new mapboxgl.Marker()
.setLngLat([resource.longitude, resource.latitude])
.setPopup(
new mapboxgl.Popup().setHTML(
`<strong>${resource.title}</strong><br>${resource.city}`
)
)
.addTo(map)

}

})

})

</script>

<style scoped>

.map{
width:100%;
height:500px;
border-radius:20px;
margin-bottom:60px;
}

</style>