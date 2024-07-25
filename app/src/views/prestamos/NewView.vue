<template>
  <div>
    <div class="flex flex-row gap-4 w-full">
      <!-- Datos de prestamo -->
      <div class="flex flex-col w-full">
        <div class="flex w-full gap-4">
          <div class="flex flex-col w-full">
            <span class="text-sm text-gray-600 font-semibold">Fecha Inicio:</span>
            <input type="date" v-model="newItem.fecha_inicio" class="rounded py-1 mb-2">
          </div>
          <div class="flex flex-col w-full">
            <span class="text-sm text-gray-600 font-semibold">Fecha Fin:</span>
            <input type="date" v-model="newItem.fecha_fin" class="rounded py-1 mb-2">
          </div>
        </div>
        <span class="text-sm text-gray-600 font-semibold">Persona:</span>
        <div class="w-full">
          <div class="flex w-full">
            <input type="text" v-model="searchPersona" placeholder="Buscar..." class="rounded-s py-1 w-full"
              @focus="showDropdown = true" @blur="hideDropdown" @input="handleSearchPersona()" />
            <button @click="showDropdown = false"
              class="rounded-e border-e border-y px-2 border-gray-500 py-1 ">X</button>
            <router-link :to="{ name: 'ajustes' }"
              class="rounded border font-bold px-2 border-gray-500 text-green-500 py-1 ms-2"
              title="Agrega Persona">+</router-link>
          </div>
          <div v-if="showDropdown && personas.length > 0" class="dropdown absolute w-[520px]">
            <ul>
              <li v-for="persona in personas" :key="persona.id"
                @click="ItemPersonaID = persona.id; searchPersona = persona.name; showDropdown = false"
                class="dropdown-item">
                {{ persona.name }}
              </li>
            </ul>
          </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
          <button v-if="newItemID == null" class="bg-green-500 px-4 py-1 rounded-md text-white"
            @click="createItem">Registrar Prestamo</button>
          <button v-else class="bg-orange-500 px-4 py-1 rounded-md text-white" @click="openModalDelete = true">Realizar
            otro prestamo</button>
        </div>
      </div>
      <!-- Agregar Libros -->
      <div class="flex flex-col w-full bg-gray-50 border rounded px-4 py-3">
        <h3>Agregar Libros</h3>
        <div class="w-full">
          <div class="flex w-full">
            <input type="text" v-model="searchLibro" placeholder="Buscar..." class="rounded-s py-1 w-full"
              @focus="showDropdownLibro = true" @blur="hideDropdownLibro" @input="handleSearchLibro()" />
            <button @click="showDropdownLibro = false"
              class="rounded-e border-e border-y px-2 border-gray-500 py-1 ">X</button>
          </div>
          <div v-if="showDropdownLibro && libros.length > 0" class="dropdownlibro absolute w-[520px]">
            <ul>
              <li v-for="libro in libros" :key="libro.id" @click="selectOptionLibro(libro); showDropdownLibro = false"
                class="dropdown-item">
                {{ libro.name }}
              </li>
            </ul>
          </div>
        </div>
        <div>
          <h4>Libros Agregados</h4>
          <div v-if="librosPrestamo.length >= 1" class="flex flex-wrap gap-1">
            <div v-for="libro in librosPrestamo" :key="libro.id"
              class="bg-white border-gray-500 rounded border ps-2 py-0.5 w-full flex justify-between items-center shadow">
              <span>{{ libro.name }}</span>
              <button @click="deleteLibro(libro.libro_id, libro.prestamo_id, libro.id)"
                class="text-red-500 font-semibold hover:bg-gray-200 rounded-full px-1.5 py-0 ms-1">X</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- modasl -->
  <div v-if="openModalDelete" class=" absolute top-0 left-0 w-screen h-screen backdrop-blur"></div>
  <div v-if="openModalDelete" class="modal bg-white dark:bg-gray-800 dark:border-gray-900 p-6 rounded-md shadow border">
    <h2 class="mb-2 font-semibold dark:text-gray-100">Finalizar prestamo</h2>
    <p class="mb-2 font-light dark:text-gray-100">¿Esta seguro de realizar esta accion?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button @click="resetItem()" class="bg-green-500 px-4 py-1 rounded-md text-white">Aceptar</button>
      <button @click="openModalDelete = false" class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>

</template>
<script setup>
import { onMounted, ref, computed } from "vue";
import router from '@/router'
import { useRoute } from 'vue-router'
import NewPrestamoService from "../../services/NewPrestamoService.js";
import useTime from "@/composables/useTime.js"
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const route = useRoute();
const getCurrentDate = () => {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');
  const day = String(today.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
};
const newItem = ref({
  fecha_inicio: getCurrentDate(),
  fecha_fin: '',
  persona_id: '',
});
const openModalDelete = ref(false)
const newItemID = ref(null)
const ItemPersonaID = ref(null)
const librosPrestamo = ref([]);
const service = new NewPrestamoService();
// Persona
const searchPersona = ref('');
const showDropdown = ref(false);
const options = ref([]);
const personas = computed(() => {
  return options.value.filter(option =>
    option.name.toLowerCase().includes(searchPersona.value.toLowerCase())
  );
});
const handleSearchPersona = async () => {
  const dataPersonas = await service.fetchPersonas(searchPersona.value);
  if (dataPersonas && Array.isArray(dataPersonas.data)) {
    options.value = dataPersonas.data.map(item => ({
      id: item.id,
      name: item.nombres + ' ' + item.apellidos
    }))
    showDropdown.value = true
  }
};
// libros
const searchLibro = ref('');
const showDropdownLibro = ref(false);
const optionsLibros = ref([]);
const libros = computed(() => {
  return optionsLibros.value.filter(optionlibro =>
    optionlibro.name.toLowerCase().includes(searchLibro.value.toLowerCase())
  );
});
const handleSearchLibro = async () => {
  const dataLibros = await service.fetchLibros(searchLibro.value);
  if (dataLibros && Array.isArray(dataLibros.data)) {
    optionsLibros.value = dataLibros.data.map(item => ({
      id: item.id,
      name: item.titulo
    }))
    showDropdownLibro.value = true
  }
};
// seleccion de combos
const selectOptionLibro = async (option) => {
  if (newItemID.value == null) {
    toast.warn("Registra un prestamo primero", {
      autoClose: 3000,
    });
    return;
  }
  const response = await service.addLibro(newItemID.value, option.id);
  if (response.data) {
    const newLibro = { ...response.data, name: option.name };
    librosPrestamo.value.push(newLibro);
  }
};

const createItem = async () => {
  try {
    if (!newItem.value.fecha_inicio || !newItem.value.fecha_fin) {
      toast.error("Registra una fecha", {
        autoClose: 3000,
      });
      return;
    }
    if (!ItemPersonaID.value) {
      toast.error("Selecciona una persona", {
        autoClose: 3000,
      });
      return;
    }
    const response = await service.create(
      newItem.value.fecha_inicio,
      newItem.value.fecha_fin,
      ItemPersonaID.value
    );
    if (response && response.data) {
      newItemID.value = response.data.id
      toast.success("Operacion realizada", {
        autoClose: 3000,
      });
    }
  } catch (error) {
    console.log('Error creating item:', error);
  }
};
const deleteLibro = async (libro_id, prestamo_id, id) => {
  await service.deleteDetalleLibro(libro_id, prestamo_id);
  toast.success("Operacion realizada", {
    autoClose: 2500,
  });
  librosPrestamo.value = librosPrestamo.value.filter(libro => libro.id !== id);
}
const resetItem = async () => {
  newItemID.value = null;
  searchPersona.value = '';
  searchLibro.value = '';
  newItem.value = {
    fecha_inicio: getCurrentDate(),
    fecha_fin: '',
    persona_id: '',
  };
  librosPrestamo.value = [];
  openModalDelete.value = false
};

</script>

<style scoped>
.dropdown {
  border: 1px solid #ccc;
  max-height: 200px;
  overflow-y: auto;
  background: white;
}

.dropdownlibro {
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
</style>