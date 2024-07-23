import useAuth from '../stores/useAuth'
import settings from '../settings.json'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

class CategoriasService {
  async fetchAll(buscar) {
    try {
      const URL_API = settings.environments.prod.api.uri
      const uri = `${URL_API}/categorias?descripcion=${buscar}`
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
      const uri = `${URL_API}/categorias/${id}`
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
    const URL_API = settings.environments.prod.api.uri;
    const uri = `${URL_API}/categorias`;
    const rawResponse = await fetch(uri, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(item)
    });
    const response = await rawResponse.json();
    return response;
  }
  async update(id, item) {
    const URL_API = settings.environments.prod.api.uri;
    const uri = `${URL_API}/categorias/${id}`;
    const rawResponse = await fetch(uri, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(item)
    });
    const response = await rawResponse.json();
    return response;
  }
  async deleteById(id) {
    try {
      const URL_API = settings.environments.dev.api.uri
      const uri = `${URL_API}/categorias/${id}`
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
}
export default CategoriasService
