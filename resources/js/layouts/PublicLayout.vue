<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { LogOut, LayoutDashboard, User as UserIcon, Settings } from 'lucide-vue-next';
import { route } from 'ziggy-js';

const isMobileMenuOpen = ref(false);
const page = usePage();
const user = computed(() => page.props.auth.user);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const getInitials = (name: string) => {
    return name
        .split(' ')
        .map((word) => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
};
</script>


<template>
    <div class="min-h-screen bg-slate-50 font-sans text-slate-900 selection:bg-blue-100 selection:text-blue-900">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo Section -->
                    <Link href="/" class="flex items-center gap-3 group">
                         <div class="w-10 h-10 rounded-xl flex items-center justify-center overflow-hidden shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-all">
                            <img src="/images/logo.png" alt="Bhumibol Health Logo" class="w-full h-full object-cover">
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

                        <template v-if="user">
                            <DropdownMenu>
                                <DropdownMenuTrigger class="outline-none">
                                    <div class="flex items-center gap-3 py-1 pl-1 pr-3 rounded-full border border-slate-200 hover:bg-slate-50 transition-all cursor-pointer">
                                        <Avatar class="h-8 w-8">
                                            <AvatarImage :src="user.avatar" :alt="user.name" />
                                            <AvatarFallback>{{ getInitials(user.name) }}</AvatarFallback>
                                        </Avatar>
                                        <span class="text-sm font-medium text-slate-700 max-w-[100px] truncate">{{ user.name }}</span>
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end" class="w-56">
                                    <DropdownMenuLabel>My Account</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    
                                    <DropdownMenuItem v-if="user.roles && (user.roles.some(r => r.name === 'admin' || r.name === 'pr') || user.is_super_admin)" as-child>
                                        <Link :href="route('dashboard')" class="w-full cursor-pointer flex items-center">
                                            <LayoutDashboard class="mr-2 h-4 w-4" />
                                            <span>Dashboard</span>
                                        </Link>
                                    </DropdownMenuItem>

                                    <DropdownMenuItem as-child>
                                        <Link :href="route('profile.edit')" class="w-full cursor-pointer flex items-center">
                                            <UserIcon class="mr-2 h-4 w-4" />
                                            <span>Profile</span>
                                        </Link>
                                    </DropdownMenuItem>
                                    
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem as-child>
                                        <Link :href="route('logout')" method="post" as="button" class="w-full cursor-pointer flex items-center text-red-600 focus:text-red-600">
                                            <LogOut class="mr-2 h-4 w-4" />
                                            <span>Log out</span>
                                        </Link>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="px-5 py-2.5 rounded-full bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all">
                                Log In
                            </Link>
                            <Link :href="route('register')" class="px-5 py-2.5 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all">
                                Register
                            </Link>
                        </template>
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
                    <div class="grid gap-4 mt-4" v-if="user">
                        <div class="flex items-center gap-3 px-3">
                            <Avatar class="h-10 w-10">
                                <AvatarImage :src="user.avatar" :alt="user.name" />
                                <AvatarFallback>{{ getInitials(user.name) }}</AvatarFallback>
                            </Avatar>
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-900">{{ user.name }}</span>
                                <span class="text-xs text-slate-500">{{ user.email }}</span>
                            </div>
                        </div>
                        <div class="border-t border-slate-100 my-1"></div>
                        <Link v-if="user.roles && (user.roles.some(r => r.name === 'admin' || r.name === 'pr') || user.is_super_admin)" :href="route('dashboard')" class="flex items-center px-4 py-2 text-slate-600 hover:text-blue-600 hover:bg-slate-50 rounded-lg">
                            <LayoutDashboard class="mr-2 h-4 w-4" />
                            Dashboard
                        </Link>
                        <Link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-slate-600 hover:text-blue-600 hover:bg-slate-50 rounded-lg">
                             <UserIcon class="mr-2 h-4 w-4" />
                             Profile
                        </Link>
                        <Link :href="route('logout')" method="post" as="button" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                            <LogOut class="mr-2 h-4 w-4" />
                            Log out
                        </Link>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4" v-else>
                        <Link :href="route('login')" class="text-center px-4 py-2 rounded-lg bg-slate-100 text-slate-700 font-semibold">Log In</Link>
                        <Link :href="route('register')" class="text-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold">Register</Link>
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
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center overflow-hidden bg-white/10">
                                <img src="/images/logo.png" alt="Bhumibol Health Logo" class="w-full h-full object-cover">
                            </div>
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
