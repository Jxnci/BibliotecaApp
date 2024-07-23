<template>
  <section>
    <div class="flex justify-between ">
      <div class="flex items-center gap-x-2 text-base">
        <span class="text-gray-800 dark:text-white ">Buscar</span>
        <input type="text" class="rounded py-0.5 w-96">
        <span class="text-gray-800 dark:text-white ">Categoria</span>
        <select name="" id="" class="rounded py-0.5">
          <option value="">Categoria</option>
        </select>
      </div>
      <div>
        <button @click="notify"
          class="flex items-center justify-center w-1/2 px-5 py-1.5 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Agregar Libro</span>
        </button>
      </div>
    </div>

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
                    <button
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
      <button @click="fetchLibros(currentPage - 1)" :disabled="currentPage === 1"
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

      <button @click="fetchLibros(currentPage + 1)" :disabled="currentPage === lastPage"
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
  <div v-if="open" class="modal bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">{{ mensaje_modal }}</h2>
    <p class="mb-2 font-light dark:text-gray-100">¿Esta seguro de realizar esta accion?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="deleteLibro(user)" class="bg-green-500 px-4 py-1 rounded-md text-white">Aceptar</button>
      <button @click="open = false" class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>
  <div v-if="open" class=" absolute top-0 left-0  w-screen h-screen backdrop-blur"></div>

  <div v-if="openLibro" class="modalUser bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-4 font-semibold text-lg dark:text-gray-100">Información del libro</h2>
    <div v-if="libroId.id" class="sm:flex sm:space-x-6  text-gray-800">
      <div class="flex-shrink-0 w-full mb-6 h-44 sm:h-32 sm:w-32 sm:mb-0">
        <v-icon v-if="!libroId.imagen" name="fa-user-alt"
          class="object-cover object-center w-full h-full rounded bg-gray-100"></v-icon>
        <img v-else class="object-cover object-center w-full h-full rounded bg-gray-100" :src="'../src/assets/'+libroId.imagen" alt="">
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
  <div v-if="openLibro" class=" absolute top-0 left-0  w-screen h-screen backdrop-blur"></div>
</template>

<script setup>
import LibrosService from "../services/LibrosService.js";
import useTime from "@/composables/useTime.js"
import { onMounted, ref } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const notify = () => {
  toast("Formulario de nuevo usuario", {
    autoClose: 2500,
  });
}

const modal = (user_e, mensaje) => {
  open.value = true;
  mensaje_modal.value = mensaje;
  user.value = user_e;
}

const open = ref(false)
const openLibro = ref(false)
const mensaje_modal = ref('')

const service = new LibrosService();
const libros = ref([]);
const libroId = ref([]);

const user = ref('');
const state = ref(true);

// paginacion
const currentPage = ref(1);
const lastPage = ref(1);

const deleteLibro = async (id) => {
  await service.deleteById(id);
  toast.success("Operacion realizada", {
    autoClose: 2500,
  });
  fetchLibros();
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
const fetchLibros = async (page = 1) => {
  const response = await service.fetchAll(page);
  libros.value = response.data;
  currentPage.value = response.current_page;
  lastPage.value = response.last_page;
};

onMounted(async () => {
  fetchLibros();
});
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