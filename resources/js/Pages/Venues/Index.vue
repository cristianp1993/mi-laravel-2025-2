<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  venues: Array,
})

const confirmarYEliminar = (href) => {
  if (confirm('¿Seguro que deseas eliminar este venue?')) {
    window.Inertia.visit(href, { method: 'delete' })
  }
}
</script>

<template>
  <Head title="Venues" />

  <AppLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Venues
        </h2>
        <Link
          :href="route('venues.create')"
          class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          Crear
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div v-if="venues.length === 0" class="text-center py-4 text-gray-600 dark:text-gray-400">
              No hay venues disponibles.
            </div>

            <div v-else class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Maximum Capacity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                  <tr v-for="venue in venues" :key="venue.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                      {{ venue.id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                      {{ venue.venue_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                      {{ venue.venue_address }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                      {{ venue.venue_max_capacity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-2">
                        <Link
                          :href="route('venues.show', venue.id)"
                          class="px-3 py-1.5 rounded-md border text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                          Detalles
                        </Link>
                        <Link
                          :href="route('venues.edit', venue.id)"
                          class="px-3 py-1.5 rounded-md border text-blue-700 border-blue-300 hover:bg-blue-50 dark:text-blue-300 dark:border-blue-600 dark:hover:bg-blue-900/30"
                        >
                          Editar
                        </Link>
                        <Link
                          as="button"
                          method="delete"
                          :href="route('venues.destroy', venue.id)"
                          class="px-3 py-1.5 rounded-md bg-red-600 text-white hover:bg-red-700"
                          @click.prevent="confirmarYEliminar(route('venues.destroy', venue.id))"
                        >
                          Eliminar
                        </Link>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
