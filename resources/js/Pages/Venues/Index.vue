<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  venues: Array,
})

const confirmOpen = ref(false)
const selectedId = ref(null)
const selectedName = ref('')
const isDeleting = ref(false)

function openConfirm(venue) {
  selectedId.value = venue.id
  selectedName.value = venue.venue_name
  confirmOpen.value = true
}

function closeConfirm() {
  if (isDeleting.value) return
  confirmOpen.value = false
  selectedId.value = null
  selectedName.value = ''
}

function eliminar() {
  if (!selectedId.value) return
  isDeleting.value = true
  router.delete(route('venues.destroy', selectedId.value), {
    preserveScroll: true,
    onFinish: () => {
      isDeleting.value = false
      closeConfirm()
    },
  })
}

function onKeydown(e) {
  if (e.key === 'Escape' && confirmOpen.value) closeConfirm()
}
onMounted(() => document.addEventListener('keydown', onKeydown))
onBeforeUnmount(() => document.removeEventListener('keydown', onKeydown))
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
          Create Venue
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
                        <!-- Botón eliminar con modal de confirmación -->
                        <button
                          type="button"
                          class="px-3 py-1.5 rounded-md bg-red-600 text-white hover:bg-red-700"
                          @click="openConfirm(venue)"
                        >
                          Eliminar
                        </button>
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

    <!-- Modal de confirmación -->
    <transition name="fade">
      <div
        v-if="confirmOpen"
        class="fixed inset-0 z-50 flex items-center justify-center"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
      >
        <!-- Fondo -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeConfirm"></div>

        <!-- Contenido -->
        <div class="relative w-full max-w-md rounded-xl bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black/5">
          <div class="p-6">
            <div class="flex items-start gap-3">
              <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16Zm.75-11.5a.75.75 0 00-1.5 0v5a.75.75 0 001.5 0v-5ZM10 14a1 1 0 100 2 1 1 0 000-2Z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="flex-1">
                <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                  Confirmar eliminación
                </h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                  ¿Seguro que deseas eliminar
                  <span class="font-medium">{{ selectedName }}</span>? Esta acción no se puede deshacer.
                </p>
              </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
              <button
                type="button"
                class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700"
                @click="closeConfirm"
                :disabled="isDeleting"
              >
                Cancelar
              </button>
              <button
                type="button"
                class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed"
                @click="eliminar"
                :disabled="isDeleting"
              >
                <span v-if="!isDeleting">Eliminar</span>
                <span v-else>Eliminando…</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </AppLayout>
</template>

<style>
.fade-enter-active, .fade-leave-active { transition: opacity .15s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
