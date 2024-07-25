import useAuth from '../stores/useAuth'
import settings from '../settings.json'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

class PrestamosService {
  async fetchAll(buscar, page = 1) {
    try {
      const URL_API = settings.environments.prod.api.uri
      const uri = `${URL_API}/prestamos?page=${page}&nombres=${buscar}`
      const rawResponse = await fetch(uri, {
        method: 'GET'
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      console.log(error)
    }
  }
  async fetchAllBtFecha(finicio, ffin, page = 1) {
    try {
      const URL_API = settings.environments.prod.api.uri
      const uri = `${URL_API}/prestamos?page=${page}&fecha_inicio=${finicio}&fecha_fin=${ffin}`
      const rawResponse = await fetch(uri, {
        method: 'GET'
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      console.log(error)
    }
  }
  async fetchById(id) {
    try {
      const URL_API = settings.environments.prod.api.uri
      const uri = `${URL_API}/prestamos/${id}`
      const rawResponse = await fetch(uri, {
        method: 'GET',
        headers: {
          'Content-Type': 'Application/json'
        }
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      console.log(error)
    }
  }
  async deleteById(id,estado) {
    try {
      const URL_API = settings.environments.dev.api.uri
      const uri = `${URL_API}/prestamos/${id}`
      const rawResponse = await fetch(uri, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'Application/json'
        },
        body: JSON.stringify({ estado })
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      toast.error('Ocurrio un error: ' + error, {
        autoClose: 2500
      })
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
  async addMulta(multaAsunto, multaMonto, prestamo_id) {
    await this.deleteById(prestamo_id,3);
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/multas`
    const rawResponse = await fetch(uri, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        asunto: multaAsunto,
        monto: multaMonto,
        prestamo_id: prestamo_id,
      })
    })
    const response = await rawResponse.json()
    return response
  }
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
  async deleteDetalleLibro(prestamo_id,libro_id) {
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
  async update(id, item) {
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/prestamos/${id}`
    const rawResponse = await fetch(uri, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(item)
    })
    const response = await rawResponse.json()
    return response
  }
}
export default PrestamosService
