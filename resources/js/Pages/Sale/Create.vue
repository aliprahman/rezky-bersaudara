<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PriceInput from '@/Components/PriceInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import helper from '@/Utils/helper.js';
import { Head } from '@inertiajs/vue3';
import { reactive, watch, onMounted } from 'vue'
import moment from "moment"

defineProps({
    product: {
        type: Object,
    },
    date: {
        type: String,
    },
    quantity: {
        type: Number,
    },
    notes: {
        type: String,
    },
});

const props = usePage().props;

const form = useForm({
    date: props.date,
    product_id: props.product.id,
    quantity: props.quantity,
    notes: props.notes,
});

const state = reactive({
    date: props.date,
    price: props.product.price,
    unit: props.product.unit,
    priceLabel: `Rp. ${helper.formatRupiah(props.product.price)} / ${props.product.unit}`,
    total: 0,
    totalLabel: ''
})

function handleDate(date) {
    form.date = moment(date).format('YYYY-MM-DD HH:mm:ss')
}

watch(
  () => form.quantity,
  (newValue, oldValue) => {
    const quantity = parseInt(newValue.replace(/,.*|[^0-9]/g, ''), 10)
    state.total = quantity * state.price
    state.totalLabel = `Rp. ${helper.formatRupiah(state.total)}`
  }
)

</script>

<template>
    <Head title="Penjualan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penjualan {{ product.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Informasi Penjualan</h2>

                            <p class="mt-1 text-lg text-gray-600">
                                Silahkan isi informasi penjualan yang akan disimpan ke sistem.
                            </p>
                        </header>

                        <form @submit.prevent="form.post(route('sale.store'))" class="mt-6 space-y-6">
                            <input type="hidden" v-model="form.product_id" />

                            <div class="grid grid-cols-2 gap-1">
                                <div class="grid grid-rows-3 gap-0">
                                    <div>
                                        <InputLabel for="total" value="Tanggal Penjualan" />

                                        <VueDatePicker v-model="state.date" @update:model-value="handleDate" :range="false" locale="id" :min-date="new Date()" :clearable="false" :format="helper.formatDateTime" month-name-format="long" auto-apply class="mt-1 block w-full"></VueDatePicker>
                                    </div>

                                    <div>
                                        <InputLabel for="price" value="Harga" />

                                        <TextInput
                                            id="price"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="state.priceLabel"
                                            readonly
                                        />
                                    </div>

                                    <div>
                                        <InputLabel for="quantity" value="Kuantiti" />

                                        <PriceInput
                                            id="quantity"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model.lazy="form.quantity"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.quantity" />
                                    </div>

                                    <div>
                                        <InputLabel for="total" value="Total Harga" />

                                        <TextInput
                                            id="total"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="state.totalLabel"
                                            readonly
                                        />
                                    </div>
                                </div>
                                <div class="mx-3">
                                    <p class="font-medium text-lg text-gray-700 mb-1">
                                        Catatan
                                    </p>
                                    <QuillEditor v-model:content="form.notes" content-type="html" theme="snow" toolbar="minimal" placeholder="ketik catatan penjualan disini...." />
                                </div>
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
