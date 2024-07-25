<template>
  <div>
    <!-- Busqueda -->
    <div class="flex justify-between  mb-3">
      <div class="flex items-center gap-x-2 text-base">
        <span class="text-gray-800 dark:text-white ">Buscar</span>
        <input type="text" class="rounded py-0.5 w-96" v-model="inputBuscar" @input="handleSearch">
      </div>
      <div>
        <button @click="initializeCreateItem"
          class="flex items-center justify-center w-1/2 px-5 py-1.5 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Nueva Categoria</span>
        </button>
      </div>
    </div>
    <!-- Grid -->
    <div v-if="categorias" class="grid grid-flow-row-dense grid-cols-[repeat(4,1fr)] gap-2">
      <div v-for="categoria in categorias" :key="categoria.id"
        class="border bg-gray-50 rounded flex justify-between p-2 items-center">
        <div class="flex flex-col">
          <div class="text-sm font-semibold text-gray-600 dark:text-white">{{ categoria.descripcion }}</div>
          <div class="font-normal text-gray-600 dark:text-white -mt-1">{{ useTime(categoria.created_at).value }}</div>
        </div>
        <div class="flex justify-center gap-x-2 items-center">
          <button @click="ItemById(categoria.id)"
            class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
            <v-icon name="la-edit-solid" class="w-7 h-7 border rounded p-1" title="Editar"></v-icon>
          </button>
          <button @click="modal(categoria.id, 'Eliminar')"
            class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
            <v-icon name="ri-delete-bin-line" class="w-7 h-7 border rounded p-1" title="Eliminar"></v-icon>
          </button>
        </div>
      </div>
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
          <span class="text-sm text-gray-600 font-semibold">Descripcion</span>
          <input type="text" v-model="newItem.descripcion" class="rounded py-1">
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
          <span class="text-sm text-gray-600 font-semibold">Descripcion:</span>
          <input type="text" v-model="ItemEdit.descripcion" class="rounded py-1">
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
import CategoriasService from "../../services/CategoriasService.js";
import useTime from "@/composables/useTime.js"
import { onMounted, ref } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const notify = () => {
  toast("Formulario de nuevo usuario", {
    autoClose: 3000,
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
const newItem = ref({
  descripcion: ''
});
const mensaje_modal = ref('')
const service = new CategoriasService();
const categorias = ref([]);
const ItemEdit = ref([]);
const item_id = ref('');
const state = ref(true);

const inputBuscar = ref('');

const fetchCategorias = async (buscar) => {
  categorias.value = await service.fetchAll(buscar);
};
const handleSearch = async () => {
  // if (inputBuscar.value.length >= 2 || inputBuscar.value.length === 0) {
    await fetchCategorias(inputBuscar.value);
  // } else {
  //   categorias.value = [];
  // }
};
onMounted(async () => {
  fetchCategorias('');
});
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
const deleteItem = async (id) => {
  state.value = await service.deleteById(id);
  if (!state.value.error) {
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchCategorias();
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
    fetchCategorias();
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
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    openModalCreate.value = false;
    fetchCategorias();
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