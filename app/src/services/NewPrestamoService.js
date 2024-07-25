import useAuth from '../stores/useAuth'
import settings from '../settings.json'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

class AutoreseService {
  // Custom

  async addLibro(prestamo_id, libro_id) {
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/detalleprestamo`
    const rawResponse = await fetch(uri, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        prestamo_id: prestamo_id,
        libro_id: libro_id
      })
    })
    const response = await rawResponse.json()
    return response
  }
  async deleteDetalleLibro(libro_id,prestamo_id) {
    try {
      const URL_API = settings.environments.dev.api.uri
      const uri = `${URL_API}/detalleprestamo`
      const rawResponse = await fetch(uri, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'Application/json'
        },
        body: JSON.stringify({
          prestamo_id: prestamo_id,
          libro_id: libro_id
        })
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      toast.error('Ocurrio un error: ' + error, {
        autoClose: 2500
      })
    }
  }
  async create(fecha_inicio, fecha_fin, PersonaID) {
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/prestamos`
    const rawResponse = await fetch(uri, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        fecha_inicio: fecha_inicio,
        fecha_fin: fecha_fin,
        user_id: 1,
        persona_id: PersonaID
      })
    })
    const response = await rawResponse.json()
    return response
  }
  // Combos
  fetchPersonas = async (buscar) => {
    try {
      const URL_API = settings.environments.prod.api.uri
      const response = await fetch(`${URL_API}/personas?nombreApellido=${buscar}`)
      if (!response.ok) {
        throw new Error('Network response was not ok.')
      }
      return await response.json()
    } catch (error) {
      console.error('Error fetching categorias:', error)
    }
  }
  fetchLibros = async (buscar) => {
    try {
      const URL_API = settings.environments.prod.api.uri
      const response = await fetch(`${URL_API}/libros?titulo=${buscar}`)
      if (!response.ok) {
        throw new Error('Network response was not ok.')
      }
      return await response.json()
    } catch (error) {
      console.error('Error fetching categorias:', error)
    }
  }
}
export default AutoreseService
