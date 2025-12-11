<script setup lang="ts">
import { onMounted } from 'vue';

const emit = defineEmits(['verify']);
const siteKey = import.meta.env.VITE_RECAPTCHA_SITE_KEY;

onMounted(() => {
    if (typeof window !== 'undefined') {
        if (!(window as any).grecaptcha) {
            const script = document.createElement('script');
            script.src = 'https://www.google.com/recaptcha/api.js?render=explicit';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
            
            script.onload = () => {
                 (window as any).grecaptcha.ready(render);
            };
        } else {
            (window as any).grecaptcha.ready(render);
        }
    }
});

const render = () => {
    if (!document.getElementById('recaptcha-container')) return;
    
    try {
        (window as any).grecaptcha.render('recaptcha-container', {
            sitekey: siteKey,
            callback: (token: string) => emit('verify', token),
        });
    } catch (e) {
        // Already rendered or error
    }
};
</script>

<template>
    <div id="recaptcha-container" class="flex justify-center my-4"></div>
</template>
