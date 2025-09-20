<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NephroMap - Ace Your Oral Exam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-bg {
            background: linear-gradient(-45deg, #1e1b4b, #4c1d95, #4f46e5, #be185d);
            background-size: 400% 400%;
            animation: gradient-animation 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        /* Aurora effect for hero background */
        .hero-bg::before,
        .hero-bg::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background-image: radial-gradient(circle, rgba(192, 132, 252, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
        }

        .hero-bg::before {
            top: -200px;
            left: -200px;
            animation: aurora-one 20s infinite alternate;
        }

        .hero-bg::after {
            bottom: -200px;
            right: -200px;
            animation: aurora-two 20s infinite alternate-reverse;
        }

        @keyframes aurora-one {
            from { transform: translateX(-100px) translateY(50px) scale(0.8); }
            to { transform: translateX(100px) translateY(-50px) scale(1.2); }
        }

        @keyframes aurora-two {
            from { transform: translateX(50px) translateY(-80px) scale(0.8); }
            to { transform: translateX(-50px) translateY(80px) scale(1.2); }
        }

        @keyframes gradient-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .cta-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(217, 70, 239, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(217, 70, 239, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(217, 70, 239, 0); }
        }
        
        .animate-on-scroll {
            opacity: 0;
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            transform: translateY(20px);
        }
        
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Typing animation styles */
        .blinking-cursor::after {
            content: '_';
            font-weight: 700;
            display: inline-block;
            animation: blink 0.7s infinite;
            position: relative;
            top: -5px;
            left: 5px;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        
        #hero-title-container {
            min-height: 150px; /* Prevents layout shift during typing */
        }
        
        @media (min-width: 768px) {
            #hero-title-container {
                min-height: 200px;
            }
        }
    </style>
</head>
<body class="antialiased bg-slate-950 text-slate-200">

    <!-- Header -->
    <header class="bg-slate-900/60 backdrop-blur-sm sticky top-0 z-50 border-b border-white/10">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 text-white">
                <svg class="h-8 w-8 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5c-3.866 0-7 3.134-7 7 0 1.933.784 3.683 2.05 4.95a5.99 5.99 0 00-.413 2.321V21a.75.75 0 00.75.75h.75c.621 0 1.222-.22 1.684-.613.462-.393.84-.863 1.13-1.392a11.19 11.19 0 004.98-.012c.29.53.668 1 1.13 1.392.462.393 1.063.613 1.684.613h.75a.75.75 0 00.75-.75v-2.229c0-.859-.148-1.686-.413-2.471A6.974 6.974 0 0019 11.5c0-3.866-3.134-7-7-7z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9" />
                </svg>
                <span class="text-2xl font-bold">NephroMap</span>
            </a>

            <a href="<?php echo e(route('login')); ?>" class="bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-semibold py-2 px-6 rounded-lg hover:from-indigo-600 hover:to-fuchsia-600 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-indigo-500/30">
                Login
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-bg py-24 md:py-32 text-white">
            <div class="container mx-auto px-6 text-center relative z-10">
                <div id="hero-title-container">
                    <h2 id="hero-title" class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">
                        <!-- Text injected by JS -->
                    </h2>
                </div>
                <p class="mt-6 text-lg md:text-xl text-slate-300 max-w-3xl mx-auto">
                    The fastest way to prepare for the SCHS consultant exam. Master high-yield scenarios with expert guidance.
                </p>
                <div class="mt-12">
                    <div class="glass-card p-8 rounded-2xl max-w-lg mx-auto">
                        <h3 class="text-3xl font-bold mb-4 text-white">Start Training Now</h3>
                        <p class="text-slate-300 mb-6">Log in to unlock exclusive content and begin your path to success.</p>
                        <a href="<?php echo e(route('login')); ?>" class="inline-block w-full bg-fuchsia-600 text-white font-bold py-4 px-8 rounded-lg text-lg hover:bg-fuchsia-500 transition-transform duration-300 transform hover:scale-105 cta-pulse shadow-lg shadow-fuchsia-500/40">
                            Log in to Start Studying
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mentor Section -->
        <section id="mentor" class="py-24 bg-slate-950 relative overflow-hidden">
             <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[60rem] h-[60rem] bg-indigo-500/20 rounded-full blur-3xl" aria-hidden="true"></div>
            <div class="container mx-auto px-6 relative">
                <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12 bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-2xl shadow-black/30 p-8 border border-white/10 overflow-hidden">
                    <div class="flex-shrink-0 animate-on-scroll relative">
                         <div class="absolute -inset-2 rounded-full bg-gradient-to-br from-indigo-500 to-fuchsia-500 blur opacity-60"></div>
                        <img src="https://placehold.co/600x600/3B82F6/FFFFFF?text=Dr.+Hossam&font=sans" alt="Dr. Hossam Abohassan" class="relative w-48 h-48 md:w-56 md:h-56 rounded-full object-cover shadow-2xl border-4 border-slate-700">
                    </div>
                    <div class="text-center md:text-left animate-on-scroll" style="transition-delay: 200ms;">
                        <h2 class="text-3xl font-bold text-white">Meet Your Mentor</h2>
                        <p class="text-xl font-semibold text-indigo-400 mt-1">Dr. Hossam Abohassan</p>
                        <p class="mt-4 text-slate-300 leading-relaxed">
                            "I designed this platform to give you the practical wisdom and insider knowledge that textbooks miss. My goal is to help you internalize the mindset of a confident consultant before exam day. Let's get you certified."
                        </p>
                        <div class="mt-6">
                             <a href="https://wa.me/966539873567" target="_blank" class="inline-flex items-center gap-2 text-md font-semibold text-emerald-400 hover:text-emerald-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                </svg>
                                Contact on WhatsApp: +966 53 987 3567
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-white/10 py-10">
        <div class="container mx-auto px-6 text-center text-slate-500 text-sm">
            <p>&copy; 2024 NephroMap. All rights reserved.</p>
            <p class="mt-2">Designed for Saudi nephrologists determined to lead.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');
            elementsToAnimate.forEach(el => {
                observer.observe(el);
            });

            // --- Continuous Typing Animation ---
            const heroTitle = document.getElementById('hero-title');
            const phrases = [
                "Ace Your Nephrology Oral Exam",
                "Master Clinical Scenarios",
                "Conquer the SCHS Boards"
            ];
            let phraseIndex = 0;
            let charIndex = 0;
            let isDeleting = false;

            function typeLoop() {
                heroTitle.classList.add('blinking-cursor');
                const currentPhrase = phrases[phraseIndex];

                if (isDeleting) {
                    // Deleting text
                    heroTitle.textContent = currentPhrase.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    // Typing text
                    heroTitle.textContent = currentPhrase.substring(0, charIndex + 1);
                    charIndex++;
                }

                let typingSpeed = isDeleting ? 60 : 120;

                if (!isDeleting && charIndex === currentPhrase.length) {
                    // Pause at end of phrase
                    typingSpeed = 2000;
                    isDeleting = true;
                    heroTitle.classList.add('blinking-cursor');
                } else if (isDeleting && charIndex === 0) {
                    // Move to next phrase
                    isDeleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    typingSpeed = 500;
                }
                
                setTimeout(typeLoop, typingSpeed);
            }

            // Start the animation
            setTimeout(typeLoop, 500);
        });
    </script>

</body>
</html><?php /**PATH /homepages/38/d4299336130/htdocs/storage/framework/views/bd58b76e25e992fcf0b1a985538bc90e.blade.php ENDPATH**/ ?>