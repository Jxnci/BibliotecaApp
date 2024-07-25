<template>
  <div>
    <div class="flex flex-row gap-2 w-full">
      <div class="flex flex-col w-full">
        <span class="text-sm text-gray-600 font-semibold">Fecha Inicio:</span>
        <input type="date" v-model="ItemEdit.titulo" class="rounded py-1 mb-2">
        <span class="text-sm text-gray-600 font-semibold">Fecha Fin:</span>
        <input type="date" v-model="ItemEdit.codigo" class="rounded py-1 mb-2">
        <span class="text-sm text-gray-600 font-semibold">Usuario:</span>
        <input type="text" v-model="ItemEdit.paginas" class="rounded py-1 mb-2">
        <span class="text-sm text-gray-600 font-semibold">Persona:</span>
        <input type="text" v-model="ItemEdit.paginas" class="rounded py-1 mb-2">
      </div>
      <div class="flex flex-col w-full bg-gray-50 border rounded p-2">
        <h3>Agregar Libros</h3>
        <div class="w-full">
          <div class="flex w-full">
            <input type="text" placeholder="Buscar..." class="rounded-s py-1 w-full" />
            <button class="rounded-e border-e border-y px-2 border-gray-500 py-1 ">X</button>
          </div>
          <div class="dropdown absolute w-[550px]">
            <ul>
              <li class="dropdown-item">
                Libro
              </li>
            </ul>
          </div>
        </div>
        <div>
          <h4>Libros Agregados</h4>
          <div class="flex flex-wrap gap-2">
            <div class="bg-gray-100 border-gray-500 rounded-full border px-2 py-0.5 w-max flex items-center">
              <span>Libro.</span>
              <button class="text-red-500 font-semibold hover:bg-gray-200 rounded-full px-1.5 py-0 ms-1">X</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4 flex justify-end gap-2">
      <button class="bg-green-500 px-4 py-1 rounded-md text-white">Registrar Prestamo</button>
      <button class="bg-red-500 px-4 py-1 rounded-md text-white">Cancelar</button>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref, computed } from "vue";
import LibrosService from "../../services/LibrosService.js";
import useTime from "@/composables/useTime.js"
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const ItemEdit = ref({
  titulo: '',
  imagen: 'libro.jpg',
  codigo: '',
  paginas: 0,
  resena: '',
  categoria_id: ''
});
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