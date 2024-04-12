<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NumberInput from '@/Components/NumberInput.vue';

defineProps<{
    categories: any,
    units: any,
}>();

const form = useForm({
    category_id: '',
    name: '',
    unit: '',
    price: 0,
});

const submit = () => {
    form.post(route('fruits.store'));
};

</script>

<template>
    <Head title="Create Fruit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Category</h2>
        </template>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="category_id" value="Category" />

                            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="form.category_id" required>
                                <template v-for="category in categories">
                                    <option :value="category.id">{{ category.name }}</option>
                                </template>
                            </select>
                            <InputError class="mt-2" :message="form.errors.category_id" />
                        </div>
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel for="unit" value="Unit" />

                            <select name="unit" id="unit"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                v-model="form.unit"
                                required
                            >
                                <template v-for="unit in units">
                                    <option :value="unit">{{ unit }}</option>
                                </template>
                            </select>
                            <InputError class="mt-2" :message="form.errors.unit" />
                        </div>
                        <div>
                            <InputLabel for="price" value="Price" />
                            <NumberInput id="price" class="mt-1 block w-full" v-model="form.price" required autocomplete="price" step="0.01"/>
                            <InputError class="mt-2" :message="form.errors.price" />
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