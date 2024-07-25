<template>
  <nav class="px-3 flex gap-4 font-medium ">
    <button @click="activeSection = 'PersonasView'"
      :class="{ 'text-blue-700 px-3 py-1 border-x border-t rounded-t bg-gray-50 dark:border-gray-500 dark:bg-gray-700 dark:text-blue-400': activeSection == 'PersonasView', 'text-gray-700 px-3 py-1 border-x border-t border-white dark:border-gray-900 dark:text-gray-400': activeSection != 'PersonasView' }">Personas</button>
    <button @click="activeSection = 'AutorView'"
      :class="{ 'text-blue-700 px-3 py-1 border-x border-t rounded-t bg-gray-50 dark:border-gray-500 dark:bg-gray-700 dark:text-blue-400': activeSection == 'AutorView', 'text-gray-700 px-3 py-1 border-x border-t border-white dark:border-gray-900 dark:text-gray-400': activeSection != 'AutorView' }">Autores</button>
    <button @click="activeSection = 'CategoriaView'"
      :class="{ 'text-blue-700 px-3 py-1 border-x border-t rounded-t bg-gray-50 dark:border-gray-500 dark:bg-gray-700 dark:text-blue-400': activeSection == 'CategoriaView', 'text-gray-700 px-3 py-1 border-x border-t border-white dark:border-gray-900 dark:text-gray-400': activeSection != 'CategoriaView' }">Categorias</button>
    <!-- <button @click="activeSection = 'UsuariosView'"
      :class="{ 'text-blue-700 px-3 py-1 border-x border-t rounded-t bg-gray-50 dark:border-gray-500 dark:bg-gray-700 dark:text-blue-400': activeSection == 'UsuariosView', 'text-gray-700 px-3 py-1 border-x border-t border-white dark:border-gray-900 dark:text-gray-400': activeSection != 'UsuariosView' }">Usuarios</button> -->
  </nav>

  <div class="rounded-b p-3 border-t dark:border-gray-500">
    <component :is="activeComponent" />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import PersonasView from './generales/PersonasView.vue';
import UsuariosView from './generales/UsuariosView.vue';
import AutorView from './generales/AutorView.vue';
import CategoriaView from './generales/CategoriaView.vue';

const componentsMap = {
  PersonasView,
  UsuariosView,
  AutorView,
  CategoriaView,
};

const activeSection = ref('PersonasView');
const activeComponent = computed(() => componentsMap[activeSection.value]);
</script>

<style scoped></style>