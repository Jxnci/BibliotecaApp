import useAuth from '../stores/useAuth'
import settings from '../settings.json'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

class ReportesService {
  async fetchReportes() {
    try {
      const URL_API = settings.environments.prod.api.uri
      const uri = `${URL_API}/reportes`
      const rawResponse = await fetch(uri, {
        method: 'GET'
      })
      const response = await rawResponse.json()
      return response
    } catch (error) {
      console.log(error)
    }
  }

}
export default ReportesService
