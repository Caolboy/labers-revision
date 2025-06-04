<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="LABERS">
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-[#FBFCF8]">
        <!-- Navigation -->
        <nav class="bg-[#FBFCF8] shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Logo removed from here -->
                        <div class="flex items-center space-x-6 ml-8">
                            <!-- Resources Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center text-[#4E413B] hover:text-[#FD7C21] px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    Resources
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:rotate-180 transition-transform duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out z-50">
                                    <div class="py-1">
                                        <Link href="#" class="block px-4 py-2 text-sm text-[#4E413B] hover:bg-gray-50 hover:text-[#FD7C21]">Documentation</Link>
                                        <Link href="#" class="block px-4 py-2 text-sm text-[#4E413B] hover:bg-gray-50 hover:text-[#FD7C21]">API Reference</Link>
                                    </div>
                                </div>
                            </div>

                            <!-- About Us Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center text-[#4E413B] hover:text-[#FD7C21] px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    About Us
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:rotate-180 transition-transform duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out z-50">
                                    <div class="py-1">
                                        <Link href="#" class="block px-4 py-2 text-sm text-[#4E413B] hover:bg-gray-50 hover:text-[#FD7C21]">Our Team</Link>
                                        <Link href="#" class="block px-4 py-2 text-sm text-[#4E413B] hover:bg-gray-50 hover:text-[#FD7C21]">Mission & Vision</Link>
                                        <Link href="#" class="block px-4 py-2 text-sm text-[#4E413B] hover:bg-gray-50 hover:text-[#FD7C21]">Contact</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <Link
                            :href="route('login')"
                            class="text-[#4E413B] hover:text-[#FD7C21] px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="bg-gradient-to-r from-[#FD7C21] to-[#FF9D00] text-white hover:from-[#FD7C21]/90 hover:to-[#FF9D00]/90 px-6 py-2 rounded-full text-sm font-medium transition duration-300 ease-in-out shadow-md hover:shadow-lg"
                        >
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <!-- Logo in hero section -->
                    <div class="flex justify-center mb-6">
                        <img src="/logo-1.png" alt="LABERS Logo" class="h-50 w-auto" />
                    </div>
                    <h1 class="text-4xl tracking-tight font-bold text-[#4E413B] sm:text-5xl md:text-6xl mb-4">
                        <span>Simplifying </span>
                        <span class="text-[#FD7C21]">lab reservations </span>
                    </h1>
                    <h1 class="text-4xl tracking-tight font-bold text-[#4E413B] sm:text-5xl md:text-6xl -mt-4">
                        for seamless academic success.
                    </h1>
                    <p class="mt-4 max-w-md mx-auto text-sm text-[#4E413B]/70 md:mt-5 md:max-w-2xl">
                        LABERS enhances Gordon College - College of Computer Studies operations with advanced scheduling,
                        streamlined laboratory bookings, and efficient resource management.
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        <div class="rounded-full p-[2px] bg-gradient-to-r from-[#FD7C21] to-[#FF9D00] shadow-md hover:shadow-lg transition duration-300">
                            <a
                                href="https://gordoncollege.edu.ph/ccs/"
                                target="_blank"
                                rel="noopener"
                                class="w-full flex items-center justify-center px-8 py-3 text-base font-medium rounded-full text-white bg-gradient-to-r from-[#FD7C21] to-[#FF9D00] hover:from-[#FD7C21]/90 hover:to-[#FF9D00]/90 md:py-4 md:text-lg md:px-10 transition duration-300 ease-in-out transform hover:scale-[0.99]"
                            >
                                Stay Tuned
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-[#F9F4EB]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Laboratory Scheduling -->
                    <div class="bg-white p-8 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="text-[#FD7C21] mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-[#4E413B]">Laboratory Scheduling</h3>
                        <p class="mt-2 text-[#4E413B]/70">Enables seamless system and scheduling updates for effective lab management.</p>
                    </div>

                    <!-- Resource Management -->
                    <div class="bg-white p-8 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="text-[#FD7C21] mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-[#4E413B]">Resource Management</h3>
                        <p class="mt-2 text-[#4E413B]/70">Efficient tracking tools and configurations for optimal resource allocation.</p>
                    </div>

                    <!-- Resource Distribution -->
                    <div class="bg-white p-8 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="text-[#FD7C21] mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-[#4E413B]">Resource Distribution</h3>
                        <p class="mt-2 text-[#4E413B]/70">Smart user access to the lab rooms and efficient utilization tracking.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- How it Works Section -->
        <div class="py-12 bg-[#FBFCF8]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-bold text-center mb-12 text-[#4E413B]">
                    How <span class="text-[#FD7C21]">LABERS</span> works for you.
                </h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Responsive Web Design -->
                    <div class="p-6 rounded-lg hover:bg-white hover:shadow-lg transform hover:scale-105 transition duration-300 flex h-[160px]">
                        <div class="flex items-start">
                            <div class="text-white">
                                <div class="bg-[#FD7C21] rounded-full p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6 flex flex-col">
                                <h3 class="text-lg font-medium text-[#4E413B]">Responsive Web Design</h3>
                                <p class="text-[#FD7C21] font-medium mt-1">Modern and adaptive interface</p>
                                <Link href="#" class="text-sm text-[#4E413B]/70 hover:text-[#FD7C21] mt-2">
                                    Find out more →
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Cloud Hosting -->
                    <div class="p-6 rounded-lg hover:bg-white hover:shadow-lg transform hover:scale-105 transition duration-300 flex h-[160px]">
                        <div class="flex items-start">
                            <div class="text-white">
                                <div class="bg-[#FD7C21] rounded-full p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6 flex flex-col">
                                <h3 class="text-lg font-medium text-[#4E413B]">Cloud Hosting</h3>
                                <p class="text-[#FD7C21] font-medium mt-1">Reliable and scalable platform</p>
                                <Link href="#" class="text-sm text-[#4E413B]/70 hover:text-[#FD7C21] mt-2">
                                    Find out more →
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Secured System -->
                    <div class="p-6 rounded-lg hover:bg-white hover:shadow-lg transform hover:scale-105 transition duration-300 flex h-[160px]">
                        <div class="flex items-start">
                            <div class="text-white">
                                <div class="bg-[#FD7C21] rounded-full p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6 flex flex-col">
                                <h3 class="text-lg font-medium text-[#4E413B]">Secured System</h3>
                                <p class="text-[#FD7C21] font-medium mt-1">Advanced data protection</p>
                                <Link href="#" class="text-sm text-[#4E413B]/70 hover:text-[#FD7C21] mt-2">
                                    Find out more →
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Data Analytics -->
                    <div class="p-6 rounded-lg hover:bg-white hover:shadow-lg transform hover:scale-105 transition duration-300 flex h-[160px]">
                        <div class="flex items-start">
                            <div class="text-white">
                                <div class="bg-[#FD7C21] rounded-full p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6 flex flex-col">
                                <h3 class="text-lg font-medium text-[#4E413B]">Data Analytics</h3>
                                <p class="text-[#FD7C21] font-medium mt-1">Insightful usage metrics</p>
                                <Link href="#" class="text-sm text-[#4E413B]/70 hover:text-[#FD7C21] mt-2">
                                    Find out more →
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-[#F9F4EB]">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    <div>
                        <h4 class="text-sm font-semibold text-[#4E413B] uppercase tracking-wider">LABERS</h4>
                        <p class="mt-4 text-base text-[#4E413B]/70">
                            GC-CCS platform for laboratory access booking and equipment reservation.
                        </p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-[#4E413B] uppercase tracking-wider">About Us</h4>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-[#4E413B]/70 hover:text-[#FD7C21]">
                                    Our Team
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-[#4E413B]/70 hover:text-[#FD7C21]">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-[#4E413B] uppercase tracking-wider">Legal</h4>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-[#4E413B]/70 hover:text-[#FD7C21]">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-[#4E413B]/70 hover:text-[#FD7C21]">
                                    Terms of Service
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-[#4E413B] uppercase tracking-wider">Support</h4>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-[#4E413B]/70 hover:text-[#FD7C21]">
                                    Help Center
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-[#4E413B]/70 hover:text-[#FD7C21]">
                                    Documentation
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <p class="text-base text-gray-400 text-center">
                        &copy; 2024-2025 LABERS. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>