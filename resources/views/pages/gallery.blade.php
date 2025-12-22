<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Year Together - A Journey</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Dancing+Script:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FAFAF8',
                        gold: '#D4AF37',
                        'gold-light': '#E6C89C',
                        blush: '#FADADD',
                        sage: '#9CAF88',
                        paper: '#Fdfbf7',
                        ink: '#2C2C2C'
                    },
                    fontFamily: {
                        hand: ['Caveat', 'cursive'],
                        script: ['Dancing Script', 'cursive'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    backgroundImage: {
                        'paper-texture': "url('https://www.transparenttextures.com/patterns/cream-paper.png')",
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Styles for nuances Tailwind handles poorly */
        body {
            background-color: #FAFAF8;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E");
            overflow-x: hidden;
            color: #2C2C2C;
        }

        /* Polaroid Styling */
        .polaroid {
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: center;
            will-change: transform, box-shadow;
            backface-visibility: hidden;
        }

        .polaroid.active {
            transform: scale(1.05) rotate(0deg) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 20;
        }

        .polaroid.visited::after {
            content: '♥';
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #D4AF37;
            transform: rotate(15deg);
            opacity: 0.8;
        }

        /* SVG Path Styling */
        .path-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: visible;
        }

        .connection-path {
            fill: none;
            stroke: #C0C0C0;
            stroke-width: 2;
            stroke-dasharray: 8, 8;
            stroke-linecap: round;
            transition: stroke 1s ease;
        }

        .connection-path.active {
            stroke: #D4AF37;
            animation: dash 60s linear infinite; /* Slow movement of dash */
            filter: drop-shadow(0 0 3px rgba(212, 175, 55, 0.5));
        }

        /* Animated drawing of the path */
        .drawing-path {
            fill: none;
            stroke: #D4AF37;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-dasharray: 1000; /* Arbitrary large number */
            stroke-dashoffset: 1000;
            opacity: 0;
        }
        
        .drawing-path.animate {
            opacity: 1;
            animation: drawPath 1.5s ease-out forwards;
        }

        @keyframes drawPath {
            to { stroke-dashoffset: 0; }
        }

        /* Envelope Styles */
        .envelope-container {
            perspective: 1000px;
        }
        
        .envelope-flap {
            transform-origin: top;
            transition: transform 0.8s ease-in-out, z-index 0.8s;
        }

        .letter-paper {
            transform-origin: bottom center;
            transition: all 1s ease-in-out;
        }

        /* Particles */
        .particle {
            position: absolute;
            pointer-events: none;
            animation: rise 2s ease-out forwards;
        }

        @keyframes rise {
            0% { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-50px) scale(0); }
        }
        
        /* Removed the restrictive mobile margin CSS to allow JS zig-zag logic to work */
    </style>
</head>
<x-navbar/>
<body class="antialiased selection:bg-gold selection:text-white">

    <!-- Loading Overlay -->
    <div id="loader" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-cream transition-opacity duration-1000">
        <div class="animate-spin text-gold mb-4">
            <i data-lucide="compass" size="48"></i>
        </div>
        <p class="font-script text-2xl text-stone-600 animate-pulse">Preparing memories...</p>
    </div>

    <!-- Main Content Wrapper -->
    <main class="relative w-full min-h-screen pb-40 overflow-hidden">
        
        <!-- Decorative Background Elements -->
        <div class="fixed top-20 left-10 opacity-20 rotate-12 pointer-events-none">
            <i data-lucide="flower-2" class="text-sage w-24 h-24"></i>
        </div>
        <div class="fixed bottom-40 right-10 opacity-10 -rotate-12 pointer-events-none">
            <i data-lucide="heart" class="text-blush w-32 h-32"></i>
        </div>

        <div class="max-w-[1200px] mx-auto px-4 relative pt-20" id="main-container">
            
            <!-- Header -->
            <header class="text-center mb-20 relative z-10">
                <p class="font-hand text-xl text-stone-500 mb-2">Our First Year</p>
                <h1 class="font-serif text-5xl md:text-7xl text-stone-800 mb-4 tracking-tight">One Year of <span class="text-gold italic">Us</span></h1>
                <p class="font-script text-2xl text-stone-600" id="start-instruction">Follow the path to find your treasure...</p>
            </header>

            <!-- SVG Layer for Curves -->
            <!-- This sits behind photos but on top of background -->
            <svg id="path-svg" class="path-svg">
                <defs>
                    <linearGradient id="gold-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#C0C0C0;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#D4AF37;stop-opacity:1" />
                    </linearGradient>
                    <filter id="glow">
                        <feGaussianBlur stdDeviation="2.5" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                <!-- Paths will be injected here by JS -->
            </svg>

            <!-- Photo Gallery Container -->
            <div id="gallery" class="relative flex flex-col gap-0 w-full min-h-[1000px]">
                <!-- Photos injected by JS -->
            </div>

            <!-- The Envelope Destination -->
            <div id="destination" class="relative mt-40 flex flex-col items-center justify-center min-h-[500px]">
                
                <!-- Instruction Text -->
                <div id="envelope-instruction" class="mb-8 h-8 font-serif text-xl text-gold italic transition-all duration-500 opacity-0"></div>

                <!-- The Envelope Itself -->
                <div id="envelope-wrapper" class="relative w-72 h-48 md:w-96 md:h-64 cursor-pointer transition-transform duration-500 hover:scale-105">
                    
                    <!-- Envelope Body (Back) -->
                    <div class="absolute inset-0 bg-[#f0eee6] shadow-2xl rounded-sm border border-[#e0ddd5]"></div>
                    
                    <!-- Letter Inside (Hidden initially) -->
                    <div id="letter-preview" class="absolute left-4 right-4 top-2 bottom-2 bg-white shadow-sm z-10 transition-transform duration-700 translate-y-full opacity-0"></div>

                    <!-- Envelope Flap (Triangle) -->
                    <div id="flap" class="absolute top-0 left-0 w-0 h-0 border-l-[144px] md:border-l-[192px] border-r-[144px] md:border-r-[192px] border-t-[100px] md:border-t-[130px] border-l-transparent border-r-transparent border-t-[#e6e2d8] origin-top z-20 envelope-flap drop-shadow-md"></div>
                    
                    <!-- Bottom Fold -->
                    <div class="absolute bottom-0 left-0 w-0 h-0 border-l-[144px] md:border-l-[192px] border-r-[144px] md:border-r-[192px] border-b-[100px] md:border-b-[130px] border-l-transparent border-r-transparent border-b-[#fcfaf5] z-30 pointer-events-none"></div>
                    
                    <!-- Side Folds -->
                    <div class="absolute top-0 left-0 w-0 h-0 border-t-[96px] md:border-t-[128px] border-b-[96px] md:border-b-[128px] border-l-[140px] md:border-l-[180px] border-t-transparent border-b-transparent border-l-[#f4f1e9] z-20 pointer-events-none"></div>
                    <div class="absolute top-0 right-0 w-0 h-0 border-t-[96px] md:border-t-[128px] border-b-[96px] md:border-b-[128px] border-r-[140px] md:border-r-[180px] border-t-transparent border-b-transparent border-r-[#f4f1e9] z-20 pointer-events-none"></div>

                    <!-- Wax Seal -->
                    <div id="wax-seal" class="absolute top-[35%] left-1/2 -translate-x-1/2 z-40 w-16 h-16 bg-red-800 rounded-full shadow-lg flex items-center justify-center cursor-pointer transition-transform hover:scale-110 hidden">
                        <div class="w-12 h-12 border-2 border-red-900/50 rounded-full flex items-center justify-center">
                            <span class="font-serif text-red-950 font-bold text-xl">♥</span>
                        </div>
                    </div>

                    <!-- Ribbon -->
                    <div id="ribbon" class="absolute inset-0 z-50 flex items-center justify-center pointer-events-auto">
                        <div class="w-full h-8 bg-blush/80 shadow-sm absolute top-1/2 -translate-y-1/2"></div>
                        <div class="w-8 h-full bg-blush/80 shadow-sm absolute left-1/2 -translate-x-1/2"></div>
                        <!-- Bow Knot (Interactive) -->
                        <div id="bow-knot" class="absolute w-16 h-16 bg-blush rounded-full shadow-md cursor-grab active:cursor-grabbing flex items-center justify-center hover:bg-pink-300 transition-colors">
                            <i data-lucide="gift" class="text-white w-8 h-8"></i>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <!-- Full Screen Letter Modal -->
    <div id="letter-overlay" class="fixed inset-0 bg-black/60 z-[60] opacity-0 pointer-events-none transition-opacity duration-1000 flex items-center justify-center p-4">
        <div id="letter-content" class="bg-[#FDFBF7] w-full max-w-2xl p-8 md:p-12 shadow-2xl rounded-sm transform scale-90 opacity-0 transition-all duration-1000 relative max-h-[90vh] overflow-y-auto custom-scrollbar">
            
            <!-- Close Button -->
            <button id="close-letter" class="absolute top-4 right-4 text-stone-400 hover:text-stone-800 transition-colors">
                <i data-lucide="x" size="24"></i>
            </button>

            <!-- Decorative Header -->
            <div class="text-right font-serif text-stone-400 italic mb-8">December 20, 2025</div>

            <div class="font-script text-3xl md:text-4xl text-stone-800 mb-8">My Dearest Love,</div>

            <div class="font-serif text-lg md:text-xl text-stone-600 leading-relaxed space-y-6">
                <p>Can you believe it has been a whole year? 365 days of laughter, adventure, and growing together.</p>
                <p>Looking back at these photos, I realize that my favorite place in the world is simply wherever you are. From our first date to our quiet mornings with coffee, every moment has been a treasure.</p>
                <p>You are my best friend, my confidant, and my greatest adventure. Thank you for being you, and for choosing me every single day.</p>
                <p>Here's to year one, and to all the beautiful years still to come.</p>
            </div>

            <div class="mt-12 text-right">
                <div class="font-script text-3xl text-stone-800">Forever Yours,</div>
                <div class="font-hand text-2xl text-stone-600 mt-2">Alex</div>
                <div class="text-red-800 text-2xl mt-2 rotate-12 inline-block">💋</div>
            </div>

            <!-- Margin Doodles -->
            <div class="absolute bottom-10 left-10 opacity-10 pointer-events-none">
                <i data-lucide="heart" size="64"></i>
            </div>
        </div>
    </div>

    <script>
        // Initialize Icons
        lucide.createIcons();

        // --- Data: Memories ---
        // REPLACE IMAGE URLS WITH YOUR OWN
        const memories = [
            {
                id: 1,
                src: 'http://fujisou-ainos.sub.jp/journey/img/Photo Oct 27 2025, 15 46 22.png',
                caption: "Where it all began",
                date: "1st month together အရာအားလုံးစတင်ခဲ့တဲ့အချိန်လေး",
                rotate: "-3deg"
            },
            {
                id: 2,
                src: 'https://images.unsplash.com/photo-1522673607200-1645062cd958?q=80&w=1000&auto=format&fit=crop',
                caption: "Our first adventure",
                date: "Month 3",
                rotate: "4deg"
            },
            {
                id: 3,
                src: 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=1000&auto=format&fit=crop',
                caption: "The day you said yes",
                date: "Month 5",
                rotate: "-2deg"
            },
            {
                id: 4,
                src: 'https://images.unsplash.com/photo-1621112904887-419379ce6824?q=80&w=1000&auto=format&fit=crop',
                caption: "Sunset by the pier",
                date: "Month 7",
                rotate: "5deg"
            },
            {
                id: 5,
                src: 'https://images.unsplash.com/photo-1529619768328-e37af76c6fe5?q=80&w=1000&auto=format&fit=crop',
                caption: "Our quiet place",
                date: "Month 9",
                rotate: "-4deg"
            },
            {
                id: 6,
                src: 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?q=80&w=1000&auto=format&fit=crop',
                caption: "Celebration night",
                date: "Month 11",
                rotate: "2deg"
            }
        ];

        // --- State ---
        let currentStep = 0;
        let isRibbonUntied = false;
        let isSealBroken = false;
        let isLetterOpen = false;

        // --- DOM Elements ---
        const gallery = document.getElementById('gallery');
        const svgContainer = document.getElementById('path-svg');
        const envelopeWrapper = document.getElementById('envelope-wrapper');
        const bowKnot = document.getElementById('bow-knot');
        const ribbon = document.getElementById('ribbon');
        const waxSeal = document.getElementById('wax-seal');
        const instructionText = document.getElementById('envelope-instruction');
        const letterOverlay = document.getElementById('letter-overlay');
        const letterContent = document.getElementById('letter-content');
        const closeLetterBtn = document.getElementById('close-letter');
        const flap = document.getElementById('flap');

        // --- Initialization ---
        window.onload = () => {
            // Remove Loader
            setTimeout(() => {
                document.getElementById('loader').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('loader').remove();
                    initGallery();
                }, 1000);
            }, 1500);
        };

        // --- Gallery Generation ---
        function initGallery() {
            memories.forEach((memory, index) => {
                const isLeft = index % 2 === 0;
                
                // Random vertical spacing (between 100px and 250px)
                const marginTop = index === 0 ? 0 : Math.floor(Math.random() * 150) + 100;
                
                const card = document.createElement('div');
                card.id = `memory-${index}`;
                // Common classes
                card.className = `polaroid absolute bg-white p-3 pb-12 shadow-lg w-64 md:w-80 cursor-pointer transition-all duration-500 opacity-50 filter grayscale hover:grayscale-0 hover:opacity-100`;
                
                // Positioning Logic (Zigzag)
                // Left aligned: left: 10% or centered on mobile
                // Right aligned: right: 10% or centered on mobile
                // We use flex-col for mobile flow, but absolute positioning logic for desktop zigzag
                
                card.style.position = 'relative'; // Reset to relative for flow
                card.style.marginTop = `${marginTop}px`;
                card.style.transform = `rotate(${memory.rotate})`;
                
                // Horizontal alignment classes
                if (window.innerWidth >= 768) {
                    card.style.marginLeft = isLeft ? '10%' : 'auto';
                    card.style.marginRight = isLeft ? 'auto' : '10%';
                } else {
                    // Mobile: Slightly alternating
                    // Using 2% instead of 5% to allow more space on small screens while keeping zigzag
                    card.style.marginLeft = isLeft ? '2%' : 'auto';
                    card.style.marginRight = isLeft ? 'auto' : '2%';
                }

                // Inner HTML
                card.innerHTML = `
                    <div class="relative w-full aspect-[4/5] overflow-hidden bg-gray-100">
                        <img src="${memory.src}" alt="${memory.caption}" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-hand text-2xl text-ink">${memory.caption}</p>
                        <p class="font-sans text-xs text-stone-400 uppercase tracking-widest mt-1">${memory.date}</p>
                    </div>
                `;

                // Interaction
                card.addEventListener('click', () => handlePhotoClick(index));
                
                gallery.appendChild(card);
            });

            // Activate first photo
            setTimeout(() => {
                activatePhoto(0);
                drawCurves(); // Draw initial curves (invisible)
            }, 500);

            // Resize listener for curves
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    // Reset margins for responsive layout
                    const cards = document.querySelectorAll('.polaroid');
                    cards.forEach((card, index) => {
                         const isLeft = index % 2 === 0;
                         if (window.innerWidth >= 768) {
                            card.style.marginLeft = isLeft ? '10%' : 'auto';
                            card.style.marginRight = isLeft ? 'auto' : '10%';
                        } else {
                            // Mobile Update: Same 2% logic
                            card.style.marginLeft = isLeft ? '2%' : 'auto';
                            card.style.marginRight = isLeft ? 'auto' : '2%';
                        }
                    });
                    drawCurves();
                }, 200);
            });
        }

        // --- Bezier Curve Logic ---
        function drawCurves() {
            svgContainer.innerHTML = ''; // Clear existing
            
            // Draw paths between photos
            for (let i = 0; i < memories.length - 1; i++) {
                createCurve(i, i + 1, false);
            }
            
            // Draw path from last photo to envelope
            createCurve(memories.length - 1, 'destination', true);
        }

        function createCurve(fromIdx, toIdx, isLast) {
            const startEl = document.getElementById(`memory-${fromIdx}`);
            const endEl = isLast ? document.getElementById('destination') : document.getElementById(`memory-${toIdx}`);
            
            if (!startEl || !endEl) return;

            const startRect = startEl.getBoundingClientRect();
            const endRect = endEl.getBoundingClientRect();
            const containerRect = document.getElementById('main-container').getBoundingClientRect();

            // Calculate coordinates relative to the container
            const x1 = (startRect.left + startRect.width / 2) - containerRect.left;
            const y1 = (startRect.bottom - 20) - containerRect.top; // Start slightly inside photo
            const x2 = (endRect.left + endRect.width / 2) - containerRect.left;
            const y2 = isLast ? (endRect.top + 50) - containerRect.top : (endRect.top + 20) - containerRect.top;

            // Bezier Control Points
            const distY = y2 - y1;
            const cp1x = x1;
            const cp1y = y1 + (distY * 0.5);
            const cp2x = x2;
            const cp2y = y2 - (distY * 0.5);

            const pathString = `M ${x1} ${y1} C ${cp1x} ${cp1y}, ${cp2x} ${cp2y}, ${x2} ${y2}`;

            // Create Background Path (Dotted)
            const bgPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            bgPath.setAttribute("d", pathString);
            bgPath.setAttribute("class", "connection-path");
            bgPath.id = `path-bg-${fromIdx}`;
            
            // Create Foreground Path (Animated Gold)
            const fgPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
            fgPath.setAttribute("d", pathString);
            fgPath.setAttribute("class", "drawing-path");
            fgPath.id = `path-fg-${fromIdx}`;
            
            // Calculate length for animation
            const length = fgPath.getTotalLength();
            fgPath.style.strokeDasharray = length;
            fgPath.style.strokeDashoffset = length;

            svgContainer.appendChild(bgPath);
            svgContainer.appendChild(fgPath);
        }

        // --- Interaction Logic ---
        function activatePhoto(index) {
            const card = document.getElementById(`memory-${index}`);
            if(!card) return;

            card.classList.remove('opacity-50', 'filter', 'grayscale');
            card.classList.add('active');
            
            // Add pulse animation to next items
            const nextCard = document.getElementById(`memory-${index+1}`);
            if(nextCard) {
                nextCard.classList.add('animate-pulse-slow');
            } else if (index === memories.length - 1) {
                // Last photo active, prepare envelope
                document.getElementById('destination').scrollIntoView({ behavior: 'smooth', block: 'center' });
                prepareEnvelopeInteraction();
            }
        }

        function handlePhotoClick(index) {
            // Only allow clicking the immediate next step or previously visited
            if (index > currentStep + 1) return;
            
            // If clicking current or previous, just focus
            if (index <= currentStep) {
                // Focus logic
            }

            // Logic for progressing
            if (index === currentStep) {
                // Mark current as visited visually
                document.getElementById(`memory-${index}`).classList.add('visited');
                
                // Animate path to NEXT
                const nextPath = document.getElementById(`path-fg-${index}`);
                if (nextPath) {
                    nextPath.classList.add('animate');
                    
                    // Wait for animation then activate next photo
                    setTimeout(() => {
                        currentStep++;
                        activatePhoto(currentStep);
                        // Scroll to next
                        const nextEl = index === memories.length - 1 ? document.getElementById('destination') : document.getElementById(`memory-${currentStep}`);
                        nextEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 1500);
                }
            }
        }

        // --- Envelope Interactions ---

        function prepareEnvelopeInteraction() {
            instructionText.innerText = "Untie the ribbon...";
            instructionText.classList.remove('opacity-0');
            instructionText.classList.add('animate-pulse');
            
            // Add Drag Logic to Bow
            setupRibbonDrag();
        }

        function setupRibbonDrag() {
            let isDragging = false;
            let startX = 0;
            const threshold = 100; // px to drag to unlock

            const startDrag = (e) => {
                isDragging = true;
                startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                bowKnot.style.transition = 'none';
            };

            const doDrag = (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const currentX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                const delta = currentX - startX;
                
                // Visual feedback
                bowKnot.style.transform = `translateX(${delta}px)`;

                // Unlock condition
                if (Math.abs(delta) > threshold) {
                    completeUntie();
                    isDragging = false;
                }
            };

            const endDrag = () => {
                if (!isDragging) return;
                isDragging = false;
                // Snap back if not threshold met
                bowKnot.style.transition = 'transform 0.5s ease';
                bowKnot.style.transform = 'translateX(0)';
            };

            bowKnot.addEventListener('mousedown', startDrag);
            bowKnot.addEventListener('touchstart', startDrag);
            
            window.addEventListener('mousemove', doDrag);
            window.addEventListener('touchmove', doDrag, { passive: false });
            
            window.addEventListener('mouseup', endDrag);
            window.addEventListener('touchend', endDrag);
        }

        function completeUntie() {
            if (isRibbonUntied) return;
            isRibbonUntied = true;
            
            // Ribbon Animation
            ribbon.style.transition = 'all 1s ease';
            ribbon.style.opacity = '0';
            ribbon.style.transform = 'translateY(50px) scale(0.8)';
            setTimeout(() => ribbon.remove(), 1000);

            // Change State to Seal
            instructionText.style.opacity = '0';
            setTimeout(() => {
                instructionText.innerText = "Break the seal...";
                instructionText.style.opacity = '1';
                waxSeal.classList.remove('hidden');
                // Pop in animation
                waxSeal.animate([
                    { transform: 'translate(-50%, -50%) scale(0)' },
                    { transform: 'translate(-50%, -50%) scale(1)' }
                ], { duration: 500, easing: 'cubic-bezier(0.175, 0.885, 0.32, 1.275)' });
            }, 500);

            waxSeal.addEventListener('click', breakSeal);
        }

        function breakSeal() {
            if (isSealBroken) return;
            isSealBroken = true;

            // Crack Animation (simulated via CSS classes/particles)
            createParticles(waxSeal);
            
            waxSeal.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
            waxSeal.style.transform = 'translate(-50%, -50%) scale(1.5)';
            waxSeal.style.opacity = '0';
            
            instructionText.style.opacity = '0';
            
            setTimeout(() => {
                waxSeal.remove();
                openEnvelope();
            }, 300);
        }

        function createParticles(element) {
            const rect = element.getBoundingClientRect();
            for(let i=0; i<10; i++) {
                const p = document.createElement('div');
                p.className = 'w-2 h-2 bg-red-800 absolute rounded-full particle';
                p.style.left = (rect.left + rect.width/2) + 'px';
                p.style.top = (rect.top + rect.height/2) + 'px';
                // Randomize direction
                const x = (Math.random() - 0.5) * 100;
                const y = (Math.random() - 0.5) * 100;
                p.style.setProperty('--x', `${x}px`);
                p.style.setProperty('--y', `${y}px`);
                document.body.appendChild(p);
                setTimeout(() => p.remove(), 1000);
            }
        }

        function openEnvelope() {
            // 1. Lift Flap
            flap.style.transform = 'rotateX(180deg)';
            flap.style.zIndex = '1'; // Move behind letter
            
            // 2. Wait, then Show Letter Overlay
            setTimeout(() => {
                showLetter();
            }, 800);
        }

        function showLetter() {
            letterOverlay.classList.remove('pointer-events-none');
            letterOverlay.classList.remove('opacity-0');
            
            setTimeout(() => {
                letterContent.classList.remove('scale-90', 'opacity-0');
                letterContent.classList.add('scale-100', 'opacity-100');
            }, 300);
        }

        closeLetterBtn.addEventListener('click', () => {
            letterContent.classList.remove('scale-100', 'opacity-100');
            letterContent.classList.add('scale-90', 'opacity-0');
            
            setTimeout(() => {
                letterOverlay.classList.add('opacity-0', 'pointer-events-none');
                // Reset flap for re-opening fun?
                // For now, leave open
            }, 500);
        });

    </script>
    <x-footer/>
</body>
</html>