import { createClient } from '@supabase/supabase-js'

export const supabase = createClient(
  'https://hyatwuasoqkjpyulnkqq.supabase.co',
  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imh5YXR3dWFzb3FranB5dWxua3FxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE4MjI5OTgsImV4cCI6MjA4NzM5ODk5OH0.Bbz6x40et8EjdAHQUYe5Ho7wHa17GAejwrJnT-9b_DI'
)