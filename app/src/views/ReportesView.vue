<template>
  <section class="pt-2 pb-4">
    <div class="sm:flex sm:items-center sm:justify-between">
      <div>
        <div class="flex items-center gap-x-3">
          <h2 class="text-lg font-medium text-gray-800 dark:text-white">Reportes</h2>
          <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400"
            v-if="datos">{{ datos.numeroPersonas }}
            Personas</span>
          <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400"
            v-if="datos">{{ datos.numeroPrestamos }}
            Prestamos</span>
        </div>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Selecciona segun el parametro de busqueda.</p>
      </div>

      <div class="flex items-center mt-4 gap-x-3">
        <button onclick="window.print()"
          class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_3098_154395)">
              <path
                d="M13.3333 13.3332L9.99997 9.9999M9.99997 9.9999L6.66663 13.3332M9.99997 9.9999V17.4999M16.9916 15.3249C17.8044 14.8818 18.4465 14.1806 18.8165 13.3321C19.1866 12.4835 19.2635 11.5359 19.0351 10.6388C18.8068 9.7417 18.2862 8.94616 17.5555 8.37778C16.8248 7.80939 15.9257 7.50052 15 7.4999H13.95C13.6977 6.52427 13.2276 5.61852 12.5749 4.85073C11.9222 4.08295 11.104 3.47311 10.1817 3.06708C9.25943 2.66104 8.25709 2.46937 7.25006 2.50647C6.24304 2.54358 5.25752 2.80849 4.36761 3.28129C3.47771 3.7541 2.70656 4.42249 2.11215 5.23622C1.51774 6.04996 1.11554 6.98785 0.935783 7.9794C0.756025 8.97095 0.803388 9.99035 1.07431 10.961C1.34523 11.9316 1.83267 12.8281 2.49997 13.5832"
                stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <defs>
              <clipPath id="clip0_3098_154395">
                <rect width="20" height="20" fill="white" />
              </clipPath>
            </defs>
          </svg>
          <span>Imprimir</span>
        </button>
      </div>
    </div>
    <div class="w-full">
      <canvas ref="chartCanvas"></canvas>
    </div>

  </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import ReportesService from "../services/ReportesService.js";

import { Chart } from 'chart.js/auto';

const chartCanvas = ref(null);

const labels = [];
const chartData = ref({
  labels: labels,
  datasets: [{
    label: '# de Préstamos',
    data: [], // Inicialmente vacío, se llenará después
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1
  }]
});

const options = {
  scales: {
    y: {
      beginAtZero: true
    }
  }
};



const datos = ref([])
const service = new ReportesService();
let myChart = null; 

onMounted(async () => {
  try {
    const datos = await service.fetchReportes();
    
    // Actualiza los datos del gráfico
    chartData.value.datasets[0].data = datos.datosMensuales;

    // Si ya existe un gráfico, destrúyelo antes de crear uno nuevo
    if (myChart) {
      myChart.destroy();
    }

    // Inicializa el gráfico
    myChart = new Chart(chartCanvas.value, {
      type: 'line', // Cambia el tipo de gráfico según tus necesidades
      data: chartData.value,
      options
    });
  } catch (error) {
    console.error('Error fetching chart data:', error);
  }
});

</script>