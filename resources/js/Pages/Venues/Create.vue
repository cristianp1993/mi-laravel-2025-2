<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  venue_name: '',
  venue_address: '',
  venue_max_capacity: 1,
  venue_status: true,
})

const submit = () => {
  form.post(route('venues.store'))
}
</script>

<template>
  <Head title="Crear Venue" />

  <AppLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Crear Venue</h2>
        <Link :href="route('venues.index')" class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
          Volver
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <form @submit.prevent="submit" class="space-y-5">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input v-model="form.venue_name" class="mt-1 w-full border rounded px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-900 dark:text-gray-100" />
                <p v-if="form.errors.venue_name" class="text-sm text-red-600 mt-1">{{ form.errors.venue_name }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
                <input v-model="form.venue_address" class="mt-1 w-full border rounded px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-900 dark:text-gray-100" />
                <p v-if="form.errors.venue_address" class="text-sm text-red-600 mt-1">{{ form.errors.venue_address }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacidad Máxima</label>
                <input type="number" min="1" v-model.number="form.venue_max_capacity" class="mt-1 w-full border rounded px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-900 dark:text-gray-100" />
                <p v-if="form.errors.venue_max_capacity" class="text-sm text-red-600 mt-1">{{ form.errors.venue_max_capacity }}</p>
              </div>

              <div class="flex items-center gap-2">
                <input id="status" type="checkbox" v-model="form.venue_status" class="h-4 w-4" />
                <label for="status" class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
                <p v-if="form.errors.venue_status" class="text-sm text-red-600 mt-1">{{ form.errors.venue_status }}</p>
              </div>

              <div class="flex gap-3">
                <button :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50">Guardar</button>
                <Link :href="route('venues.index')" class="px-4 py-2 border rounded dark:border-gray-600">Cancelar</Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
