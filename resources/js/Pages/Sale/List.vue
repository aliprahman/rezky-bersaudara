<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import Modal from '@/Components/Modal.vue';
import helper from '@/Utils/helper.js';
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

const state = reactive({
    trxDetail: null,
    modalDetail: false
});

defineProps({
    transactions: {
        type: Array,
    },
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

function showDetail(trx) {
    state.trxDetail = trx;
    state.modalDetail = true
}

</script>

<template>
    <Head title="Penjualan" />

    <AuthenticatedLayout>
        <template #header>
            <Link v-for="(product, index) in products" :key="index" :href="route('sale.create', { product_id: product.id })">
                <SuccessButton class="float-right text-lg mx-3">{{ product.name }}</SuccessButton>
            </Link>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penjualan</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Daftar Penjualan</h2>

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
                                                        Tanggal
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Produk
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Harga
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Kuantiti
                                                    </th>
                                                    <th scope="col" class="py-3 px-6 text-lg font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                        Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                <tr v-for="(transaction, index) in transactions" :key="index" class="hover:bg-gray-100 dark:hover:bg-gray-700" @click="showDetail(transaction)">
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                        {{ helper.formatDateTime(transaction.transaction_date) }}
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                        {{ transaction.ref['name'] }}
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                        Rp. {{ helper.formatRupiah(transaction.price) }} / {{ transaction.ref['unit'] }}
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                        {{ helper.formatRupiah(transaction.quantity) }} {{ transaction.ref['unit'] }}
                                                    </td>
                                                    <td class="py-4 px-6 text-lg font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        Rp. {{ helper.formatRupiah(transaction.total) }}
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

        <Modal :show="state.modalDetail" @close="state.modalDetail = false">
            <div class="p-6">
                <h2 class="mb-3 text-lg font-medium text-gray-900">
                    Detail Data Penjualan
                </h2>

                <p class="mb-2 text-lg text-gray-600">
                    <b>Tanggal</b>: {{ helper.formatDateTime(state.trxDetail.transaction_date) }}
                </p>

                <p class="mb-2 text-lg text-gray-600">
                    <b>Produk</b>: {{ state.trxDetail.ref['name'] }}
                </p>

                <p class="mb-2 text-lg text-gray-600">
                    <b>Harga</b>: {{ helper.formatRupiah(state.trxDetail.price) }} / {{ state.trxDetail.ref['unit'] }}
                </p>

                <p class="mb-2 text-lg text-gray-600">
                    <b>Kuantiti</b>: {{ helper.formatRupiah(state.trxDetail.quantity) }} {{ state.trxDetail.ref['unit'] }}
                </p>

                <p class="mb-2 text-lg text-gray-600">
                    <b>Total Harga</b>: {{ helper.formatRupiah(state.trxDetail.total) }}
                </p>

                <div class="mb-2 text-lg text-gray-600" v-if="state.trxDetail.notes">
                    <b>Catatan</b>:
                    <p v-html="state.trxDetail.notes"></p>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="state.modalDetail = false"> Tutup </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<style scoped>
tr:hover {
    cursor: pointer;
}
</style>
