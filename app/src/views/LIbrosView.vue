<template>
  <section>
    <!-- Busqueda -->
    <div class="flex justify-between ">
      <div class="flex items-center gap-x-2 text-base">
        <span class="text-gray-800 dark:text-white ">Buscar</span>
        <input type="text" class="rounded py-0.5 w-96" v-model="inputBuscar" @input="handleSearch('titulo')">
        <span class="text-gray-800 dark:text-white ">Categoria</span>
        <select class="rounded py-0.5" v-model="selectBuscar" @input="handleSearch('categoria_id')">
          <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
            {{ categoria.descripcion }}
          </option>
        </select>
      </div>
      <div>
        <button @click="initializeCreateItem"
          class="flex items-center justify-center w-1/2 px-5 py-1.5 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Agregar Libro</span>
        </button>
      </div>
    </div>

    <!-- Tabla -->
    <div class="flex flex-col mb-2 w-full">
      <div class="inline-block min-w-full py-2 align-middle">
        <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th scope="col"
                  class="py-1.5 px-3 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <div class="flex items-center gap-x-3">Titulo</div>
                </th>
                <th scope="col"
                  class=" py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  Categoria</th>
                <th scope="col"
                  class="px-4 py-1.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  Creación</th>
                <th scope="col" class="relative py-1.5">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody v-if="libros.length === 0">
              <tr class="animate-pulse bg-gray-50">
                <td>
                  <div class="flex px-12 py-2 gap-2">
                    <div class="w-20 h-7 rounded-md bg-gray-300"></div>
                  </div>
                </td>
                <td>
                  <div class="flex py-2 px-4 gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                    <div class="flex flex-col gap-3 my-auto">
                      <div class="w-32 h-3 rounded bg-gray-300"></div>
                      <div class="w-16 h-3 rounded bg-gray-300"></div>
                    </div>
                  </div>
                </td>
                <td class="px-4">
                  <div class="w-28 h-4 rounded-md bg-gray-300"></div>
                </td>
                <td>
                  <div class="flex justify-center gap-x-2">
                    <div class="w-8 h-6 rounded-md bg-gray-300"></div>
                    <div class="w-8 h-6 rounded-md bg-gray-300"></div>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr v-for="libro in libros" :key="libro.id">
                <td class="px-2 py-0.5 text-sm font-medium text-gray-700 whitespace-nowrap">
                  <div class="inline-flex items-center">
                    <div class="flex items-center gap-x-2">
                      <div class="w-8 h-8 bg-gray-100 flex items-center justify-center rounded-full">
                        <v-icon v-if="!libro.imagen" name="fa-user-alt"
                          class="object-cover w-5 h-5 rounded-full text-gray-500"></v-icon>
                        <img v-else class="object-cover w-8 h-8 rounded-full bg-gray-100"
                          :src="'../src/assets/' + libro.imagen" alt="">
                      </div>
                      <div>
                        <h2 class="font-medium text-gray-800 dark:text-white ">{{ libro.titulo }}</h2>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-400 -mt-1">Cod.:{{ libro.codigo }} |
                          Pag.:{{ libro.paginas }}</p>
                      </div>
                    </div>
                  </div>
                </td>
                <td class=" py-0.5 text-sm font-medium text-gray-500 whitespace-nowrap">
                  {{ libro.categoria.descripcion }}
                </td>
                <td class="px-4 py-0.5 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{
                  useTime(libro.created_at).value }}
                </td>
                <td class="px-4 py-0.5 text-sm whitespace-nowrap">
                  <div class="flex justify-center gap-x-2">
                    <button @click="LibroById(libro.id)"
                      class="text-gray-500 transition-colors duration-200 dark:hover:text-blue-500 dark:text-gray-300 hover:text-blue-500 focus:outline-none">
                      <v-icon name="bi-eye" class="w-7 h-7 border rounded p-1" title="Informacion del usuario"></v-icon>
                    </button>
                    <button @click="ItemById(libro.id)"
                      class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                      <v-icon name="la-edit-solid" class="w-7 h-7 border rounded p-1" title="Editar"></v-icon>
                    </button>
                    <button @click="modal(libro.id, 'Eliminar libro')"
                      class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                      <v-icon name="ri-delete-bin-line" class="w-7 h-7 border rounded p-1" title="Eliminar"></v-icon>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Paginación -->
    <div class="flex items-center justify-between">
      <button @click="fetchLibros('', '', currentPage - 1)" :disabled="currentPage === 1"
        class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5 rtl:-scale-x-100">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
        </svg>

        <span>
          Anterior
        </span>
      </button>

      <div class="items-center hidden lg:flex gap-x-3">
        <span href="#" class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">Página {{
          currentPage }} de {{ lastPage }}</span>
        <span v-if="libros.length === 0" class="animate-pulse bg-gray-50">
          <div class="w-20 h-6 rounded-xl bg-gray-300"></div>
        </span>
        <span v-else class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">{{
          libros.length }}
          resultados</span>
      </div>

      <button @click="fetchLibros('', '', currentPage + 1)" :disabled="currentPage === lastPage"
        class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
        <span>
          Siguiente
        </span>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5 rtl:-scale-x-100">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
        </svg>
      </button>
    </div>
  </section>

  <!-- modlas -->
  <div v-if="openLibro" class=" absolute top-0 left-0  w-screen h-screen backdrop-blur"></div>
  <div v-if="openLibro" class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-4 font-semibold text-lg dark:text-gray-100">Información del libro</h2>
    <div v-if="libroId.id" class="sm:flex sm:space-x-6  text-gray-800">
      <div class="flex-shrink-0 w-full mb-6 h-44 sm:h-32 sm:w-32 sm:mb-0">
        <v-icon v-if="!libroId.imagen" name="fa-user-alt"
          class="object-cover object-center w-full h-full rounded bg-gray-100"></v-icon>
        <img v-else class="object-cover object-center w-full h-full rounded bg-gray-100"
          :src="'../src/assets/' + libroId.imagen" alt="">
      </div>
      <div class="flex flex-col space-y-4">
        <div>
          <span class="text-sm text-gray-600 font-semibold">{{ libroId.categoria.descripcion }}</span>
          <h2 class=" font-semibold">{{ libroId.titulo }}</h2>
          <span class="text-sm text-gray-600">{{ libroId.resena }}</span>
        </div>
        <div class="space-y-1">
          <span class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-label="Email address" class="w-4 h-4">
              <path fill="currentColor"
                d="M274.6,25.623a32.006,32.006,0,0,0-37.2,0L16,183.766V496H496V183.766ZM464,402.693,339.97,322.96,464,226.492ZM256,51.662,454.429,193.4,311.434,304.615,256,268.979l-55.434,35.636L57.571,193.4ZM48,226.492,172.03,322.96,48,402.693ZM464,464H48V440.735L256,307.021,464,440.735Z">
              </path>
            </svg>
            <span class="text-gray-600">{{ useTime(libroId.created_at).value }}</span>
          </span>
          <span class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-label="Phonenumber" class="w-4 h-4">
              <path fill="currentColor"
                d="M449.366,89.648l-.685-.428L362.088,46.559,268.625,171.176l43,57.337a88.529,88.529,0,0,1-83.115,83.114l-57.336-43L46.558,362.088l42.306,85.869.356.725.429.684a25.085,25.085,0,0,0,21.393,11.857h22.344A327.836,327.836,0,0,0,461.222,133.386V111.041A25.084,25.084,0,0,0,449.366,89.648Zm-20.144,43.738c0,163.125-132.712,295.837-295.836,295.837h-18.08L87,371.76l84.18-63.135,46.867,35.149h5.333a120.535,120.535,0,0,0,120.4-120.4v-5.333l-35.149-46.866L371.759,87l57.463,28.311Z">
              </path>
            </svg>
            <span class="text-gray-600">Paginas: {{ libroId.paginas }}</span>
          </span>
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
      <button @click="openLibro = false" class="bg-gray-500 px-4 py-1 rounded-md text-white">Cerrar</button>
    </div>
  </div>

  <div v-if="openModalCreate" class="absolute top-0 left-0 w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalCreate"
    class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">Crear Nuevo</h2>
    <div class="sm:flex sm:space-x-6 text-gray-800">
      <div class="flex flex-col gap-2 w-full">
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Titulo</span>
          <input type="text" v-model="newItem.titulo" class="rounded py-1">
        </div>
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Codigo</span>
          <input type="text" v-model="newItem.codigo" class="rounded py-1">
        </div>
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Paginas</span>
          <input type="number" v-model="newItem.paginas" class="rounded py-1">
        </div>
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Reseña</span>
          <textarea v-model="newItem.resena" cols="30" rows="4" class="rounded py-1 mb-2"></textarea>
        </div>
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Categoria</span>
          <select v-model="newItem.categoria_id" class="rounded py-1">
            <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
              {{ categoria.descripcion }}
            </option>
          </select>
        </div>
      </div>
      <div class="flex flex-col w-full bg-gray-50 border rounded p-2">
        <h3>Agregar Autores</h3>
        <div class="w-full">
          <div class="flex w-full">
            <input type="text" v-model="searchAutor" placeholder="Buscar..." class="rounded-s py-1 w-full"
              @focus="showDropdownCreate = true" @blur="hideDropdown" @input="handleSearchAutor()" />
            <button @click="showDropdownCreate = false"
              class="rounded-e border-e border-y px-2 border-gray-500 py-1 ">X</button>
          </div>
          <div v-if="showDropdownCreate && autores.length > 0" class="dropdown absolute w-[358px]">
            <ul>
              <li v-for="autor in autores" :key="autor.id" @click="selectOptionNew(autor)" class="dropdown-item">
                {{ autor.name }}
              </li>
            </ul>
          </div>
        </div>
        <div>
          <h4>Lista de Autores</h4>
          <div class="flex flex-wrap gap-2">
            <div v-for="autorN in autoresNew" :key="autorN.id"
              class="bg-gray-100 border-gray-500 rounded-full border px-2 py-0.5 w-max flex items-center">
              <span>{{ autorN.name }}</span>
            </div>
          </div>
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
      <div class="flex flex-row gap-2 w-full">
        <div class="flex flex-col w-full">
          <span class="text-sm text-gray-600 font-semibold">Titulo:</span>
          <input type="text" v-model="ItemEdit.titulo" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold">Codigo:</span>
          <input type="text" v-model="ItemEdit.codigo" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold">Paginas:</span>
          <input type="number" v-model="ItemEdit.paginas" class="rounded py-1 mb-2">
          <span class="text-sm text-gray-600 font-semibold">Reseña:</span>
          <textarea v-model="ItemEdit.resena" cols="30" rows="4" class="rounded py-1 mb-2"></textarea>
          <span class="text-sm text-gray-600 font-semibold">Categoria:</span>
          <select v-model="ItemEdit.categoria_id" class="rounded py-1 mb-2">
            <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
              {{ categoria.descripcion }}
            </option>
          </select>
          <span class="text-sm text-gray-600 font-semibold mt-3">Editado:</span>
          <span class="text-gray-600 -mt-1">{{ useTime(ItemEdit.updated_at).value }}</span>
        </div>
        <div class="flex flex-col w-full bg-gray-50 border rounded p-2">
          <h3>Agregar Autores</h3>
          <div class="w-full">
            <div class="flex w-full">
              <input type="text" v-model="searchAutor" placeholder="Buscar..." class="rounded-s py-1 w-full"
                @focus="showDropdown = true" @blur="hideDropdown" @input="handleSearchAutor()" />
              <button @click="showDropdown = false"
                class="rounded-e border-e border-y px-2 border-gray-500 py-1 ">X</button>
            </div>
            <div v-if="showDropdown && autores.length > 0" class="dropdown absolute w-[358px]">
              <ul>
                <li v-for="autor in autores" :key="autor.id" @click="selectOption(autor)" class="dropdown-item">
                  {{ autor.name }}
                </li>
              </ul>
            </div>
          </div>
          <div>
            <h4>Lista de Autores</h4>
            <div class="flex flex-wrap gap-2">
              <div v-for="autor in ItemEdit.autores" :key="autor.id"
                class="bg-gray-100 border-gray-500 rounded-full border px-2 py-0.5 w-max flex items-center">
                <span>{{ autor.nombres }} {{ autor.nombres[0] }}.</span>
                <button @click="deleteAutor(autor.id, ItemEdit.id)"
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
    <p class="mb-2 font-light dark:text-gray-100">¿Esta seguro de realizar esta accion?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="deleteItem(item_id)" class="bg-green-500 px-4 py-1 rounded-md text-white">Aceptar</button>
      <button @click="openModalDelete = false" class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>

</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import LibrosService from "../services/LibrosService.js";
import useTime from "@/composables/useTime.js"
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const modal = (id, mensaje) => {
  openModalDelete.value = true;
  mensaje_modal.value = mensaje;
  item_id.value = id;
}
const openLibro = ref(false)
const openModalDelete = ref(false)
const openModalEdit = ref(false)
const openModalCreate = ref(false);
const mensaje_modal = ref('')
const newItem = ref({
  titulo: '',
  imagen: 'libro.jpg',
  codigo: '',
  paginas: 0,
  resena: '',
  categoria_id: ''
});
const newItemID = ref(null)

const service = new LibrosService();
const libros = ref([]);
const libroId = ref([]);
const categorias = ref([]);
const categoriasSearch = ref([]);
const ItemEdit = ref([]);
const item_id = ref('');
const state = ref(true);
const inputBuscar = ref('');
const selectBuscar = ref(1);
// Buscar Autores
const selectedOption = ref(null);
const selectedOptionNew = ref(null);
const searchAutor = ref('');
const showDropdown = ref(false);
const showDropdownCreate = ref(false);
const options = ref([]);
const autoresNew = ref([]);
const autores = computed(() => {
  return options.value.filter(option =>
    option.name.toLowerCase().includes(searchAutor.value.toLowerCase())
  );
});
const selectOption = async (option) => {
  const response = await service.addAutor(option.id, ItemEdit.value.id);
  ItemById(ItemEdit.value.id);
  selectedOption.value = option;
  showDropdown.value = false;
};
const selectOptionNew = async (option) => {
  if (newItemID.value == null) {
    toast.warn("Registra un libro primero", {
      autoClose: 3000,
    });
  } else {
    const response = await service.addAutor(option.id, newItemID.value);
    if (response.data) {
      const newAutor = { ...response.data, name: option.name };
      autoresNew.value.push(newAutor);
    }
  }
  selectedOptionNew.value = option;
  showDropdownCreate.value = false;
};

// paginacion
const currentPage = ref(1);
const lastPage = ref(1);

const fetchLibros = async (buscar, buscarParam, page = 1) => {
  const response = await service.fetchAll(buscar, buscarParam, page);
  libros.value = response.data;
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
const editItem = async (item) => {
  try {
    const response = await service.update(item.id, item);
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchLibros('', '', currentPage.value);
    openModalEdit.value = false;
  } catch (error) {
    console.log('Error updating item:', error);
  }
}
const initializeCreateItem = () => {
  newItem.value = {
    titulo: '',
    imagen: 'libro.jpg',
    codigo: '',
    paginas: 0,
    resena: '',
    categoria_id: ''
  };
  options.value = [];
  searchAutor.value = '';
  openModalCreate.value = true;
};
const createItem = async () => {
  try {
    const response = await service.create(newItem.value);
    if (response && response.data) {
      newItemID.value = response.data.id
      console.log(response)
      toast.success("Operacion realizada", {
        autoClose: 3000,
      });
      // openModalCreate.value = false;
      fetchLibros('', '', currentPage.value);
    }
  } catch (error) {
    console.log('Error creating item:', error);
  }
};
const deleteItem = async (id) => {
  state.value = await service.deleteById(id);
  if (!state.value.error) {
    toast.success("Operacion realizada", {
      autoClose: 3000,
    });
    fetchLibros('', '', currentPage.value);
  } else {
    toast.warn(state.value.mensaje, {
      autoClose: 3000,
    });
  }
  openModalDelete.value = false;
}
const handleSearch = async (input) => {
  // if (inputBuscar.value.length >= 2 || inputBuscar.value.length === 0) {

  const buscar = input === 'categoria_id' ? selectBuscar.value : inputBuscar.value;
  const buscarParam = input === 'categoria_id' ? 'categoria_id' : 'titulo';

  await fetchLibros(buscar, buscarParam, currentPage.value);
  // } else {
  //   categorias.value = [];
  // }
};
const handleSearchAutor = async () => {
  // if (inputBuscar.value.length >= 2 || inputBuscar.value.length === 0) {
  const dataAutores = await service.fetchAutores(searchAutor.value);
  if (dataAutores && Array.isArray(dataAutores.data)) {
    // categorias.value = dataAutores;
    options.value = dataAutores.data.map(item => ({
      id: item.id,
      name: item.nombres + ' ' + item.apellidos
    }))
    showDropdown.value = true
  }

  // } else {
  //   categorias.value = [];
  // }
};
onMounted(async () => {
  fetchLibros('', '', 1);
  categorias.value = await service.fetchCategorias();
  // if (dataCategorias && Array.isArray(dataCategorias)) {
  //   categorias.value = dataCategorias;
  //   options.value = dataCategorias.map(item => ({
  //     id: item.id,
  //     name: item.descripcion
  //   }))
  // }
});

const deleteLibro = async (id) => {
  await service.deleteById(id);
  toast.success("Operacion realizada", {
    autoClose: 2500,
  });
  fetchLibros('', '', currentPage.value);
  open.value = false;
}
const deleteAutor = async (autor_id, libro_id) => {
  await service.deleteDetalleAutor(autor_id, libro_id);
  toast.success("Operacion realizada", {
    autoClose: 2500,
  });
  ItemById(libro_id);
  open.value = false;
}
const LibroById = async (id) => {
  try {
    if (id) {
      const response = await service.fetchById(id);
      libroId.value = response.data[0];
      openLibro.value = true;
    }
  } catch (error) {
    console.log('Error fetching book by ID:', error);
  }
};
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
  top: 10%;
  left: 20%;
  width: 800px;
}
</style>