<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        required: true,
    },
    options: {
        type: Array,
        required: true,
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        @change="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
        <option value="">-- Pilih --</option>
        <option v-for="(data, index) in options" :key="index" :value="data.value" :selected="modelValue === data.value">
            {{ data.label }}
        </option>
    </select>
</template>
