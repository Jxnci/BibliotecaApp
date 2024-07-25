<template>
  <div class="bg-gray-50 dark:bg-gray-950 flex">
    <SidebarLayout />
    <div class="bg-white border dark:bg-gray-900 dark:border-gray-700 m-2 rounded w-full">
      <div
        class="flex justify-between pb-2 pt-2 px-4 items-center bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
        <h2 class="font-semibold text-lg dark:text-gray-100">
          <span v-if="isRouteActive('dashboard')">Dashboard</span>
          <span v-if="isRouteActive('prestamos')">Gestion de Prestamos</span>
          <span v-if="isRouteActive('libros')">Lista de Libros</span>
          <span v-if="isRouteActive('ajustes')">Ajustes Generales</span>
          <span v-if="isRouteActive('reportes')">Reportes</span>
        </h2>
        <!-- <Breadcrumbs /> -->
      </div>
      <div class=" px-4 bg-white dark:bg-gray-900 dark:border-gray-700 mt-3">
        <router-view />
      </div>
    </div>
  </div>
</template>
<script setup>
import { RouterView, useRoute } from "vue-router";
import SidebarLayout from "@/layouts/SidebarLayout.vue";

const route = useRoute();

const isRouteActive = (routeName) => {
  return route.name === routeName;
};

</script>
