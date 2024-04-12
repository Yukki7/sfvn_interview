<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    categories: any
}>();
</script>

<template>

    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
            <SecondaryButton class="mt-4">
                <Link :href="route('categories.create')">
                Create
                </Link>
            </SecondaryButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                    <table class="w-full whitespace-nowrap">
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Name</th>
                        </tr>
                        <tr v-for="category, index in categories.data" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="pb-4 pt-6 px-6">{{ index + 1 }}</td>
                            <td class="pb-4 pt-6 px-6">{{ category.name }}</td>
                        </tr>
                        <tr v-if="categories.data.length === 0">
                            <td class="pb-4 pt-6 px-6">No categories found.</td>
                        </tr>
                    </table>
                </div>
                <Pagination class="mt-6" :links="categories.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>