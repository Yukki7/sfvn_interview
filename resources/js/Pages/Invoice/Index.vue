<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps<{
    items: any
}>();

const form = useForm({});

function confirmDelete(id: number) {
    if (confirm('Are you sure you want to delete this invoice?')) {
        form.delete(route('invoices.destroy', id));
    }
}
</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoices</h2>
            <SecondaryButton class="mt-4">
                <Link :href="route('invoices.create')">
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
                            <th class="pb-4 pt-6 px-6">Customer</th>
                            <th class="pb-4 pt-6 px-6">Created at</th>
                            <th class="pb-4 pt-6 px-6">Updated at</th>
                            <th class="pb-4 pt-6 px-6">Action</th>
                        </tr>
                        <tr v-for="item, index in items.data" :key="item.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="pb-4 pt-6 px-6">{{ index + 1 }}</td>
                            <td class="pb-4 pt-6 px-6">{{ item.customer_name }}</td>
                            <td class="pb-4 pt-6 px-6">{{ item.created_at }}</td>
                            <td class="pb-4 pt-6 px-6">{{ item.updated_at }}</td>
                            <td class="pb-4 pt-6 px-6">
                                <SecondaryButton>
                                    <Link :href="route('invoices.show', item.id)">
                                        Detail
                                    </Link>
                                </SecondaryButton>
                                <SecondaryButton class="ml-2">
                                    <Link :href="route('invoices.edit', item.id)">
                                        Edit
                                    </Link>
                                </SecondaryButton>
                                <SecondaryButton class="ml-2 text-red-600" @click="confirmDelete(item.id)">
                                    Delete
                                </SecondaryButton>
                            </td>
                        </tr>
                        <tr v-if="items.data.length === 0">
                            <td class="pb-4 pt-6 px-6">No invoices found.</td>
                        </tr>
                    </table>
                </div>
                <Pagination class="mt-6" :links="items.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
