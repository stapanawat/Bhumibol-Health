<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { Languages, Loader2 } from 'lucide-vue-next';

const props = defineProps<{
    text: string;
    from?: string;
    to: string;
}>();

const emit = defineEmits(['translated']);
const isLoading = ref(false);

const translate = async () => {
    if (!props.text) return;

    isLoading.value = true;
    try {
        const response = await axios.post('/admin/translate', {
            text: props.text,
            source_lang: props.from || 'th',
            target_lang: props.to,
        });
        emit('translated', response.data.translation);
    } catch (error) {
        console.error('Translation failed:', error);
        alert('Translation failed. Please try again.');
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <button 
        type="button" 
        @click="translate" 
        class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 disabled:opacity-50"
        :disabled="isLoading || !text"
        title="Auto Translate"
    >
        <Loader2 v-if="isLoading" class="w-3 h-3 mr-1 animate-spin" />
        <Languages v-else class="w-3 h-3 mr-1" />
        <span>Auto Translate</span>
    </button>
</template>
