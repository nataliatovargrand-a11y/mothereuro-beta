import { createClient } from '@supabase/supabase-js'

export default defineEventHandler(async () => {

  const supabase = createClient(
    process.env.SUPABASE_URL,
    process.env.SUPABASE_SERVICE_ROLE_KEY
  )

  const response = await fetch(
    'https://api.lu.ma/public/v1/calendar/list-events?calendar_id=caL-Hv0apqNkf2UIKs',
    {
      headers: {
        Authorization: `Bearer ${process.env.LUMA_API_KEY}`
      }
    }
  )

  const data = await response.json()

  const events = data.entries || data.items || []

  for (const event of events) {

    await supabase
      .from('events')
      .upsert({
        title: event.name,
        location: event.geo_address || 'Private Venue',
        event_date: event.start_at,
        image_url: event.cover_url,
        luma_url: event.url
      })

  }

  return {
    status: "events synced",
    count: events.length
  }

})