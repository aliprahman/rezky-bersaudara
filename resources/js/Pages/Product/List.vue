<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import helper from '@/Utils/helper.js';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    products: {
        type: Array,
    },
    success: {
        type: String,
    },
    error: {
        type: String,
    },
});

</script>

<template>
    <Head title="Produk" />

    <AuthenticatedLayout>
        <template #header>
            <Link :href="route('product.create')">
                <SuccessButton class="float-right">Buat Produk Baru</SuccessButton>
            </Link>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produk</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Daftar Produk</h2>

                            <!-- component -->
                            <!-- This is an example component -->
                            <div class="max-w-lg">
                                <div v-if="error" class="flex bg-red-100 rounded-lg p-4 mb-4 text-lg text-red-700" role="alert">
                                    <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <div>
                                        <span class="font-medium">Error,</span> {{ error }}
                                    </div>
                                </div>
                                <div v-if="success" class="flex bg-green-100 rounded-lg p-4 mb-4 text-lg text-green-700" role="alert">
                                    <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <div>
                                        <span class="font-medium">Sukses,</span> {{ success }}
                                    </div>
                                </div>
                            </div>
                        </header>

                        <!-- component -->
                        <!-- This is an example component -->
                        <div class="mt-4 flex flex-col">
                            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden ">
                                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                            <thead class="bg-gray-100 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Nama Produk
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Harga
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Tipe
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="p-4">
                                                        <span class="sr-only">Edit</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                <tr v-for="(product, index) in products" :key="index" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ product.name }}
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                        Rp. {{ helper.formatRupiah(product.price) }} / {{ product.unit }}
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <span v-if="product.type === 1">Penjualan</span>
                                                        <span v-else-if="product.type === 2">Pembelian</span>
                                                        <span v-else>Penjualan dan Pembelian</span>
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium whitespace-nowrap">
                                                        <SuccessButton v-if="product.is_active">
                                                            Aktif
                                                        </SuccessButton>
                                                        <DangerButton v-else>
                                                            Tidak Aktif
                                                        </DangerButton>
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-right whitespace-nowrap">
                                                        <Link :href="route('product.edit', {'id': product.id})" class="text-blue-600 dark:text-blue-500 hover:underline">Edit</Link>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
