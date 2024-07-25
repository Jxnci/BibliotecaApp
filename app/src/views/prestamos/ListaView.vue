<template>
  <div>
    <div class="flex justify-between  mb-3">
      <div class="flex flex-row items-center justify-between text-base w-full">
        <div class="flex gap-2 items-center">
          <span class="text-gray-800 dark:text-white ">Buscar</span>
          <input type="text" class="rounded py-0.5" v-model="inputBuscar" @input="handleSearch('nombreApellido')">
        </div>
        <div class="flex gap-2 items-center">
          <span class="text-gray-800 dark:text-white ">Inicio</span>
          <input type="date" class="rounded py-0.5 " v-model="startDate">
          <span class="text-gray-800 dark:text-white ">Fin</span>
          <input type="date" class="rounded py-0.5 " v-model="endDate">
          <button class="bg-blue-500 px-4 rounded text-white" @click="searchByDate">Buscar</button>
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th scope="col"
              class="py-1.5 px-3 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <div class="flex items-center gap-x-3">Persona</div>
            </th>
            <th scope="col"
              class=" py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Rango Fechas</th>
            <th scope="col"
              class="px-4 py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Estado</th>
            <th scope="col"
              class="py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Multa</th>
            <th scope="col"
              class=" py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Usuario</th>
            <th scope="col"
              class="px-4 py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Acciones</th>
          </tr>
        </thead>
        <tbody v-if="prestamos">
          <tr v-for="prestamo in prestamos" :key="prestamo.id" class="libro">
            <td class="px-3 py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              <h2 class="font-medium text-gray-800 dark:text-white ">{{ prestamo.persona.nombres }}</h2>
              <p class="text-sm font-normal text-gray-600 dark:text-gray-400 -mt-1">{{ prestamo.persona.tipo.descripcion
                }}</p>
            </td>
            <td class=" py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              <p class="font-normal text-gray-600 dark:text-white "><span class="font-semibold">Inicio</span>: {{
                prestamo.fecha_inicio }}</p>
              <p class="text-sm font-normal text-gray-600 dark:text-white -mt-1"><span class="font-semibold">Fin</span>
                :{{ prestamo.fecha_fin }}</p>
            </td>
            <td class=" py-1 text-sm whitespace-nowrap">
              <span v-if="prestamo.estado == 1"
                class="bg-orange-100 border px-1 border-orange-500 text-orange-500 rounded-full">No devuelto</span>
              <span v-if="prestamo.estado == 2"
                class="bg-red-100 border px-1 border-red-500 text-red-500 rounded-full">Anulado</span>
              <span v-if="prestamo.estado == 3"
                class="bg-green-100 border px-1 border-green-500 text-green-500 rounded-full">Devuelto</span>
            </td>
            <td class=" py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              <p class="font-normal text-gray-600 dark:text-white ">
                {{ prestamo.multa.asunto }}</p>
              <p class="text-sm font-normal text-gray-600 dark:text-white -mt-1">
                <span class="font-semibold">Monto : </span>{{ prestamo.multa.monto }}
              </p>
            </td>
            <td class=" py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              <p class="text-sm font-semibold text-gray-600 dark:text-white">
                {{ prestamo.user.name }}
              <p class="font-normal text-gray-600 dark:text-white -mt-1">
                {{ useTime(prestamo.created_at).value }}</p>
              </p>
            </td>
            <td class=" py-1 pe-2 text-sm font-medium text-gray-500 whitespace-nowrap flex justify-center">
              <div class="flex justify-center gap-x-2" v-if="prestamo.estado == 1">
                <button
                  class="text-gray-700 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                  <v-icon name="la-edit-solid" class="w-7 h-7 p-1" title="Editar"></v-icon>
                </button>
                <button @click="modal(prestamo.id, 'Anular Prestamo')"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                  <v-icon name="md-commentsdisabled-outlined" class="w-7 h-7 p-1" title="Anular Prestamo"></v-icon>
                </button>
              </div>
              <div v-else class=" text-center w-max p-1">
                Finalizado
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div class="flex items-center justify-between mt-3">
      <button @click="fetchPrestamos('', currentPage - 1)" :disabled="currentPage === 1"
        class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5 rtl:-scale-x-100">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
        </svg>
        <span>Anterior</span>
      </button>
      <div class="items-center hidden lg:flex gap-x-3">
        <span href="#" class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">Página {{
          currentPage }} de {{ lastPage }}</span>
        <span v-if="prestamos.length === 0" class="animate-pulse bg-gray-50">
          <div class="w-20 h-6 rounded-xl bg-gray-300"></div>
        </span>
        <span v-else class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">{{
          prestamos.length }}
          resultados</span>
      </div>
      <button @click="fetchPrestamos('', currentPage + 1)" :disabled="currentPage === lastPage"
        class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
        <span>Siguiente</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5 rtl:-scale-x-100">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Modals -->
  <div v-if="openModalDelete" class=" absolute top-0 left-0 w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalDelete" class="modal bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">{{ mensaje_modal }}</h2>
    <p class="mb-2 font-light dark:text-gray-100">¿Esta seguro de realizar esta accion?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="deleteItem(item_id)" class="bg-green-500 px-4 py-1 rounded-md text-white">Aceptar</button>
      <button @click="openModalDelete = false" class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>

</template>

<script setup>
import PrestamosService from "../../services/PrestamosService.js";
import useTime from "@/composables/useTime.js"
import { onMounted, ref } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const modal = (id, mensaje) => {
  openModalDelete.value = true;
  mensaje_modal.value = mensaje;
  item_id.value = id;
}

const openModalDelete = ref(false)
const mensaje_modal = ref('')

const service = new PrestamosService();
const prestamos = ref([]);
const item_id = ref('');
const inputBuscar = ref('');
const startDate = ref('');
const endDate = ref('');
const state = ref(true);

// paginacion
const currentPage = ref(1);
const lastPage = ref(1);

const fetchPrestamos = async (buscar, page = 1) => {
  const response = await service.fetchAll(buscar, page);
  prestamos.value = response.data;
  currentPage.value = response.current_page;
  lastPage.value = response.last_page;
};
const handleSearch = async (input) => {
  // if (inputBuscar.value.length >= 2 || inputBuscar.value.length === 0) {
  await fetchPrestamos(inputBuscar.value);
  // } else {
  //   categorias.value = [];
  // }
};
const searchByDate = async () => {
  try {
    if (startDate.value && endDate.value) {
      const response = await service.fetchAllBtFecha(startDate.value, endDate.value);
      prestamos.value = response.data;
      currentPage.value = response.current_page;
      lastPage.value = response.last_page;
    } else {
      toast.warn("Por favor, selecciona ambas fechas.", {
        autoClose: 2500,
      });
    }
  } catch (error) {
    console.error('Error fetching data:', error);
  }
}
onMounted(async () => {
  fetchPrestamos('',  1);
});
const deleteItem = async (id) => {
  state.value = await service.deleteById(id);
  if (!state.value.error) {
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchPrestamos('', currentPage.value);
  } else {
    toast.warn(state.value.mensaje, {
      autoClose: 3000,
    });
  }
  openModalDelete.value = false;
}
</script>

<style scoped>
.modal {
  position: fixed;
  z-index: 999;
  top: 20%;
  left: 35%;
  width: 400px;
}

.modalUser {
  position: fixed;
  z-index: 999;
  top: 20%;
  left: 30%;
  width: 480px;
}
</style>