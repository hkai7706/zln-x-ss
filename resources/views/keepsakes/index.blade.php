<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Our Love Keepsakes 💕</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans:wght@400;600&family=Caveat:wght@400;700&family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <style>
       

        :root {
            --primary: #FF1493;
            --secondary: #FF69B4;
            --accent: #FFB6C1;
            --background: #FFF0F5;
            --text: #333333;
            --card-bg: #FFFFFF;
            --timeline: #FFE4E1;
        }

     

        /* Floating hearts background */
        .floating-heart {
            position: fixed;
            font-size: 30px;
            opacity: 0.1;
            animation: floatHeart 20s infinite ease-in-out;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes floatHeart {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(90deg); }
            50% { transform: translateY(-60px) rotate(180deg); }
            75% { transform: translateY(-30px) rotate(270deg); }
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Header */
        header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(255, 20, 147, 0.2);
        }

        .subtitle {
            font-family: 'Caveat', cursive;
            font-size: 1.5rem;
            color: var(--secondary);
        }

        /* Navigation Tabs */
        .nav-tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 25px;
            background: white;
            border: 2px solid var(--accent);
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary);
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 20, 147, 0.1);
        }

        .tab-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 20, 147, 0.3);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-color: var(--primary);
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 20, 147, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--accent);
        }

        .btn-secondary:hover {
            background: var(--accent);
            color: white;
        }

        .search-input, .filter-select {
            padding: 12px 20px;
            border: 2px solid var(--accent);
            border-radius: 25px;
            font-size: 1rem;
            background: white;
            color: var(--text);
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input {
            width: 300px;
            max-width: 100%;
        }

        .search-input:focus, .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 20, 147, 0.1);
        }

        /* View Sections */
        .view-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .view-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* MASONRY GRID */
        .masonry-grid {
            column-count: 3;
            column-gap: 30px;
            padding: 20px 0;
        }

        @media (max-width: 1200px) {
            .masonry-grid { column-count: 2; }
            h1 { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            .masonry-grid { column-count: 1; }
            h1 { font-size: 2rem; }
            .search-input { width: 100%; }
        }

        .keepsake-card {
            break-inside: avoid;
            margin-bottom: 30px;
            position: relative;
            animation: fadeInUp 0.6s ease both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Stagger animation delays */
        .keepsake-card:nth-child(1) { animation-delay: 0.1s; }
        .keepsake-card:nth-child(2) { animation-delay: 0.2s; }
        .keepsake-card:nth-child(3) { animation-delay: 0.3s; }
        .keepsake-card:nth-child(4) { animation-delay: 0.4s; }
        .keepsake-card:nth-child(5) { animation-delay: 0.5s; }
        .keepsake-card:nth-child(6) { animation-delay: 0.6s; }

        /* POLAROID STYLE */
        .polaroid {
            background: white;
            padding: 15px;
            padding-bottom: 70px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15), 0 3px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            transform: rotate(-2deg);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            overflow: visible;
        }

        .keepsake-card:nth-child(even) .polaroid {
            transform: rotate(2deg);
        }

        .keepsake-card:nth-child(3n) .polaroid {
            transform: rotate(-3deg);
        }

        .keepsake-card:nth-child(4n) .polaroid {
            transform: rotate(1.5deg);
        }

        .polaroid:hover {
            transform: rotate(0deg) translateY(-15px) scale(1.03);
            box-shadow: 0 25px 50px rgba(255, 20, 147, 0.25), 0 10px 20px rgba(255, 20, 147, 0.15);
            z-index: 10;
        }

        .polaroid-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 3px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--timeline) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            position: relative;
            overflow: hidden;
        }

        .polaroid-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .polaroid:hover .polaroid-image img {
            transform: scale(1.05);
        }

        .polaroid-image .placeholder-emoji {
            font-size: 5rem;
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.1));
        }

        .polaroid-content {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
        }

        .polaroid-title {
            font-family: 'Caveat', cursive;
            font-size: 1.4rem;
            color: var(--text);
            margin-bottom: 5px;
            font-weight: 700;
            text-align: center;
        }

        .polaroid-date {
            font-family: 'Caveat', cursive;
            font-size: 1.1rem;
            color: var(--secondary);
            text-align: center;
        }

        .category-badge {
            position: absolute;
            top: 25px;
            left: 25px;
            padding: 6px 14px;
            background: var(--primary);
            color: white;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 8px rgba(255, 20, 147, 0.3);
            z-index: 2;
        }

        .favorite-icon {
            position: absolute;
            top: 25px;
            right: 25px;
            font-size: 1.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .favorite-icon:hover {
            transform: scale(1.3) rotate(15deg);
        }

        .favorite-icon.active {
            animation: heartBeat 0.6s ease;
        }

        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            20%, 60% { transform: scale(1.3); }
            40%, 80% { transform: scale(1.1); }
        }

        .lock-icon {
            position: absolute;
            bottom: 80px;
            right: 25px;
            font-size: 1.2rem;
            color: var(--primary);
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        /* TIMELINE VIEW */
        .timeline-container {
            position: relative;
            padding: 40px 0;
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--timeline), var(--accent));
            transform: translateX(-50%);
        }

        .timeline-year {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin: 40px 0 20px;
            position: relative;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 50px;
            position: relative;
            animation: slideIn 0.6s ease both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .timeline-item:nth-child(even) {
            animation: slideInRight 0.6s ease both;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .timeline-content {
            width: 45%;
            padding: 20px;
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            top: 30px;
            width: 20px;
            height: 20px;
            background: var(--primary);
            border-radius: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 0 8px rgba(255, 20, 147, 0.2);
            animation: pulse 2s ease-in-out infinite;
            z-index: 2;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 8px rgba(255, 20, 147, 0.2);
            }
            50% {
                box-shadow: 0 0 0 15px rgba(255, 20, 147, 0.1);
            }
        }

        .timeline-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .timeline-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(255, 20, 147, 0.2);
        }

        /* CALENDAR VIEW */
        .calendar-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .calendar-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary);
        }

        .calendar-nav {
            display: flex;
            gap: 15px;
        }

        .calendar-nav button {
            padding: 10px 20px;
            background: var(--accent);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
        }

        .calendar-nav button:hover {
            background: var(--primary);
            transform: scale(1.05);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            color: var(--primary);
            padding: 10px;
            font-size: 0.9rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: var(--background);
            font-weight: 600;
        }

        .calendar-day:hover {
            background: var(--accent);
            color: white;
            transform: scale(1.1);
        }

        .calendar-day.has-memory {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);
        }

        .calendar-day.has-memory::after {
            content: '💕';
            position: absolute;
            bottom: 2px;
            right: 2px;
            font-size: 0.8rem;
        }

        .calendar-day.empty {
            opacity: 0.3;
            cursor: default;
        }

        .calendar-day.empty:hover {
            background: var(--background);
            color: var(--text);
            transform: none;
        }

        /* MODALS */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: slideUp 0.4s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            cursor: pointer;
            color: var(--text);
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            color: var(--primary);
            transform: rotate(90deg);
        }

        .modal-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--accent);
            border-radius: 10px;
            font-size: 1rem;
            font-family: 'Open Sans', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 20, 147, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .image-upload-area {
            border: 3px dashed var(--accent);
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--background);
        }

        .image-upload-area:hover {
            border-color: var(--primary);
            background: white;
        }

        .image-upload-area.has-image {
            border-style: solid;
            border-color: var(--primary);
            padding: 0;
        }

        .image-preview {
            max-width: 100%;
            border-radius: 10px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            cursor: pointer;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--text);
            opacity: 0.7;
            margin-bottom: 30px;
        }

        /* Loading State */
        .loading {
            text-align: center;
            padding: 60px 20px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--timeline);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            z-index: 2000;
            display: none;
            animation: slideInRight 0.4s ease;
            border-left: 5px solid var(--primary);
        }

        .toast.active {
            display: block;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toast.success {
            border-left-color: #10b981;
        }

        .toast.error {
            border-left-color: #ef4444;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .timeline-item {
                flex-direction: column !important;
            }

            .timeline-content {
                width: 100%;
            }

            .timeline-dot {
                left: 20px;
            }

            .timeline-line {
                left: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .modal-content {
                padding: 30px 20px;
            }

            .calendar-grid {
                gap: 5px;
            }

            .calendar-day {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
  <x-navbar/>
    <!-- Floating hearts -->
    <div class="floating-heart" style="left: 5%; top: 10%; animation-delay: 0s;">💕</div>
    <div class="floating-heart" style="left: 85%; top: 15%; animation-delay: 2s;">💖</div>
    <div class="floating-heart" style="left: 15%; top: 70%; animation-delay: 4s;">💗</div>
    <div class="floating-heart" style="left: 75%; top: 80%; animation-delay: 6s;">💝</div>
    <div class="floating-heart" style="left: 50%; top: 50%; animation-delay: 8s;">💘</div>

    <div class="container">
        <!-- Header -->
        <header>
            <h1>💕 Our Love Keepsakes</h1>
            <p class="subtitle">Capturing our beautiful journey together</p>
        </header>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="tab-btn active" data-view="masonry">📸 Gallery</button>
            <button class="tab-btn" data-view="timeline">⏱️ Timeline</button>
            <button class="tab-btn" data-view="calendar">📅 Calendar</button>
            <button class="tab-btn" data-view="favorites">⭐ Favorites</button>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <button class="btn" onclick="openAddModal()">+ Add Keepsake</button>
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search memories...">
            <select class="filter-select" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories as $key => $category)
                <option value="{{ $key }}">{{ $category['emoji'] }} {{ $category['label'] }}</option>
                @endforeach
            </select>
            <button class="btn btn-secondary" onclick="exportKeepsakes()">📥 Export</button>
        </div>

        <!-- Loading State -->
        <div class="loading" id="loadingState" style="display: none;">
            <div class="spinner"></div>
            <p>Loading your precious memories...</p>
        </div>

        <!-- Masonry View -->
        <div class="view-section active" id="masonryView">
            <div class="masonry-grid" id="masonryGrid">
                <!-- Cards will be loaded here -->
            </div>
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-state-icon">💝</div>
                <h3>No Keepsakes Yet</h3>
                <p>Start capturing your beautiful moments together!</p>
                <button class="btn" onclick="openAddModal()">Create Your First Keepsake</button>
            </div>
        </div>

        <!-- Timeline View -->
        <div class="view-section" id="timelineView">
            <div class="timeline-container" id="timelineContainer">
                <!-- Timeline items will be loaded here -->
            </div>
        </div>

        <!-- Calendar View -->
        <div class="view-section" id="calendarView">
            <div class="calendar-container">
                <div class="calendar-header">
                    <h2 id="calendarMonth">December 2024</h2>
                    <div class="calendar-nav">
                        <button onclick="previousMonth()">◀ Prev</button>
                        <button onclick="nextMonth()">Next ▶</button>
                    </div>
                </div>
                <div class="calendar-grid" id="calendarGrid">
                    <!-- Calendar will be generated here -->
                </div>
            </div>
        </div>

    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal('addModal')">&times;</span>
            <h2 id="modalTitle">✨ Create New Keepsake</h2>
            <form id="keepsakeForm" onsubmit="saveKeepsake(event)">
                <input type="hidden" id="keepsakeId">
                
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" id="title" required placeholder="Our First Date">
                </div>

                <div class="form-group">
                    <label>Date *</label>
                    <input type="date" id="memory_date" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Category *</label>
                        <select id="category" required>
                            @foreach($categories as $key => $category)
                            <option value="{{ $key }}">{{ $category['emoji'] }} {{ $category['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mood</label>
                        <select id="mood">
                            <option value="">Select mood...</option>
                            <option value="😍">😍 Love</option>
                            <option value="🥰">🥰 Adoring</option>
                            <option value="😊">😊 Happy</option>
                            <option value="🤗">🤗 Excited</option>
                            <option value="😌">😌 Peaceful</option>
                            <option value="🥺">🥺 Emotional</option>
                            <option value="😂">😂 Joyful</option>
                            <option value="🌟">🌟 Special</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" placeholder="Tell the story of this special moment..."></textarea>
                </div>

                <div class="form-group">
                    <label>Photo</label>
                    <div class="image-upload-area" id="imageUploadArea" onclick="document.getElementById('imageInput').click()">
                        <input type="file" id="imageInput" accept="image/*" style="display: none;" onchange="handleImageSelect(event)">
                        <div id="uploadPrompt">
                            <p style="font-size: 3rem; margin-bottom: 10px;">📷</p>
                            <p>Click or drag to upload a photo</p>
                        </div>
                        <img id="imagePreview" class="image-preview" style="display: none;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Your Names (Optional)</label>
                    <input type="text" id="created_by" placeholder="John & Jane">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_favorite">
                            <label for="is_favorite">⭐ Mark as Favorite</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_private" onchange="togglePasswordField()">
                            <label for="is_private">🔒 Make Private</label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="passwordGroup" style="display: none;">
                    <label>Password *</label>
                    <input type="password" id="password" placeholder="Enter password to protect this memory">
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">💕 Save Keepsake</button>
            </form>
        </div>
    </div>

    <!-- View Detail Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal('viewModal')">&times;</span>
            <div id="viewModalContent">
                <!-- Content loaded dynamically -->
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <p id="toastMessage"></p>
    </div>

    <script>
        // Global state
        let keepsakes = [];
        let currentView = 'masonry';
        let currentFilter = { category: '', mood: '', search: '', favorites: false };
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth() + 1;
        let currentImageBase64 = null;

        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadKeepsakes();
            setupEventListeners();
            generateCalendar(currentYear, currentMonth);
        });

        // Setup event listeners
        function setupEventListeners() {
            // Tab switching
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    switchView(this.dataset.view);
                });
            });

            // Search
            document.getElementById('searchInput').addEventListener('input', function() {
                currentFilter.search = this.value;
                applyFilters();
            });

            // Category filter
            document.getElementById('categoryFilter').addEventListener('change', function() {
                currentFilter.category = this.value;
                applyFilters();
            });
        }

        // Load keepsakes from API
        async function loadKeepsakes() {
            showLoading(true);
            try {
                const response = await fetch('/keepsakes/api/list');
                keepsakes = await response.json();
                renderCurrentView();
                showLoading(false);
            } catch (error) {
                console.error('Error loading keepsakes:', error);
                showToast('Failed to load keepsakes', 'error');
                showLoading(false);
            }
        }

        // Show/hide loading
        function showLoading(show) {
            document.getElementById('loadingState').style.display = show ? 'block' : 'none';
        }

        // Switch view
        function switchView(view) {
            currentView = view;
            
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.view === view) {
                    btn.classList.add('active');
                }
            });

            // Update active view
            document.querySelectorAll('.view-section').forEach(section => {
                section.classList.remove('active');
            });

            document.getElementById(view + 'View').classList.add('active');

            // Render appropriate view
            renderCurrentView();
        }

        // Render current view
        function renderCurrentView() {
            const filtered = getFilteredKeepsakes();
            
            if (currentView === 'masonry') {
                renderMasonry(filtered);
            } else if (currentView === 'timeline') {
                renderTimeline(filtered);
            } else if (currentView === 'calendar') {
                loadCalendarData(currentYear, currentMonth);
            } else if (currentView === 'favorites') {
                renderMasonry(filtered.filter(k => k.is_favorite));
            }
        }

        // Get filtered keepsakes
        function getFilteredKeepsakes() {
            return keepsakes.filter(keepsake => {
                if (currentFilter.category && keepsake.category !== currentFilter.category) return false;
                if (currentFilter.mood && keepsake.mood !== currentFilter.mood) return false;
                if (currentFilter.search) {
                    const search = currentFilter.search.toLowerCase();
                    if (!keepsake.title.toLowerCase().includes(search) && 
                        !keepsake.description?.toLowerCase().includes(search)) {
                        return false;
                    }
                }
                return true;
            });
        }

        // Apply filters
        function applyFilters() {
            renderCurrentView();
        }

        // Render masonry grid
        function renderMasonry(items) {
            const grid = document.getElementById('masonryGrid');
            const emptyState = document.getElementById('emptyState');
            
            if (items.length === 0) {
                grid.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            grid.innerHTML = items.map((keepsake, index) => `
                <div class="keepsake-card" style="animation-delay: ${index * 0.1}s;">
                    <div class="polaroid" onclick="viewKeepsake(${keepsake.id})">
                        <div class="category-badge">
                            ${keepsake.category_details.emoji} ${keepsake.category_details.label}
                        </div>
                        <div class="favorite-icon ${keepsake.is_favorite ? 'active' : ''}" 
                             onclick="event.stopPropagation(); toggleFavorite(${keepsake.id})">
                            ${keepsake.is_favorite ? '⭐' : '☆'}
                        </div>
                        ${keepsake.is_private ? '<div class="lock-icon">🔒</div>' : ''}
                        
                        <div class="polaroid-image">
                            ${keepsake.image_url ? 
                                `<img src="${keepsake.image_url}" alt="${keepsake.title}">` :
                                `<div class="placeholder-emoji">${keepsake.mood || '💕'}</div>`
                            }
                        </div>
                        
                        <div class="polaroid-content">
                            <div class="polaroid-title">${keepsake.title}</div>
                            <div class="polaroid-date">${keepsake.formatted_date}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Render timeline
        function renderTimeline(items) {
            const container = document.getElementById('timelineContainer');
            
            if (items.length === 0) {
                container.innerHTML = '<div class="empty-state"><p>No memories to show in timeline</p></div>';
                return;
            }

            // Group by year
            const grouped = items.reduce((acc, item) => {
                const year = new Date(item.memory_date).getFullYear();
                if (!acc[year]) acc[year] = [];
                acc[year].push(item);
                return acc;
            }, {});

            container.innerHTML = '<div class="timeline-line"></div>' + 
                Object.keys(grouped).sort().reverse().map(year => `
                    <div class="timeline-year">${year}</div>
                    ${grouped[year].map((keepsake, index) => `
                        <div class="timeline-item" style="animation-delay: ${index * 0.1}s;">
                            <div class="timeline-content">
                                <div class="timeline-card" onclick="viewKeepsake(${keepsake.id})">
                                    ${keepsake.image_url ? 
                                        `<img src="${keepsake.image_url}" style="width: 100%; border-radius: 10px; margin-bottom: 15px;">` : ''
                                    }
                                    <h3 style="color: var(--primary); margin-bottom: 10px;">${keepsake.title}</h3>
                                    <p style="color: var(--secondary); margin-bottom: 10px;">${keepsake.formatted_date}</p>
                                    ${keepsake.description ? `<p style="margin-bottom: 15px;">${keepsake.description.substring(0, 150)}...</p>` : ''}
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        <span class="category-badge" style="position: static;">
                                            ${keepsake.category_details.emoji} ${keepsake.category_details.label}
                                        </span>
                                        ${keepsake.mood ? `<span style="font-size: 1.5rem;">${keepsake.mood}</span>` : ''}
                                        ${keepsake.is_favorite ? '<span style="font-size: 1.5rem;">⭐</span>' : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                    `).join('')}
                `).join('');
        }

        // Generate calendar
        function generateCalendar(year, month) {
            const firstDay = new Date(year, month - 1, 1).getDay();
            const daysInMonth = new Date(year, month, 0).getDate();
            
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'];
            
            document.getElementById('calendarMonth').textContent = `${monthNames[month - 1]} ${year}`;
            
            const grid = document.getElementById('calendarGrid');
            grid.innerHTML = '';
            
            // Day headers
            ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].forEach(day => {
                const header = document.createElement('div');
                header.className = 'calendar-day-header';
                header.textContent = day;
                grid.appendChild(header);
            });
            
            // Empty cells
            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                empty.className = 'calendar-day empty';
                grid.appendChild(empty);
            }
            
            // Days
            for (let day = 1; day <= daysInMonth; day++) {
                const cell = document.createElement('div');
                cell.className = 'calendar-day';
                cell.textContent = day;
                
                const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const hasMemory = keepsakes.some(k => k.memory_date === dateStr);
                
                if (hasMemory) {
                    cell.classList.add('has-memory');
                    cell.onclick = () => showDateMemories(dateStr);
                }
                
                grid.appendChild(cell);
            }
        }

        // Navigate months
        function previousMonth() {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            generateCalendar(currentYear, currentMonth);
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            generateCalendar(currentYear, currentMonth);
        }

        // Show date memories
        function showDateMemories(date) {
            const memories = keepsakes.filter(k => k.memory_date === date);
            if (memories.length === 0) return;
            
            const content = `
                <h2>${new Date(date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</h2>
                <div style="display: flex; flex-direction: column; gap: 20px; margin-top: 20px;">
                    ${memories.map(m => `
                        <div class="timeline-card" onclick="viewKeepsake(${m.id})" style="cursor: pointer;">
                            ${m.image_url ? `<img src="${m.image_url}" style="width: 100%; border-radius: 10px; margin-bottom: 10px;">` : ''}
                            <h3 style="color: var(--primary);">${m.title}</h3>
                            <p style="margin-top: 10px;">${m.description || ''}</p>
                        </div>
                    `).join('')}
                </div>
            `;
            
            document.getElementById('viewModalContent').innerHTML = content;
            document.getElementById('viewModal').classList.add('active');
        }

        // View keepsake detail
        async function viewKeepsake(id) {
            try {
                const response = await fetch(`/keepsakes/api/${id}`);
                const data = await response.json();
                
                if (data.locked) {
                    const password = prompt('This keepsake is password protected. Enter password:');
                    if (!password) return;
                    
                    const retry = await fetch(`/keepsakes/api/${id}?password=${password}`);
                    const retryData = await retry.json();
                    
                    if (retryData.locked) {
                        showToast('Incorrect password', 'error');
                        return;
                    }
                    
                    showKeepsakeDetail(retryData.keepsake);
                } else {
                    showKeepsakeDetail(data.keepsake);
                }
            } catch (error) {
                console.error('Error viewing keepsake:', error);
                showToast('Failed to load keepsake', 'error');
            }
        }

        // Show keepsake detail
        function showKeepsakeDetail(keepsake) {
            const content = `
                <h2>${keepsake.title}</h2>
                <p style="color: var(--secondary); margin-bottom: 20px; font-family: 'Caveat', cursive; font-size: 1.2rem;">
                    ${keepsake.formatted_date}
                </p>
                ${keepsake.image_url ? `<img src="${keepsake.image_url}" style="width: 100%; border-radius: 15px; margin-bottom: 20px;">` : ''}
                ${keepsake.description ? `<p style="line-height: 1.8; margin-bottom: 20px;">${keepsake.description}</p>` : ''}
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                    <span class="category-badge" style="position: static;">
                        ${keepsake.category_details.emoji} ${keepsake.category_details.label}
                    </span>
                    ${keepsake.mood ? `<span style="font-size: 2rem;">${keepsake.mood}</span>` : ''}
                    ${keepsake.is_favorite ? '<span style="font-size: 2rem;">⭐</span>' : ''}
                    ${keepsake.is_private ? '<span style="font-size: 2rem;">🔒</span>' : ''}
                </div>
                ${keepsake.created_by ? `<p style="font-style: italic; color: var(--secondary);">by ${keepsake.created_by}</p>` : ''}
                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button class="btn" onclick="editKeepsake(${keepsake.id})">✏️ Edit</button>
                    <button class="btn btn-secondary" onclick="deleteKeepsake(${keepsake.id})">🗑️ Delete</button>
                </div>
            `;
            
            document.getElementById('viewModalContent').innerHTML = content;
            document.getElementById('viewModal').classList.add('active');
        }

        // Open add modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = '✨ Create New Keepsake';
            document.getElementById('keepsakeForm').reset();
            document.getElementById('keepsakeId').value = '';
            currentImageBase64 = null;
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('uploadPrompt').style.display = 'block';
            document.getElementById('imageUploadArea').classList.remove('has-image');
            document.getElementById('addModal').classList.add('active');
        }

        // Edit keepsake
        async function editKeepsake(id) {
            closeModal('viewModal');
            
            const keepsake = keepsakes.find(k => k.id === id);
            if (!keepsake) return;
            
            document.getElementById('modalTitle').textContent = '✏️ Edit Keepsake';
            document.getElementById('keepsakeId').value = id;
            document.getElementById('title').value = keepsake.title;
            document.getElementById('memory_date').value = keepsake.memory_date;
            document.getElementById('category').value = keepsake.category;
            document.getElementById('mood').value = keepsake.mood || '';
            document.getElementById('description').value = keepsake.description || '';
            document.getElementById('created_by').value = keepsake.created_by || '';
            document.getElementById('is_favorite').checked = keepsake.is_favorite;
            document.getElementById('is_private').checked = keepsake.is_private;
            
            if (keepsake.image_url) {
                document.getElementById('imagePreview').src = keepsake.image_url;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('uploadPrompt').style.display = 'none';
                document.getElementById('imageUploadArea').classList.add('has-image');
            }
            
            document.getElementById('addModal').classList.add('active');
        }

        // Handle image select
        function handleImageSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                currentImageBase64 = e.target.result;
                document.getElementById('imagePreview').src = currentImageBase64;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('uploadPrompt').style.display = 'none';
                document.getElementById('imageUploadArea').classList.add('has-image');
            };
            reader.readAsDataURL(file);
        }

        // Toggle password field
        function togglePasswordField() {
            const isPrivate = document.getElementById('is_private').checked;
            document.getElementById('passwordGroup').style.display = isPrivate ? 'block' : 'none';
            if (isPrivate) {
                document.getElementById('password').required = true;
            } else {
                document.getElementById('password').required = false;
            }
        }

        // Save keepsake
        async function saveKeepsake(event) {
            event.preventDefault();
            
            const id = document.getElementById('keepsakeId').value;
            const data = {
                title: document.getElementById('title').value,
                memory_date: document.getElementById('memory_date').value,
                category: document.getElementById('category').value,
                mood: document.getElementById('mood').value,
                description: document.getElementById('description').value,
                created_by: document.getElementById('created_by').value,
                is_favorite: document.getElementById('is_favorite').checked,
                is_private: document.getElementById('is_private').checked,
                password: document.getElementById('password').value,
                image: currentImageBase64
            };
            
            try {
                const url = id ? `/keepsakes/api/${id}` : '/keepsakes/api/store';
                const method = id ? 'PUT' : 'POST';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message, 'success');
                    closeModal('addModal');
                    loadKeepsakes();
                } else {
                    showToast(result.error || 'Failed to save keepsake', 'error');
                }
            } catch (error) {
                console.error('Error saving keepsake:', error);
                showToast('Failed to save keepsake', 'error');
            }
        }

        // Delete keepsake
        async function deleteKeepsake(id) {
            if (!confirm('Are you sure you want to delete this keepsake?')) return;
            
            try {
                const response = await fetch(`/keepsakes/api/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message, 'success');
                    closeModal('viewModal');
                    loadKeepsakes();
                } else {
                    showToast('Failed to delete keepsake', 'error');
                }
            } catch (error) {
                console.error('Error deleting keepsake:', error);
                showToast('Failed to delete keepsake', 'error');
            }
        }

        // Toggle favorite
        async function toggleFavorite(id) {
            try {
                const response = await fetch(`/keepsakes/api/${id}/favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message, 'success');
                    loadKeepsakes();
                }
            } catch (error) {
                console.error('Error toggling favorite:', error);
            }
        }

        // Export keepsakes
        function exportKeepsakes() {
            window.open('/keepsakes/api/export', '_blank');
            showToast('Exporting keepsakes...', 'success');
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Show toast
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            toastMessage.textContent = message;
            toast.className = `toast active ${type}`;
            
            setTimeout(() => {
                toast.classList.remove('active');
            }, 3000);
        }

        // Close modals on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
   <x-footer/>
</body>
</html>