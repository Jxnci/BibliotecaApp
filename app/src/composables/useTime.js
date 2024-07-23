import { ref, computed } from 'vue'

export default function useTime(fecha) {
  const fechaAPI = ref(fecha)

  const tiempoTranscurrido = computed(() => {
    const fechaCreacion = new Date(fechaAPI.value)
    const fechaActual = new Date()

    const diferenciaTiempo = fechaActual - fechaCreacion
    const segundos = Math.floor(diferenciaTiempo / 1000)
    const minutos = Math.floor(segundos / 60)
    const horas = Math.floor(minutos / 60)
    const dias = Math.floor(horas / 24)
    const meses = Math.floor(dias / 30)
    const años = Math.floor(meses / 12) 

    if (años > 0) {
      return `Hace ${años} año${años !== 1 ? 's' : ''}`
    } else if (meses > 0) {
      return `Hace ${meses} mes${meses !== 1 ? 'es' : ''}`
    } else if (dias > 0) {
      return `Hace ${dias} día${dias !== 1 ? 's' : ''}`
    } else if (horas > 0) {
      return `Hace ${horas} hora${horas !== 1 ? 's' : ''}`
    } else if (minutos > 0) {
      return `Hace ${minutos} minuto${minutos !== 1 ? 's' : ''}`
    } else {
      return `Hace ${segundos} segundo${segundos !== 1 ? 's' : ''}`
    }
  })

  return tiempoTranscurrido
}
