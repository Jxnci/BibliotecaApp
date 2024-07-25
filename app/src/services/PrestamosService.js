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
}
export default PrestamosService
