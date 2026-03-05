<template>
  <div class="map-wrapper">
    <div ref="mapContainer" class="map"></div>
  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'
import mapboxgl from 'mapbox-gl'
import { supabase } from '~/utils/supabase'

const emit = defineEmits(['citySelected'])

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

data?.forEach(resource => {

  if (!resource.latitude || !resource.longitude) return

  if (props.category && resource.category !== props.category) return

  const marker = new mapboxgl.Marker({ color: "#A8985F" })
    .setLngLat([resource.longitude, resource.latitude])
    .addTo(map)

  marker.getElement().addEventListener('click', () => {
    emit('citySelected', resource.city)
  })

})

const props = defineProps({
  category: String
})
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
.map-category-filters{
display:flex;
gap:12px;
margin-top:30px;
flex-wrap:wrap;
}

.map-category-filters button{
border:1px solid rgba(0,0,0,0.15);
background:white;
padding:8px 18px;
border-radius:20px;
font-size:12px;
letter-spacing:1px;
cursor:pointer;
}

.map-category-filters button.active{
background:black;
color:white;
border-color:black;
}

</style>