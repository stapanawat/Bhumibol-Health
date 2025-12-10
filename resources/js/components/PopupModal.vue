<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription, // Ensure this component exists or is imported if used
} from '@/components/ui/dialog';
import { X } from 'lucide-vue-next';

const props = defineProps<{
    popup: {
        id: number;
        title: string;
        image_path: string;
        link?: string;
        frequency: 'once_per_session' | 'once_per_day' | 'always';
    } | null;
}>();

const isOpen = ref(false);

const checkVisibility = () => {
    if (!props.popup) return;

    const popupId = props.popup.id;
    const frequency = props.popup.frequency;
    const storageKey = `popup_seen_${popupId}`;

    if (frequency === 'always') {
        isOpen.value = true;
        return;
    }

    if (frequency === 'once_per_session') {
        if (!sessionStorage.getItem(storageKey)) {
            isOpen.value = true;
            sessionStorage.setItem(storageKey, 'true');
        }
        return;
    }

    if (frequency === 'once_per_day') {
        const lastSeen = localStorage.getItem(storageKey);
        const now = new Date().getTime();
        if (!lastSeen || now - parseInt(lastSeen) > 24 * 60 * 60 * 1000) {
            isOpen.value = true;
            localStorage.setItem(storageKey, now.toString());
        }
        return;
    }
};

onMounted(() => {
    // Small delay to allow Intro to finish if any? Or show immediately? 
    // Maybe wait 1 second to not overwhelm user if Intro is also showing.
    setTimeout(checkVisibility, 2000); 
});

const handleImageClick = () => {
    if (props.popup?.link) {
        window.location.href = props.popup.link;
    }
};
</script>

<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event">
        <DialogContent class="sm:max-w-[500px] p-0 overflow-hidden bg-transparent border-none shadow-none">
            <div class="relative group">
                <!-- Close Button (Custom to overlay on image) -->
                <button 
                    @click="isOpen = false"
                    class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 text-white rounded-full p-1 transition-colors z-10"
                >
                    <X class="w-5 h-5" />
                </button>

                <div 
                    @click="handleImageClick"
                    :class="['w-full h-auto', props.popup?.link ? 'cursor-pointer hover:opacity-95 transition-opacity' : '']"
                >
                    <img :src="props.popup?.image_path" :alt="props.popup?.title" class="w-full h-auto rounded-lg shadow-2xl" />
                </div>
            </div>
            
            <!-- Hidden accessible title/description if needed for screen readers, or use DialogTitle visually hidden -->
            <DialogTitle class="sr-only">{{ popup?.title }}</DialogTitle>
        </DialogContent>
    </Dialog>
</template>
