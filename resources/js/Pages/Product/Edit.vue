<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PriceInput from '@/Components/PriceInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import CONST from '@/Utils/constant.js';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    product_id: {
        type: Number
    },
    name: {
        type: String,
    },
    price: {
        type: String,
    },
    unit: {
        type: String,
    },
    type: {
        type: Number,
    },
    is_active: {
        type: Number,
    },
    status: {
        type: String,
    },
});

const props = usePage().props;

const form = useForm({
    name: props.name,
    price: props.price,
    unit: props.unit,
    type: props.type,
    is_active: props.is_active,
});

</script>

<template>
    <Head title="Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Produk</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Informasi Produk</h2>

                            <p class="mt-1 text-lg text-gray-600">
                                Silahkan isi informasi produk yang akan disimpan ke sistem.
                            </p>
                        </header>

                        <form @submit.prevent="form.patch(route('product.update', {id: product_id}))" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="name" value="Nama" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="price" value="Harga" />

                                <PriceInput
                                    id="price"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model.lazy="form.price"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>

                            <div>
                                <InputLabel for="unit" value="Satuan" />

                                <TextInput
                                    id="unit"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.unit"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.unit" />
                            </div>

                            <div>
                                <InputLabel for="type" value="Tipe" />

                                <SelectInput
                                    id="type"
                                    class="px-4 py-3 mt-1 block w-full"
                                    v-model="form.type"
                                    :options="CONST.productTypes"
                                    required
                                />


                                <InputError class="mt-2" :message="form.errors.type" />
                            </div>

                            <div>
                                <InputLabel for="is_active" value="Status" />

                                <SelectInput
                                    id="is_active"
                                    class="px-4 py-3 mt-1 block w-full"
                                    v-model="form.is_active"
                                    :options="CONST.productStatus"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.is_active" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Simpan</PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
