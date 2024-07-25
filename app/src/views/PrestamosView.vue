<template>
  <nav class="px-3 flex gap-4 font-medium ">
    <button @click="activeSection = 'NewView'"
      :class="{ 'text-blue-700 px-3 py-1 border-x border-t rounded-t bg-gray-50 dark:border-gray-500 dark:bg-gray-700 dark:text-blue-400': activeSection == 'NewView', 'text-gray-700 px-3 py-1 border-x border-t border-white dark:border-gray-900 dark:text-gray-400': activeSection != 'NewView' }">Nuevo Prestamos</button>
    <button @click="activeSection = 'ListaView'"
      :class="{ 'text-blue-700 px-3 py-1 border-x border-t rounded-t bg-gray-50 dark:border-gray-500 dark:bg-gray-700 dark:text-blue-400': activeSection == 'ListaView', 'text-gray-700 px-3 py-1 border-x border-t border-white dark:border-gray-900 dark:text-gray-400': activeSection != 'ListaView' }">Prestamos realizados</button>
  </nav>

  <div class="rounded-b p-3 border-t dark:border-gray-500">
    <component :is="activeComponent" />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ListaView from './prestamos/ListaView.vue';
import NewView from './prestamos/NewView.vue';

const componentsMap = {
  ListaView,
  NewView,
};

const activeSection = ref('NewView');
const activeComponent = computed(() => componentsMap[activeSection.value]);
</script>

<style scoped></style>