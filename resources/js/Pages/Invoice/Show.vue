<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { computed, onMounted } from 'vue';
import NumberInput from '@/Components/NumberInput.vue';

defineProps<{
    invoice: any,
}>();

function calTotal(fruits: any) {
    let total = 0;
    fruits.forEach((fruit: any) => {
        total += fruit.pivot.amount;
    });
    return total;
}

function printPdf(id: number) {
    window.open(route('invoices.pdf', id), '_blank');
}

</script>

<template>

    <Head title="Invoice Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice Detail</h2>
            <SecondaryButton class="mt-4" @click="printPdf(invoice.id)">
                Print
            </SecondaryButton>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="mt-4">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6" colspan="2">Customer</th>
                                <th class="pb-4 pt-6 px-6">{{ invoice.customer_name }}</th>
                                <th class="pb-4 pt-6 px-6"></th>
                                <th class="pb-4 pt-6 px-6"></th>
                                <th class="pb-4 pt-6 px-6"></th>
                                <th class="pb-4 pt-6 px-6"></th>
                            </tr>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">No</th>
                                <th class="pb-4 pt-6 px-6">Category</th>
                                <th class="pb-4 pt-6 px-6">Fruit</th>
                                <th class="pb-4 pt-6 px-6">Unit</th>
                                <th class="pb-4 pt-6 px-6">Price</th>
                                <th class="pb-4 pt-6 px-6">Quantity</th>
                                <th class="pb-4 pt-6 px-6">Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="(fruit, index) in invoice.fruits">
                                <td class="pb-4 pt-6 px-6">{{ index + 1 }}</td>
                                <td class="pb-4 pt-6 px-6">{{ fruit.category.name }}</td>
                                <td class="pb-4 pt-6 px-6">{{ fruit.name }}</td>
                                <td class="pb-4 pt-6 px-6">{{ fruit.unit }}</td>
                                <td class="pb-4 pt-6 px-6">{{ fruit.price }}</td>
                                <td class="pb-4 pt-6 px-6">{{ fruit.pivot.quantity }}</td>
                                <td class="pb-4 pt-6 px-6">{{ fruit.pivot.amount }}</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr class="font-bold">
                                <td class="pb-4 pt-6 px-6"></td>
                                <td class="pb-4 pt-6 px-6"></td>
                                <td class="pb-4 pt-6 px-6"></td>
                                <td class="pb-4 pt-6 px-6"></td>
                                <td class="pb-4 pt-6 px-6"></td>
                                <td class="pb-4 pt-6 px-6">Total</td>
                                <td class="pb-4 pt-6 px-6">{{ calTotal(invoice.fruits) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
