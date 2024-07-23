<template>
  <Line id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>

<script>
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

export default {
  name: 'LineChart',
  components: { Line },
  data() {
    return {
      chartData: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
          label: 'Devuelto',
          title: 'asd',
          borderColor: "green",
          backgroundColor: 'green',
          tension: 0.3,
          pointRadius: 3,
          data: [14, 20, 17, 9, 14, 16, 12, 22, 12, 17, 18, 12]
        }, {
          label: 'No devuelto',
          title: 'asd',
          borderColor: "red",
          backgroundColor: 'red',
          tension: 0.3,
          pointRadius: 3,
          data: [16, 12, 22, 12, 17, 18, 12, 14, 20, 17, 9, 14]
        }, {
          label: 'Observado',
          title: 'asd',
          borderColor: "orange",
          backgroundColor: 'orange',
          tension: 0.3,
          pointRadius: 3,
          data: [16, 12, 14, 20, 17, 9, 14, 22, 12, 17, 5, 18]
        }]
      },
      chartOptions: {
        responsive: true
      }
    }
  }
}
</script>