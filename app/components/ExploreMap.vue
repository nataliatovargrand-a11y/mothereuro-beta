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
const props = defineProps({
  category: String
})

const mapContainer = ref(null)
const config = useRuntimeConfig()

onMounted(async () => {

  mapboxgl.accessToken = config.public.mapboxToken

  const map = new mapboxgl.Map({
    container: mapContainer.value,
    style: 'mapbox://styles/mapbox/light-v11',
    center: [10,48],
    zoom: 3
  })

  map.addControl(new mapboxgl.NavigationControl())

  const { data } = await supabase
    .from('resources')
    .select('*')
    .eq('active', true)

  const features = data
    ?.filter(r => r.latitude && r.longitude)
    .filter(r => !props.category || r.category === props.category)
    .map(r => ({
      type: "Feature",
      properties: {
        title: r.title,
        city: r.city
      },
      geometry: {
        type: "Point",
        coordinates: [r.longitude, r.latitude]
      }
    }))

  map.on('load', () => {

    map.addSource('resources', {
      type: 'geojson',
      data: {
        type: 'FeatureCollection',
        features
      },
      cluster: true,
      clusterMaxZoom: 14,
      clusterRadius: 50
    })

    map.addLayer({
      id: 'clusters',
      type: 'circle',
      source: 'resources',
      filter: ['has', 'point_count'],
      paint: {
        'circle-color': '#A8985F',
        'circle-radius': 20
      }
    })

    map.addLayer({
      id: 'cluster-count',
      type: 'symbol',
      source: 'resources',
      filter: ['has', 'point_count'],
      layout: {
        'text-field': '{point_count_abbreviated}',
        'text-size': 12
      }
    })

    map.addLayer({
      id: 'unclustered-point',
      type: 'circle',
      source: 'resources',
      filter: ['!', ['has', 'point_count']],
      paint: {
        'circle-color': '#000',
        'circle-radius': 6
      }
    })

    map.on('click','unclustered-point',(e)=>{

      const city = e.features[0].properties.city
      emit('citySelected',city)

    })

  })

})
</script>

<style scoped>

.map-wrapper{
width:100%;
margin-bottom:160px;
position:relative;
}

.map{
width:100%;
height:460px;
border-radius:24px;
box-shadow:0 40px 90px rgba(0,0,0,0.08);
}

</style>