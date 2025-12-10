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
import {
    Sheet,
    SheetContent,
    SheetTrigger,
} from '@/components/ui/sheet';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { LogOut, LayoutDashboard, User as UserIcon, Menu as MenuIcon, Users } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import GlobalSearch from '@/components/GlobalSearch.vue';

const isMobileMenuOpen = ref(false);
const page = usePage();
const user = computed(() => page.props.auth.user);
const breakingNews = computed(() => page.props.breakingNews as { title_th: string; slug: string } | null);
const activeUsers = computed(() => page.props.activeUsers as number || 0);

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

const menuItems = [
    { label: 'หน้าแรก', route: 'home' },
    { label: 'ข้อมูลของโรงพยาบาล', route: 'hospital.info' },
    { label: 'บริการประชาชน', route: 'services' },
    { label: 'หน่วยงาน', route: 'departments' },
    { label: 'วิจัย/วิชาการ', route: 'research' },
    { label: 'สิ่งอำนวยความสะดวก', route: 'facilities' },
    { label: 'บริจาค', route: 'donation' },
    { label: 'สมัครงาน', route: 'careers' },
    { label: 'จัดซื้อจัดจ้าง', route: 'procurement' },
    { label: 'เสนอแนะ', route: 'suggestions' },
    { label: 'ประชาสัมพันธ์', route: 'pr' },
    { label: 'แผนที่', route: 'map' },
];
</script>

<template>
    <div class="min-h-screen bg-slate-50 font-sans text-slate-900 selection:bg-blue-100 selection:text-blue-900 flex flex-col">
        <!-- Breaking News Banner -->
        <div v-if="breakingNews" class="bg-red-600 text-white px-4 py-2 relative overflow-hidden flex-shrink-0">
            <div class="container mx-auto flex items-center justify-between relative z-10">
                <div class="flex items-center gap-3 overflow-hidden">
                    <span class="bg-white text-red-600 text-xs font-bold px-2 py-0.5 rounded uppercase tracking-wider animate-pulse flex-shrink-0">Breaking</span>
                    <Link :href="route('news.show', breakingNews.slug)" class="text-sm font-medium hover:underline truncate">
                        {{ breakingNews.title_th }}
                    </Link>
                </div>
                <Link :href="route('news.show', breakingNews.slug)" class="text-xs text-red-100 hover:text-white ml-4 flex-shrink-0 hidden sm:inline">
                    Read More &rarr;
                </Link>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center gap-4">
                    <!-- Logo Section -->
                    <Link href="/" class="flex items-center gap-3 group flex-shrink-0">
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

                    <!-- Desktop Menu (Hidden as per request, using Hamburger for all) -->
                    <div class="hidden items-center gap-1 font-medium text-sm text-slate-600">
                        <!-- Content suppressed -->
                    </div>

                    <!-- Search & Auth -->
                    <div class="flex items-center gap-3 ml-auto flex-shrink-0">
                        <div class="hidden md:block w-64 lg:w-72">
                            <GlobalSearch />
                        </div>

                        <div class="h-6 w-px bg-slate-200 mx-1 hidden md:block"></div>

                        <template v-if="user">
                            <DropdownMenu>
                                <DropdownMenuTrigger class="outline-none">
                                    <div class="flex items-center gap-2 py-1 pl-1 pr-2 rounded-full border border-slate-200 hover:bg-slate-50 transition-all cursor-pointer">
                                        <Avatar class="h-8 w-8">
                                            <AvatarImage :src="user.avatar" :alt="user.name" />
                                            <AvatarFallback>{{ getInitials(user.name) }}</AvatarFallback>
                                        </Avatar>
                                        <span class="text-sm font-medium text-slate-700 hidden lg:block">{{ user.name }}</span>
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
                            <div class="hidden sm:flex gap-2">
                                <Link :href="route('login')" class="px-4 py-2 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 transition-all">
                                    Log In
                                </Link>
                                <Link :href="route('register')" class="px-4 py-2 rounded-full text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                                    Register
                                </Link>
                            </div>
                        </template>

                        <!-- Mobile Toggle (Now also for Desktop) -->
                        <Sheet>
                            <SheetTrigger as-child>
                                <button class="p-2 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors">
                                    <MenuIcon class="w-6 h-6" />
                                </button>
                            </SheetTrigger>
                            <SheetContent side="top" class="w-full h-auto max-h-[85vh] p-0 flex flex-col rounded-b-2xl shadow-xl">
                                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                                    <Link href="/" class="flex items-center gap-3">
                                         <div class="w-10 h-10 rounded-xl flex items-center justify-center overflow-hidden bg-blue-600">
                                            <img src="/images/logo.png" alt="Logo" class="w-full h-full object-cover">
                                         </div>
                                         <div class="flex flex-col">
                                             <span class="font-bold text-lg text-slate-900">Bhumibol Health</span>
                                         </div>
                                    </Link>
                                    <!-- Close button is automatically added by SheetContent -->
                                </div>
                                
                                <!-- Search only shows on mobile inside the menu, as it's already in the header on desktop -->
                                <div class="px-6 py-4 md:hidden">
                                     <GlobalSearch />
                                </div>
                                
                                <ScrollArea class="flex-1 px-6">
                                    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-2 md:gap-4 pb-8 pt-4">
                                        <Link 
                                            v-for="(item, index) in menuItems" 
                                            :key="index"
                                            :href="route(item.route)" 
                                            :class="[route().current(item.route) ? 'text-blue-600 bg-blue-50 font-bold ring-1 ring-blue-100' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50 font-medium']"
                                            class="flex items-center justify-start md:justify-center text-left md:text-center px-4 py-3 md:py-4 rounded-xl text-base md:text-sm transition-all duration-200 border border-transparent md:border-none hover:border-slate-100"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-3 md:hidden"></span>
                                            {{ item.label }}
                                        </Link>
                                    </div>
                                    
                                    <!-- Auth buttons for mobile only (already in header for desktop) -->
                                    <div class="border-t border-slate-100 my-2 pt-6 pb-8 md:hidden">
                                        <div v-if="!user" class="grid gap-3">
                                            <Link :href="route('login')" class="flex items-center justify-center w-full px-4 py-2 rounded-lg bg-slate-100 text-slate-700 font-semibold">Log In</Link>
                                            <Link :href="route('register')" class="flex items-center justify-center w-full px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold">Register</Link>
                                        </div>
                                    </div>
                                </ScrollArea>
                            </SheetContent>
                        </Sheet>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 py-12 relative overflow-hidden mt-auto">
            <!-- Decorative circle -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-900/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="container mx-auto px-4 relative z-10 flex flex-col md:flex-row justify-center md:items-end gap-12">
                 
                 <div class="grid grid-cols-1 md:grid-cols-4 gap-12 flex-1">
                    <!-- Brand -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-white">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center overflow-hidden bg-white/10">
                                <img src="/images/logo.png" alt="Bhumibol Health Logo" class="w-full h-full object-cover">
                            </div>
                            <span class="font-bold text-xl">Bhumibol Health</span>
                        </div>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Providing world-class healthcare services.
                        </p>
                        
                         <!-- Active Users Counter -->
                         <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800 border border-slate-700 text-emerald-400 text-xs font-mono">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            {{ activeUsers }} users online
                        </div>
                    </div>
                    
                    <!-- Links -->
                    <div>
                        <h3 class="text-white font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li v-for="item in menuItems.slice(0, 5)" :key="item.label">
                                <Link :href="route(item.route)" class="hover:text-blue-400 transition-colors">{{ item.label }}</Link>
                            </li>
                        </ul>
                    </div>

                     <!-- Contact -->
                    <div class="md:col-span-2">
                        <h3 class="text-white font-bold mb-4">Contact</h3>
                        <ul class="space-y-2 text-sm">
                            <li>123 Phahonyothin Rd, Bangkok</li>
                            <li>Call: 1445</li>
                            <li>Email: contact@bhumibol.com</li>
                        </ul>
                    </div>
                 </div>
            </div>
             <div class="container mx-auto px-4 mt-8 pt-8 border-t border-slate-800 text-center text-sm text-slate-500">
                © 2025 Bhumibol Adulyadej Hospital. All rights reserved.
             </div>
        </footer>
    </div>
</template>
