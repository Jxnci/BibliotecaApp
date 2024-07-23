<template>
  <div
    class="flex h-screen sticky top-0 z-50 w-16 flex-col justify-between border-e dark:border-e-gray-700 bg-white dark:bg-gray-900">
    <div>
      <div class="inline-flex h-16 w-16 items-center justify-center">
        <div class="py-4 flex justify-center">
          <router-link :to="{ name: 'perfil' }" class="group relative w-max rounded px-2 py-1.5 flex">
            <img src="../assets/ASD-1.svg" alt="" class="w-10 h-10 rounded-lg dark:bg-gray-700">
            <span
              class="text-xs pointer-events-none absolute bg-slate-900 rounded text-white px-2 py-1.5 ms-12 mt-2 w-max opacity-0 transition-opacity group-hover:opacity-100">
              Perfil
            </span>
          </router-link>
        </div>
      </div>

      <div class="border-t border-gray-100 dark:border-gray-700">
        <div class="px-2">
          <div class="py-2 flex justify-center">
            <router-link :to="{ name: 'dashboard' }" class=" group relative w-max rounded px-2 py-1.5 "
              :class="{ 'bg-blue-50 text-blue-700 dark:bg-gray-800 dark:text-blue-400': isRouteActive('dashboard'), 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700': !isRouteActive('dashboard') }">
              <v-icon name="md-dashboard-round"></v-icon>
              <span
                class="text-xs pointer-events-none absolute  bg-slate-900 rounded text-white px-2 py-1.5 ms-4 w-max opacity-0 transition-opacity group-hover:opacity-100">
                Dashboard
              </span>
            </router-link>
          </div>

          <ul class="space-y-1 border-t border-gray-100 dark:border-gray-700 pt-2">
            <li class="flex justify-center">
              <router-link :to="{ name: 'prestamos' }"
                :class="{ 'bg-blue-50 text-blue-700 dark:bg-gray-800 dark:text-blue-400': isRouteActive('prestamos'), 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700': !isRouteActive('prestamos') }"
                class="group relative w-max rounded px-2 py-1.5">
                <v-icon name="bi-circle-square" class="opacity-75"></v-icon>
                <span
                  class="text-xs pointer-events-none absolute  bg-slate-900 rounded text-white px-2 py-1.5 ms-4 w-max opacity-0 transition-opacity group-hover:opacity-100">
                  Prestamos
                </span>
              </router-link>
            </li>
            <li class="flex justify-center">
              <router-link :to="{ name: 'libros' }"
                :class="{ 'bg-blue-50 text-blue-700 dark:bg-gray-800 dark:text-blue-400': isRouteActive('libros'), 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700': !isRouteActive('libros') }"
                class="group relative w-max rounded px-2 py-1.5 ">
                <v-icon name="fa-store" class="opacity-75"></v-icon>
                <span
                  class="text-xs pointer-events-none absolute  bg-slate-900 rounded text-white px-2 py-1.5 ms-4 w-max opacity-0 transition-opacity group-hover:opacity-100">
                  Libros
                </span>
              </router-link>
            </li>
            <li class="flex justify-center">
              <router-link :to="{ name: 'autores' }"
                :class="{ 'bg-blue-50 text-blue-700 dark:bg-gray-800 dark:text-blue-400': isRouteActive('autores'), 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700': !isRouteActive('autores') }"
                class="group relative w-max rounded px-2 py-1.5 ">
                <v-icon name="md-personsearch-round" class="opacity-75"></v-icon>
                <span
                  class="text-xs pointer-events-none absolute  bg-slate-900 rounded text-white px-2 py-1.5 ms-4 w-max opacity-0 transition-opacity group-hover:opacity-100">
                  Autores
                </span>
              </router-link>
            </li>
            <li class="flex justify-center">
              <router-link :to="{ name: 'reportes' }"
                :class="{ 'bg-blue-50 text-blue-700 dark:bg-gray-800 dark:text-blue-400': isRouteActive('reportes'), 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700': !isRouteActive('reportes') }"
                class="group relative w-max rounded px-2 py-1.5 ">
                <v-icon name="md-stackedlinechart-round" class="opacity-75"></v-icon>
                <span
                  class="text-xs pointer-events-none absolute  bg-slate-900 rounded text-white px-2 py-1.5 ms-4 w-max opacity-0 transition-opacity group-hover:opacity-100">
                  Reportes
                </span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class=" inset-x-0 bottom-0 border-t border-gray-100 bg-white dark:bg-gray-900 dark:border-gray-700 p-2">
      <button @click.prevent="handleMode"
        class="group relative flex w-full justify-center rounded-lg px-2 py-1.5 text-sm text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700">
        <v-icon name="md-lightmode" class="opacity-75" v-if="isDarkMode"></v-icon>
        <v-icon name="md-darkmode-round" class="opacity-75" v-else></v-icon>
        <span
          class="absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded bg-gray-900 px-2 py-1.5 text-xs font-medium text-white opacity-0 group-hover:opacity-100">
          {{ isDarkMode ? 'Claro' : 'Oscuro' }}
        </span>
      </button>
      <button @click.prevent="logout"
        class="group relative flex w-full justify-center rounded-lg px-2 py-1.5 text-sm text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 hover:text-gray-700">
        <v-icon name="hi-logout" class="opacity-75"></v-icon>
        <span
          class="absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded bg-gray-900 px-2 py-1.5 text-xs font-medium text-white opacity-0 group-hover:opacity-100">
          Salir
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import router from '@/router'
import { useRoute } from 'vue-router'
import { ref } from 'vue'


// import useAuth from "../../store/useAuth";
// const store = useAuth();

const route = useRoute();
const isDarkMode = ref(false);

// Comprueba si una ruta está activa
const isRouteActive = (routeName) => {
  return route.name === routeName;
};
const logout = () => {
  // store.logout();
  router.push({ name: "home" });
};


// Función para alternar entre el modo oscuro y claro
function handleMode() {
  isDarkMode.value = !isDarkMode.value;
  // Aquí puedes agregar la lógica para cambiar el tema de tu aplicación según el valor de isDarkMode

  if (isDarkMode.value) {
    localStorage.setItem('theme', 'dark');
    document.documentElement.classList.add('dark');
  } else {
    localStorage.setItem('theme', 'light');
    document.documentElement.classList.remove('dark');
  }

}
</script>
