import { createClient } from '@supabase/supabase-js'

export default defineEventHandler(async () => {

  const supabase = createClient(
    process.env.SUPABASE_URL!,
    process.env.SUPABASE_SERVICE_ROLE_KEY!
  )

  const response = await fetch(
    'https://api.lu.ma/v1/calendar-events?calendar_id=cal-Hv0aqqpqNkf2UIKs',
    {
      headers: {
        Authorization: `Bearer ${process.env.LUMA_API_KEY}`
      }
    }
  )

  const data = await response.json()

  return {
    luma_response: data
  }

})