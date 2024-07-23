<template>
  <section class="  dark:text-gray-50">
    <form action="" class=" flex py-5 flex-col mx-auto space-y-12">
      <fieldset class="grid grid-cols-4 gap-6  rounded-md  dark:bg-gray-900">
        <div class="space-y-2 col-span-full lg:col-span-1">
          <p class="font-medium">Informacion Personal</p>
          <p class="text-xs">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci fuga autem eum!</p>
        </div>
        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
          <div class="col-span-full sm:col-span-3">
            <label for="firstname" class="text-sm">Nombres</label>
            <input id="firstname" type="text" placeholder="Nombres"
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full sm:col-span-3">
            <label for="lastname" class="text-sm">Apellidos</label>
            <input id="lastname" type="text" placeholder="Apellidos"
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full sm:col-span-3">
            <label for="email" class="text-sm">Correo electronico</label>
            <input id="email" type="email" placeholder="Correo Electronico"
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full sm:col-span-3">
            <label for="zip" class="text-sm">Celular</label>
            <input id="zip" type="text" placeholder="Celular" class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full">
            <label for="address" class="text-sm">Direccion</label>
            <input id="address" type="text" placeholder=""
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full sm:col-span-3">
            <label for="city" class="text-sm">Distrito</label>
            <input id="city" type="text" placeholder="" class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full sm:col-span-3">
            <label for="state" class="text-sm">Provincia</label>
            <input id="state" type="text" placeholder=""
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full ">
            <button class="bg-blue-500 px-4 py-2 rounded-md text-white">Guardar cambios</button>
          </div>
        </div>
      </fieldset>
      <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
      <fieldset class="grid grid-cols-4 gap-6 pt-4 rounded-md shadow-sm dark:bg-gray-900">
        <div class="space-y-2 col-span-full lg:col-span-1">
          <p class="font-medium">Perfil</p>
          <p class="text-xs">Adipisci fuga autem eum!</p>
        </div>
        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
          <div class="col-span-full sm:col-span-3">
            <label for="username" class="text-sm">Usuario</label>
            <input id="username" type="text" placeholder="Nombre de usuario"
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full sm:col-span-3">
            <label for="website" class="text-sm">Sitio Web</label>
            <input id="website" type="text" placeholder="https://"
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700">
          </div>
          <div class="col-span-full">
            <label for="bio" class="text-sm">Biografia</label>
            <textarea id="bio" placeholder=""
              class="w-full rounded-md dark:text-gray-900 dark:border-gray-700"></textarea>
          </div>
          <div class="col-span-full">
            <label for="bio" class="text-sm">Avatar</label>
            <div class="flex items-center space-x-2">
              <img src="https://source.unsplash.com/30x30/?random" alt=""
                class="w-10 h-10 rounded-full dark:bg-gray-700">
              <button type="button"
                class="px-4 py-2 border border-gray-500 rounded-md dark:border-gray-100">Cambiar</button>
            </div>
            <div class="col-span-full mt-4">
              <button class="bg-blue-500 px-4 py-2 rounded-md text-white">Guardar cambios</button>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
  </section>
</template>