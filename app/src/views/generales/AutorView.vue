<template>
  <div class="">
    <!-- Busqueda -->
    <div class="flex justify-between  mb-3">
      <div class="flex items-center gap-x-2 text-base">
        <span class="text-gray-800 dark:text-white ">Buscar</span>
        <input type="text" class="rounded py-0.5 w-96" v-model="inputBuscar" @input="handleSearch()">
      </div>
      <div>
        <button @click="initializeCreateItem"
          class="flex items-center justify-center w-1/2 px-5 py-1.5 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Nuevo Autor</span>
        </button>
      </div>
    </div>
    <!-- Tabla -->
    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th scope="col"
              class="py-1.5 px-3 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <div class="flex items-center gap-x-3">Datos</div>
            </th>
            <th scope="col"
              class="py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Nacimiento</th>
            <th scope="col"
              class="py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
              Creacion</th>
            <th scope="col" class="relative py-1.5">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody v-if="autores">
          <tr v-for="autor in autores" :key="autor.id" class="libro">
            <td class="px-3 py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              {{ autor.nombres }} {{ autor.apellidos }}
            </td>
            <td class=" py-1 text-sm font-medium text-gray-500 whitespace-nowrap">{{ autor.nacimiento }}</td>
            <td class=" py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              <p class="text-sm font-semibold text-gray-600 dark:text-white">
                {{ autor.name }}
              <p class="font-normal text-gray-600 dark:text-white -mt-1">
                {{ useTime(autor.created_at).value }}</p>
              </p>
            </td>
            <td class=" py-1 text-sm font-medium text-gray-500 whitespace-nowrap">
              <div class="flex justify-center gap-x-2">
                <button @click="ItemById(autor.id)"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                  <v-icon name="la-edit-solid" class="w-7 h-7 border rounded p-1" title="Editar"></v-icon>
                </button>
                <button @click="modal(autor.id, 'Eliminar')"
                  class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                  <v-icon name="ri-delete-bin-line" class="w-7 h-7 border rounded p-1" title="Eliminar"></v-icon>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Paginacion -->
    <div class="flex items-center justify-between mt-3">
      <button @click="fetchAutores(currentPage - 1)" :disabled="currentPage === 1"
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
        <span v-if="autores.length === 0" class="animate-pulse bg-gray-50">
          <div class="w-20 h-6 rounded-xl bg-gray-300"></div>
        </span>
        <span v-else class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">{{
          autores.length }}
          resultados</span>
      </div>
      <button @click="fetchAutores(currentPage + 1)" :disabled="currentPage === lastPage"
        class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
        <span>Siguiente</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5 rtl:-scale-x-100">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
        </svg>
      </button>
    </div>
  </div>

  <!-- modlas -->
  <div v-if="openModalCreate" class="absolute top-0 left-0 w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalCreate"
    class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">Crear Nuevo</h2>
    <div class="sm:flex sm:space-x-6 text-gray-800">
      <div class="flex flex-col space-y-4">
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Nombres</span>
          <input type="text" v-model="newItem.nombres" class="rounded py-1">
        </div>
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Apellidos</span>
          <input type="text" v-model="newItem.apellidos" class="rounded py-1">
        </div>
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Nacimiento</span>
          <input type="date" v-model="newItem.nacimiento" class="rounded py-1">
        </div>
      </div>
    </div>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="createItem" class="bg-blue-500 px-4 py-1 rounded-md text-white">Guardar</button>
      <button @click="openModalCreate = false" class="bg-gray-500 px-4 py-1 rounded-md text-white">Cerrar</button>
    </div>
  </div>

  <div v-if="openModalEdit" class=" absolute top-0 left-0  w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalEdit"
    class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">Edicion</h2>
    <div v-if="ItemEdit.id" class="sm:flex sm:space-x-6  text-gray-800">
      <div class="flex flex-col space-y-4">
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Nombres:</span>
          <input type="text" v-model="ItemEdit.nombres" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold">Apellidos:</span>
          <input type="text" v-model="ItemEdit.apellidos" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold">Nacimiento:</span>
          <input type="date" v-model="ItemEdit.nacimiento" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold mt-3">Editado:</span>
          <span class="text-gray-600 -mt-1">{{ useTime(ItemEdit.updated_at).value }}</span>
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
    <p class="mb-2 font-light dark:text-gray-100">¿Esta seguro de realizar esta accion?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="deleteItem(item_id)" class="bg-green-500 px-4 py-1 rounded-md text-white">Aceptar</button>
      <button @click="openModalDelete = false" class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>

</template>

<script setup>
import AutoresService from "../../services/AutoresService.js";
import useTime from "@/composables/useTime.js"
import { onMounted, ref } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const notify = () => {
  toast("Formulario de nuevo usuario", {
    autoClose: 2500,
  });
}

const modal = (id, mensaje) => {
  openModalDelete.value = true;
  mensaje_modal.value = mensaje;
  item_id.value = id;
}
const openModalDelete = ref(false)
const openModalEdit = ref(false)
const openModalCreate = ref(false);
const mensaje_modal = ref('')
const newItem = ref({
  nombres: '',
  apellidos: '',
  nacimiento: '',
});

const service = new AutoresService();
const autores = ref([]);
const ItemEdit = ref([]);
const item_id = ref('');
const state = ref(true);
const inputBuscar = ref('');

// paginacion
const currentPage = ref(1);
const lastPage = ref(1);

const fetchAutores = async (buscar,page = 1) => {
  const response = await service.fetchAll(buscar,page);
  autores.value = response.data;
  currentPage.value = response.current_page;
  lastPage.value = response.last_page;
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
const handleSearch = async () => {
  // if (inputBuscar.value.length >= 2 || inputBuscar.value.length === 0) {
  await fetchAutores(inputBuscar.value);
  // } else {
  //   categorias.value = [];
  // }
};
onMounted(async () => {
  fetchAutores('');
});
const deleteItem = async (id) => {
  state.value = await service.deleteById(id);
  if (!state.value.error) {
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchAutores('');
  } else {
    toast.warn(state.value.mensaje, {
      autoClose: 3000,
    });
  }
  openModalDelete.value = false;
}
const editItem = async (item) => {
  try {
    const response = await service.update(item.id, item);
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchAutores('');
    openModalEdit.value = false;
  } catch (error) {
    console.log('Error updating item:', error);
  }
}
const initializeCreateItem = () => {
  newItem.value = {
    descripcion: ''
  };
  openModalCreate.value = true;
};
const createItem = async () => {
  try {
    const response = await service.create(newItem.value);
    if (response.error) {
      toast.error("Faltan datos", {
        autoClose: 3000,
      });
    } else {
      toast.success("Operacion realizada", {
        autoClose: 3000,
      });
      openModalCreate.value = false;
      fetchAutores('');
    }
  } catch (error) {
    console.log('Error creating item:', error);
  }
};
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