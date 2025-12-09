<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

// TODO: Pull menu structure from props/DB later
</script>

<template>
    <div class="min-h-screen bg-slate-50 font-sans text-slate-900 selection:bg-blue-100 selection:text-blue-900">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo Section -->
                    <Link href="/" class="flex items-center gap-3 group">
                         <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-all">
                            BH
                         </div>
                         <div class="flex flex-col">
                             <span class="font-bold text-xl leading-none bg-clip-text text-transparent bg-gradient-to-r from-blue-900 to-indigo-900">
                                Bhumibol Health
                             </span>
                             <span class="text-xs text-slate-500 font-medium tracking-wide">Premium Healthcare</span>
                         </div>
                    </Link>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-8 items-center">
                        <Link href="/" class="text-slate-600 hover:text-blue-600 font-medium transition-colors hover:scale-105 transform duration-200">Home</Link>
                        <Link href="/news" class="text-slate-600 hover:text-blue-600 font-medium transition-colors hover:scale-105 transform duration-200">News</Link>
                        <Link href="/services" class="text-slate-600 hover:text-blue-600 font-medium transition-colors hover:scale-105 transform duration-200">Services</Link>
                        <Link href="/contact" class="text-slate-600 hover:text-blue-600 font-medium transition-colors hover:scale-105 transform duration-200">Contact</Link>
                        
                        <div class="h-6 w-px bg-slate-200 mx-2"></div>

                        <Link href="/login" class="px-5 py-2.5 rounded-full bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all">
                            Log In
                        </Link>
                        <Link href="/register" class="px-5 py-2.5 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all">
                            Register
                        </Link>
                    </div>

                    <!-- Mobile Toggle -->
                     <button @click="toggleMobileMenu" class="md:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                     </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div v-show="isMobileMenuOpen" class="md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-xl absolute w-full left-0 shadow-xl">
                <div class="px-4 pt-2 pb-6 space-y-2">
                    <Link href="/" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 hover:text-blue-600 hover:bg-slate-50">Home</Link>
                    <Link href="/news" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 hover:text-blue-600 hover:bg-slate-50">News</Link>
                    <Link href="/services" class="block px-3 py-3 rounded-lg text-base font-medium text-slate-600 hover:text-blue-600 hover:bg-slate-50">Services</Link>
                    <div class="border-t border-slate-100 my-2"></div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <Link href="/login" class="text-center px-4 py-2 rounded-lg bg-slate-100 text-slate-700 font-semibold">Log In</Link>
                        <Link href="/register" class="text-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold">Register</Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 py-16 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-900/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="container mx-auto px-4 relative z-10">
                 <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Brand -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-white">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold">BH</div>
                            <span class="font-bold text-xl">Bhumibol Health</span>
                        </div>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Providing world-class healthcare services with compassion and excellence since 1950.
                        </p>
                    </div>
                    
                    <!-- Links -->
                    <div>
                        <h3 class="text-white font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-blue-400 transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Find a Doctor</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Appointments</a></li>
                        </ul>
                    </div>

                     <!-- Contact -->
                    <div>
                        <h3 class="text-white font-bold mb-4">Contact</h3>
                        <ul class="space-y-2 text-sm">
                            <li>123 Phahonyothin Rd, Bangkok</li>
                            <li>Call: 1445</li>
                            <li>Email: contact@bhumibol.com</li>
                        </ul>
                    </div>
                 </div>
                 
                 <div class="mt-12 pt-8 border-t border-slate-800 text-center text-sm text-slate-500">
                    © 2025 Bhumibol Adulyadej Hospital. All rights reserved.
                 </div>
            </div>
        </footer>
    </div>
</template>
