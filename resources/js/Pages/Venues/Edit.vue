<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  venue: { type: Object, required: true }
})

const form = useForm({
  venue_name: props.venue.venue_name ?? '',
  venue_max_capacity: props.venue.venue_max_capacity ?? 1,
  venue_address: props.venue.venue_address ?? '',
  venue_status: !!props.venue.venue_status,
})

const submit = () => {
  form.put(route('venues.update', props.venue.id)) // si no usas Ziggy, usa `/venues/${props.venue.id}`
}
</script>

<template>
  <Head title="Edit Venue" />

  <AppLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Edit Venue
        </h2>
        <Link :href="route('venues.index')"
              class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
          Back to Venues
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 space-y-4">
            <form @submit.prevent="submit" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input v-model="form.venue_name" class="mt-1 w-full border rounded px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-900 dark:text-gray-100"/>
                <p v-if="form.errors.venue_name" class="text-sm text-red-600 mt-1">{{ form.errors.venue_name }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                <input v-model="form.venue_address" class="mt-1 w-full border rounded px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-900 dark:text-gray-100"/>
                <p v-if="form.errors.venue_address" class="text-sm text-red-600 mt-1">{{ form.errors.venue_address }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Maximum Capacity</label>
                <input type="number" min="1" v-model.number="form.venue_max_capacity" class="mt-1 w-full border rounded px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-900 dark:text-gray-100"/>
                <p v-if="form.errors.venue_max_capacity" class="text-sm text-red-600 mt-1">{{ form.errors.venue_max_capacity }}</p>
              </div>

              <div class="flex items-center gap-2">
                <input id="status" type="checkbox" v-model="form.venue_status" class="h-4 w-4"/>
                <label for="status" class="text-sm text-gray-700 dark:text-gray-300">Active</label>
                <p v-if="form.errors.venue_status" class="text-sm text-red-600 mt-1">{{ form.errors.venue_status }}</p>
              </div>

              <div class="flex gap-3">
                <button :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50">Save</button>
                <Link :href="route('venues.index')" class="px-4 py-2 border rounded dark:border-gray-600">Cancel</Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
