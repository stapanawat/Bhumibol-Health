<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { X, ArrowRight } from 'lucide-vue-next';

const props = defineProps<{
    intro: {
        id: number;
        title: string;
        type: 'image' | 'video';
        media_path: string;
        link?: string;
        display_duration: number;
    } | null;
}>();

const isVisible = ref(false);
const timeLeft = ref(0);
let timer: any = null;

const closeIntro = () => {
    isVisible.value = false;
    if (timer) clearInterval(timer);
    if (props.intro) {
        sessionStorage.setItem(`seen_intro_${props.intro.id}`, 'true');
    }
};

const openLink = () => {
    if (props.intro?.link) {
        window.location.href = props.intro.link;
    } else {
        closeIntro();
    }
};

onMounted(() => {
    if (props.intro) {
        const hasSeen = sessionStorage.getItem(`seen_intro_${props.intro.id}`);
        // Consider logic: Reset session if user explicitly wants to see it? For now standard 'once per session'
        
        if (!hasSeen) {
            isVisible.value = true;
            timeLeft.value = props.intro.display_duration;
            
            // Auto-close timer logic (optional: explicit close usually better for important info, but let's support duration)
            // Actually, usually intro pages have an "Enter Site" button.
            // Let's make timer just for fun or auto-forward? 
            // Better UX: Allow user to skip immediately. Timer is just visual if needed.
            
            // Let's implement a simple countdown if we want to auto-close
            // But usually Splash pages sit there until clicked.
            // Requirement said "Slideshow Fade etc" - currently just static single page per requirement plan.
        }
    }
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-500 ease-out"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition duration-300 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div v-if="isVisible && intro" class="fixed inset-0 z-[100] bg-black/90 flex flex-col items-center justify-center p-4">
            
            <!-- Close Button -->
            <button @click="closeIntro" class="absolute top-4 right-4 text-white/50 hover:text-white transition-colors p-2 z-20">
                <X class="w-8 h-8" />
                <span class="sr-only">Close</span>
            </button>

            <!-- Content Container -->
            <div class="relative w-full max-w-5xl h-full max-h-[85vh] flex flex-col items-center justify-center">
                
                <!-- Media -->
                <div @click="openLink" :class="['relative overflow-hidden rounded-xl shadow-2xl cursor-pointer w-full h-full flex items-center justify-center', intro.link ? 'hover:scale-[1.01] transition-transform' : '']">
                    <img v-if="intro.type === 'image'" :src="intro.media_path" class="w-full h-full object-contain" :alt="intro.title" />
                    <video v-else :src="intro.media_path" autoplay muted loop playsinline class="w-full h-full object-contain"></video>
                </div>

                <!-- Footer / CTA -->
                <div class="mt-8 flex flex-col items-center gap-4 animate-in fade-in slide-in-from-bottom-4 duration-700 delay-300">
                    <h1 class="text-white text-2xl md:text-3xl font-bold tracking-wide text-center uppercase">{{ intro.title }}</h1>
                    
                    <button 
                        @click="openLink"
                        class="group px-8 py-3 bg-white/10 hover:bg-white/20 border border-white/30 backdrop-blur-sm rounded-full text-white font-medium tracking-widest transition-all flex items-center gap-3"
                    >
                        <span>{{ intro.link ? 'Visit Link' : 'Enter Site' }}</span>
                        <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </button>
                </div>

            </div>
        </div>
    </Transition>
</template>
