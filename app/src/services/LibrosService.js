import useAuth from '../stores/useAuth'
import settings from '../settings.json'

import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

class LibrosService {
  async fetchAll(buscar, buscarParam, page = 1) {
    try {
      const URL_API = settings.environments.prod.api.uri
      const uri = `${URL_API}/libros?page=${page}&${buscarParam}=${buscar}`
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
      const uri = `${URL_API}/libros/${id}`
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
  async create(item) {
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/libros`
    const rawResponse = await fetch(uri, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(item)
    })
    const response = await rawResponse.json()
    return response
  }
  async update(id, item) {
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/libros/${id}`
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
  async deleteById(id) {
    try {
      const URL_API = settings.environments.dev.api.uri
      const uri = `${URL_API}/personas/${id}`
      const rawResponse = await fetch(uri, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'Application/json'
        }
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      toast.error('Ocurrio un error: ' + error, {
        autoClose: 2500
      })
    }
  }

  // Custom
  async addAutor(autor_id, libro_id) {
    const URL_API = settings.environments.prod.api.uri
    const uri = `${URL_API}/detalleautores`
    const rawResponse = await fetch(uri, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        autor_id: autor_id,
        libro_id: libro_id
      })
    })
    const response = await rawResponse.json()
    return response
  }
  async deleteDetalleAutor(autor_id,libro_id) {
    try {
      const URL_API = settings.environments.dev.api.uri
      const uri = `${URL_API}/detalleautores`
      const rawResponse = await fetch(uri, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'Application/json'
        },
        body: JSON.stringify({
          autor_id: autor_id,
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
  // Combos
  fetchCategorias = async () => {
    try {
      const URL_API = settings.environments.prod.api.uri
      const response = await fetch(`${URL_API}/categorias`)
      if (!response.ok) {
        throw new Error('Network response was not ok.')
      }
      return await response.json()
    } catch (error) {
      console.error('Error fetching categorias:', error)
    }
  }
  fetchAutores = async (buscar) => {
    try {
      const URL_API = settings.environments.prod.api.uri
      const response = await fetch(`${URL_API}/autores?nombreApellido=${buscar}`)
      if (!response.ok) {
        throw new Error('Network response was not ok.')
      }
      return await response.json()
    } catch (error) {
      console.error('Error fetching categorias:', error)
    }
  }
}
export default LibrosService
