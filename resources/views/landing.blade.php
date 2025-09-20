<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NephroConsult Exam Prep - Pass Your Consultant Exam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        
        /* -- Animated Gradient Background for Hero -- */
        .hero-bg {
            background: linear-gradient(-45deg, #1d4ed8, #2563eb, #3b82f6, #60a5fa);
            background-size: 400% 400%;
            animation: gradient-animation 15s ease infinite;
        }

        @keyframes gradient-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* -- Glassmorphism Effect for Login Card -- */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* -- CTA Button Pulse Animation -- */
        .cta-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        /* -- General Animations for Scroll -- */
        .animate-on-scroll {
            opacity: 0;
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .fade-in {
            transform: translateY(20px);
        }
        
        .fade-in-left {
            transform: translateX(-30px);
        }

        .fade-in-right {
            transform: translateX(30px);
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translate(0, 0);
        }

        /* Staggered animation for hero text */
        .hero-content > * {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUpFade 0.8s forwards;
        }
        .hero-content h2 { animation-delay: 0.2s; }
        .hero-content p { animation-delay: 0.4s; }
        .hero-content > div { animation-delay: 0.6s; }

        @keyframes slideUpFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-700">NephroPrep</h1>
            <a href="#login" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                Login
            </a>
        </div>
    </header>

    <!-- Hero Section -->
    <main>
        <section class="hero-bg py-24 md:py-32 text-white">
            <div class="container mx-auto px-6 text-center hero-content">
                <h2 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                    Your Path to Consultant Nephrologist
                </h2>
                <p class="mt-6 text-lg md:text-xl text-blue-100 max-w-3xl mx-auto">
                    Master the Saudi Commission for Health Specialties oral exam with targeted training, insider tips, and realistic simulations.
                </p>
                <div id="login" class="mt-12">
                    <div class="glass-card p-8 rounded-2xl shadow-xl max-w-lg mx-auto">
                        <h3 class="text-3xl font-bold mb-4">Begin Your Success Story</h3>
                        <p class="text-blue-200 mb-6">Log in now to unlock exclusive content and start preparing with the best.</p>
                        <button class="w-full bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg hover:bg-green-700 transition-transform duration-300 transform hover:scale-105 cta-pulse">
                            Login to Start Studying
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16 animate-on-scroll fade-in">
                    <h2 class="text-4xl font-bold text-gray-900">The Ultimate Prep Toolkit</h2>
                    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Everything you need to walk into your exam with complete confidence.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-10">
                    <!-- Feature 1 -->
                    <div class="animate-on-scroll fade-in bg-slate-100 p-8 rounded-2xl text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="mb-4 inline-flex items-center justify-center h-16 w-16 bg-blue-200 rounded-full">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold mb-2 text-gray-900">Exam Simulation</h3>
                        <p class="text-gray-600">Practice with oral exam scenarios that mirror the real thing.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div style="transition-delay: 200ms" class="animate-on-scroll fade-in bg-slate-100 p-8 rounded-2xl text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="mb-4 inline-flex items-center justify-center h-16 w-16 bg-green-200 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold mb-2 text-gray-900">All Topics Covered</h3>
                        <p class="text-gray-600">From CKD to transplantation, we've got you covered.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div style="transition-delay: 400ms" class="animate-on-scroll fade-in bg-slate-100 p-8 rounded-2xl text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="mb-4 inline-flex items-center justify-center h-16 w-16 bg-yellow-200 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold mb-2 text-gray-900">Tips & Tricks</h3>
                        <p class="text-gray-600">Learn the secrets to impress examiners and handle tough questions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About the Owner Section -->
        <section class="bg-slate-50 py-24">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="md:w-1/3 animate-on-scroll fade-in-left">
                        <img src="https://placehold.co/600x600/3B82F6/FFFFFF?text=Dr.+Hossam&font=sans" alt="Dr. Hossam Abohassan" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-2/3 p-8 md:p-12 animate-on-scroll fade-in-right" style="transition-delay: 200ms;">
                        <h2 class="text-3xl font-bold text-gray-900">A Message From Your Mentor</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            "Welcome! I created this platform out of a passion for helping fellow nephrologists succeed. Having been through the consultant exam process myself, I understand the challenges and anxieties you face. My goal is to equip you not just with knowledge, but with the confidence and strategic approach needed to excel in your oral exam. I'm here to guide you every step of the way. Let's achieve this milestone together."
                        </p>
                        <div class="mt-6">
                            <p class="text-xl font-bold text-blue-700">Dr. Hossam Abohassan</p>
                            <p class="text-gray-600">Nephrology Consultant</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold">Get In Touch</h3>
            <p class="mt-4 text-gray-400">For inquiries, please contact me via WhatsApp (for the fastest response):</p>
            <a href="https://wa.me/966539873567" target="_blank" class="mt-4 inline-flex items-center gap-2 text-lg font-semibold text-green-400 hover:text-green-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                </svg>
                +966 53 987 3567
            </a>
            <p class="mt-8 text-gray-500 text-sm">&copy; 2024 NephroPrep. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // This script adds a 'visible' class to elements when they scroll into view.
        // The CSS then handles the animation.
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add the 'visible' class to trigger the animation.
                        entry.target.classList.add('visible');
                        // Optional: Stop observing the element after it has become visible.
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1 // Animation triggers when 10% of the element is visible.
            });

            // Select all elements that should be animated on scroll.
            const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');
            elementsToAnimate.forEach(el => {
                observer.observe(el);
            });
        });
    </script>

</body>
</html>