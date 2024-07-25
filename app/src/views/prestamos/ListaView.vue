<template>
  <div>
    <!-- Busqueda -->
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
          <button class="bg-blue-500 px-4 rounded text-white py-1" @click="searchByDate">Buscar</button>
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
              <h2 class="font-medium text-gray-800 dark:text-white ">{{ prestamo.persona.nombres }} {{
                prestamo.persona.apellidos }}</h2>
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
                {{ prestamo.multa ? prestamo.multa.asunto : 'Sin Multa' }}</p>
              <p class="text-sm font-normal text-gray-600 dark:text-white -mt-1">
                <span class="font-semibold">Monto : </span>{{ prestamo.multa ? prestamo.multa.monto : '0.00' }}
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
              <div class="flex justify-center " v-if="prestamo.estado == 1">
                <button @click="LibroById(prestamo.id)"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-blue-500 dark:text-gray-300 hover:text-blue-500 focus:outline-none">
                  <v-icon name="md-preview-outlined" class="w-7 h-7 p-1" title="Detalles"></v-icon>
                </button>
                <button @click="ItemById(prestamo.id)"
                  class="text-gray-700 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                  <v-icon name="la-edit-solid" class="w-7 h-7 p-1" title="Editar"></v-icon>
                </button>
                <button @click="modal(prestamo.id, 'Anular')"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                  <v-icon name="md-commentsdisabled-outlined" class="w-7 h-7 p-1" title="Anular"></v-icon>
                </button>
                <button @click="modal(prestamo.id, 'Finalizar')"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                  <v-icon name="md-checkbox-outlined" class="w-7 h-7 p-1" title="Finalizar"></v-icon>
                </button>
              </div>
              <div v-else class=" text-center w-max p-1">
                <button @click="LibroById(prestamo.id)"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-blue-500 dark:text-gray-300 hover:text-blue-500 focus:outline-none">
                  <v-icon name="md-preview-outlined" class="w-7 h-7 p-1" title="Detalles"></v-icon>
                </button>
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

  <div v-if="openModalDetalles" class=" absolute top-0 left-0 w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalDetalles"
    class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-4 font-semibold text-lg dark:text-gray-100">Información de prestamo</h2>
    <div v-if="prestamosId.id" class="flex flex-col text-gray-800">
      <div class="flex flex-row gap-3 w-full">
        <div class="flex flex-col gap-3 w-full">
          <div class="flex">
            <span class="italic pe-2">Del</span>
            <div class="font-semibold">{{ prestamosId.fecha_inicio }}</div>
            <span class="italic px-2">al</span>
            <div class="font-semibold">{{ prestamosId.fecha_fin }}</div>
          </div>
          <div class="flex items-center">
            <span class="pe-2 font-semibold">Estado: </span>
            <span v-if="prestamosId.estado == 1"
              class="bg-orange-100 border px-1 border-orange-500 text-orange-500 rounded-full">No devuelto</span>
            <span v-if="prestamosId.estado == 2"
              class="bg-red-100 border px-1 border-red-500 text-red-500 rounded-full">Anulado</span>
            <span v-if="prestamosId.estado == 3"
              class="bg-green-100 border px-1 border-green-500 text-green-500 rounded-full">Devuelto</span>
          </div>
          <div class="flex flex-col">
            <span class="pe-2 font-semibold">Usuario Creador: </span>
            <div class="">{{ prestamosId.user.name }}</div>
          </div>
          <div class="flex flex-col">
            <span class="font-semibold">Prestamo a persona:</span>
            <div>{{ prestamosId.persona.nombres }} {{ prestamosId.persona.apellidos }}</div>
          </div>
          <div class="flex flex-row ms-2">
            <span class="font-semibold me-2">Celular:</span>
            <div>{{ prestamosId.persona.celular }}</div>
          </div>
          <div class="flex flex-row ms-2 -mt-3">
            <span class="font-semibold me-2">Tipo:</span>
            <div>{{ prestamosId.persona.tipo.descripcion }}</div>
          </div>
        </div>
        <div class="w-full">
          <div class="flex">
            <span class="font-semibold me-2">Multa</span>
          </div>
          <div class="flex">
            <span class="font-semibold mx-2 "> Asunto:</span>
            <div>{{ prestamosId.multa ? prestamo.multa.asunto : 'Sin Multa' }}</div>
          </div>
          <div class="flex">
            <span class="font-semibold mx-2 "> Monto:</span>
            <div>{{ prestamosId.multa ? prestamo.multa.monto : '0.00' }}</div>
          </div>
          <div>
            <span class="font-semibold me-2">Libros:</span>
            <div class="flex flex-col mt-2">
              <div v-for="libro in prestamosId.libros" :key="libro.id" class="border-b text-sm">
                {{ libro.codigo }} | <span class="italic">{{ libro.titulo }} </span>
              </div>
            </div>

          </div>
        </div>
      </div>
      <hr class="shadow mt-2">
      <div class="flex justify-between space-y-1">
        <span class="flex items-center text-gray-400">
          <v-icon name="io-timer-outline" class="w-7 h-7 p-1 "></v-icon>
          <span class="text-gray-600">Creado: {{ useTime(prestamosId.created_at).value }}</span>
        </span>
        <span class="flex items-center text-gray-400">
          <v-icon name="io-timer-outline" class="w-7 h-7 p-1 "></v-icon>
          <span class="text-gray-600">Editado: {{ useTime(prestamosId.updated_at).value }}</span>
        </span>
      </div>
    </div>
    <div v-else class="w-full max-w-md mx-auto animate-pulse p-9">
      <h1 class="h-2 bg-gray-300 rounded-lg w-52 dark:bg-gray-600"></h1>
      <p class="w-48 h-2 mt-6 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
      <p class="w-full h-2 mt-4 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
      <p class="w-64 h-2 mt-4 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
      <p class="w-4/5 h-2 mt-4 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
    </div>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="openModalDetalles = false" class="bg-gray-500 px-4 py-1 rounded-md text-white">Cerrar</button>
    </div>
  </div>

  <div v-if="openModalEdit" class=" absolute top-0 left-0  w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalEdit"
    class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">Edicion</h2>
    <div v-if="ItemEdit.id" class="sm:flex sm:space-x-6  text-gray-800">
      <div class="flex flex-row gap-2 w-full">
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Persona:</span>
          <input type="text" v-model="ItemEdit.persona.nombres" class="rounded py-1 mb-2" readonly>
          <span class="text-sm text-gray-600 font-semibold">Fecha Inicio:</span>
          <input type="date" v-model="ItemEdit.fecha_inicio" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold">Fecha Fin:</span>
          <input type="date" v-model="ItemEdit.fecha_fin" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold mt-3">Editado:</span>
          <span class="text-gray-600 -mt-1">{{ useTime(ItemEdit.updated_at).value }}</span>
        </div>
        <div class="flex flex-col w-full bg-gray-50 border rounded p-2">
          <h3>Gestionar Libros</h3>
          <div class="w-full">
            <div class="flex w-full">
              <input type="text" v-model="searchLibro" placeholder="Buscar..." class="rounded-s py-1 w-full"
                @focus="showDropdown = true" @blur="hideDropdown" @input="handleSearchLibro()" />
              <button @click="showDropdown = false"
                class="rounded-e border-e border-y px-2 border-gray-500 py-1 ">X</button>
            </div>
            <div v-if="showDropdown && libros.length > 0" class="dropdown absolute w-[358px]">
              <ul>
                <li v-for="libro in libros" :key="libro.id" @click="selectOption(libro)" class="dropdown-item">
                  {{ libro.name }}
                </li>
              </ul>
            </div>
          </div>
          <div>
            <h4>Lista de libros</h4>
            <div class="flex flex-wrap gap-2">
              <div v-for="libro in ItemEdit.libros" :key="libro.id"
                class="bg-gray-100 border-gray-500 rounded-full border px-2 py-0.5 w-max flex items-center">
                <span>{{ libro.titulo }} </span>
                <button @click="deleteLibro(ItemEdit.id, libro.id)"
                  class="text-red-500 font-semibold hover:bg-gray-200 rounded-full px-1.5 py-0 ms-1">X</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="w-full max-w-md mx-auto animate-pulse p-9">
      <h1 class="h-2 bg-gray-300 rounded-lg w-52 dark:bg-gray-600"></h1>
      <p class="w-48 h-2 mt-6 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
      <p class="w-full h-2 mt-4 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
      <p class="w-64 h-2 mt-4 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
      <p class="w-4/5 h-2 mt-4 bg-gray-200 rounded-lg dark:bg-gray-700"></p>
    </div>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="editItem(ItemEdit)" class="bg-blue-500 px-4 py-1 rounded-md text-white">Guardar Cambios</button>
      <button @click="openModalEdit = false" class="bg-gray-500 px-4 py-1 rounded-md text-white">Cerrar</button>
    </div>
  </div>

  <div v-if="openModalDelete" class=" absolute top-0 left-0 w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalDelete" class="modal bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">{{ mensaje_modal }}</h2>

    <div v-if="mensaje_modal == 'Finalizar'" class="flex flex-col">
      <p class="mb-2 font-light dark:text-gray-100">Agregar un multa</p>
      <span class="text-sm text-gray-600 font-semibold">Asunto:</span>
      <input type="text" v-model="multaAsunto" class="rounded py-1 mb-2">
      <span class="text-sm text-gray-600 font-semibold">Monto:</span>
      <input type="number" v-model="multaMonto" class="rounded py-1 mb-2">
    </div>

    <p class="mb-2 font-light dark:text-gray-100">¿Esta seguro de realizar esta accion?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button v-if="mensaje_modal == 'Finalizar'" @click="deleteItem(item_id, 3)"
        class="bg-green-500 px-4 py-1 rounded-md text-white">Si, Finalizar</button>
      <button v-else @click="deleteItem(item_id, 2)"
        class="bg-green-500 px-4 py-1 rounded-md text-white">Aceptar</button>
      <button @click="openModalDelete = false" class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>

</template>

<script setup>
import PrestamosService from "../../services/PrestamosService.js";
import useTime from "@/composables/useTime.js"
import { onMounted, ref, computed } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const modal = (id, mensaje) => {
  openModalDelete.value = true;
  mensaje_modal.value = mensaje;
  item_id.value = id;
}
const openModalDetalles = ref(false)
const openModalDelete = ref(false)
const openModalEdit = ref(false)
const mensaje_modal = ref('')

const service = new PrestamosService();
const prestamos = ref([]);
const prestamosId = ref([]);
const ItemEdit = ref([]);
const multaAsunto = ref('-');
const multaMonto = ref(0);
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
const handleSearch = async () => {
  await fetchPrestamos(inputBuscar.value);
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
  fetchPrestamos('', 1);
});
const deleteItem = async (id, estado) => {
  if (estado == 3) {
    state.value = await service.addMulta(multaAsunto.value, multaMonto.value, id);
  } else {
    state.value = await service.deleteById(id, estado);
  }
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
const LibroById = async (id) => {
  try {
    if (id) {
      const response = await service.fetchById(id);
      prestamosId.value = response.data[0];
      openModalDetalles.value = true;
    }
  } catch (error) {
    console.log('Error fetching book by ID:', error);
  }
};
const editItem = async (item) => {
  try {
    await service.update(item.id, item);
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchPrestamos('', currentPage.value);
    openModalEdit.value = false;
  } catch (error) {
    console.log('Error updating item:', error);
  }
}
// Busqeuda
const selectedOption = ref(null);
const showDropdown = ref(false);
const searchLibro = ref('');
const options = ref([]);
const libros = computed(() => {
  return options.value.filter(option =>
    option.name.toLowerCase().includes(searchLibro.value.toLowerCase())
  );
});
const handleSearchLibro = async () => {
  const dataLibros = await service.fetchLibros(searchLibro.value);
  if (dataLibros && Array.isArray(dataLibros.data)) {
    options.value = dataLibros.data.map(item => ({
      id: item.id,
      name: item.titulo
    }))
    showDropdown.value = true
  }
};
const selectOption = async (option) => {
  await service.addLibro(ItemEdit.value.id, option.id);
  ItemById(ItemEdit.value.id);
  selectedOption.value = option;
  showDropdown.value = false;
};
const ItemById = async (id) => {
  try {
    if (id) {
      openModalEdit.value = true;
      const response = await service.fetchById(id);
      ItemEdit.value = response.data[0];
    }
  } catch (error) {
    console.log('Error fetching book by ID:', error);
  }
};

const deleteLibro = async (prestamo_id, libro_id) => {
  await service.deleteDetalleLibro(prestamo_id, libro_id);
  toast.success("Operacion realizada", {
    autoClose: 2500,
  });
  ItemById(prestamo_id);
}

</script>

<style scoped>
.dropdown {
  border: 1px solid #ccc;
  max-height: 200px;
  overflow-y: auto;
  background: white;
}

.dropdown-item {
  padding: 8px 12px;
  cursor: pointer;
}

.dropdown-item:hover {
  background-color: #f0f0f0;
}

.selected-option {
  margin-top: 10px;
  font-weight: bold;
}

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
  top: 15%;
  left: 18%;
  width: 880px;
}
</style>