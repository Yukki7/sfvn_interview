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

const props = defineProps<{
    categories: any,
}>();

const form = useForm({
    customer_name: '',
    fruits: [] as any[],
});

const submit = () => {
    form.post(route('invoices.store'));
};

const totalAmount = computed(() => {
    let total = 0;
    form.fruits.forEach((fruit: any) => {
        total += (fruit.price * fruit.quantity) || 0;
    });
    return total;
});

function fruitChange(event: any, index: number) {
    const selectedFruitID = event.target.value;
    const selectedCategoryID = event.target.selectedOptions[0].getAttribute('category_id');
    const category = props.categories.find((category: any) => category.id == selectedCategoryID);
    const fruit = category.fruits.find((fruit: any) => fruit.id == selectedFruitID);
    form.fruits[index].price = fruit.price;
    form.fruits[index].unit = fruit.unit;
}

</script>

<template>

    <Head title="Create Invoice" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Invoice</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="customer_name" value="Customer Name" />

                        <TextInput id="customer_name" type="text" class="mt-1 block w-full" v-model="form.customer_name"
                            required autofocus autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors.customer_name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="fruits" value="Fruits" />
                        <SecondaryButton style="color: green;" @click="form.fruits.push({})">
                            Add
                        </SecondaryButton>

                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left font-bold">
                                    <th class="pb-4 pt-6 px-6">#</th>
                                    <th class="pb-4 pt-6 px-6">Fruit</th>
                                    <th class="pb-4 pt-6 px-6">Quantity</th>
                                    <th class="pb-4 pt-6 px-6">Unit</th>
                                    <th class="pb-4 pt-6 px-6">Price</th>
                                    <th class="pb-4 pt-6 px-6">Amount</th>
                                    <th class="pb-4 pt-6 px-6">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr class="hover:bg-gray-100 focus-within:bg-gray-100"
                                    v-for="(fruitInvoice, index) in form.fruits"
                                >
                                    <td class="pb-4 pt-6 px-6">{{ index + 1 }}</td>
                                    <td class="pb-4 pt-6 px-6">
                                        <select v-model="fruitInvoice.fruit_id"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            @change="fruitChange($event, index)"
                                        >
                                            <template v-for="category in categories">
                                                <optgroup :label="category.name" v-if="category.fruits.length" :key="category.id">
                                                    <option v-for="fruit in category.fruits" :key="fruit.id" :value="fruit.id" :category_id="fruit.category_id">{{ fruit.name }}</option>
                                                </optgroup>
                                            </template>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors[`fruits.${index}.fruit_id`]" />
                                    </td>
                                    <td class="pb-4 pt-6 px-6">
                                        <NumberInput class="mt-1 block w-full" v-model="fruitInvoice.quantity" required autocomplete="price" />
                                        <InputError class="mt-2" :message="form.errors[`fruits.${index}.quantity`]" />
                                    </td>
                                    <td class="pb-4 pt-6 px-6">{{ fruitInvoice.unit }}</td>
                                    <td class="pb-4 pt-6 px-6">{{ fruitInvoice.price }}</td>
                                    <td class="pb-4 pt-6 px-6">{{ fruitInvoice.price * fruitInvoice.quantity }}</td>
                                    <td class="pb-4 pt-6 px-6">
                                        <SecondaryButton style="color: red;" @click="form.fruits.splice(index, 1)">
                                            Remove
                                        </SecondaryButton>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="font-bold">
                                    <td class="pb-4 pt-6 px-6"></td>
                                    <td class="pb-4 pt-6 px-6"></td>
                                    <td class="pb-4 pt-6 px-6"></td>
                                    <td class="pb-4 pt-6 px-6"></td>
                                    <td class="pb-4 pt-6 px-6">Total</td>
                                    <td class="pb-4 pt-6 px-6">{{ totalAmount }}</td>
                                    <td class="pb-4 pt-6 px-6"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
