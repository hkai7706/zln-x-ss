<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>💕 Love Quiz - Test Your Love Knowledge</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/love-quiz.css') }}">
</head>
<body>
    <!-- Floating Hearts -->
    <div class="heart" style="left: 10%; animation-delay: 0s;">💖</div>
    <div class="heart" style="left: 20%; animation-delay: 2s;">💕</div>
    <div class="heart" style="left: 30%; animation-delay: 4s;">💗</div>
    <div class="heart" style="left: 40%; animation-delay: 1s;">💓</div>
    <div class="heart" style="left: 50%; animation-delay: 3s;">💝</div>
    <div class="heart" style="left: 60%; animation-delay: 5s;">💖</div>
    <div class="heart" style="left: 70%; animation-delay: 2.5s;">💕</div>
    <div class="heart" style="left: 80%; animation-delay: 4.5s;">💗</div>
    <div class="heart" style="left: 90%; animation-delay: 1.5s;">💓</div>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>💕 Love Quiz 💕</h1>
            <p>တစ်ယောက်အကြောင်းတစ်ယောက်ဘယ်လောက်သိလဲပြိုင်ကြမယ်,ဖြေကြည့်ကြည့်နော်အဟိ<:3 fighting💓</p>
        </div>
        <!-- Quiz Card -->
        <div class="quiz-card">
            <!-- Start Screen -->
            <div class="start-screen" id="startScreen">
                <h2>Welcome to the Love Quiz!</h2>
                <div id="errorMessage"></div>
                
                <form id="startForm">
                    <div class="form-group">
                        <label for="playerName">နာမည်ထည့်ပါ*</label>
                        <input type="text" id="playerName" name="name" required
                               placeholder="Enter your name" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="difficulty">ခက်ခဲမှုအဆင့်ကိုရွှေးပါ *</label>
                        <select id="difficulty" name="difficulty" required>
                            <option value="">Choose difficulty level</option>
                            <option value="Easy">Easy (60 seconds per question)</option>
                            <option value="Medium">Medium (45 seconds per question)</option>
                            <option value="Hard">Hard (30 seconds per question)</option>
                        </select>
                        <div class="difficulty-info">
                            💡 သေချာ‌ဖြေနော်ဘေဘီ နှစ်ယောက်လုံးနဲ့ပက်သတ်တာတွေပဲအကုန်ကအမှတ်များများရအောင်ဖြေနော်  40မကျော်ရင်စိတ်ကောက်ပြီဗျ"<br/> 
                            💕 result ကိုmemory wall မှာပြန်ရေးသွားဖို့လည်းမမေ့နဲ့နော်ဘေဘီ! 💕
                        </div>
                    </div>
                    <button type="submit" class="btn" id="startBtn">
                        Start Quiz 💖
                    </button>
                    <button class="btn" type="button" onclick="window.location.href='{{ url('/') }}'">
                        Back to Home 
    </button>
                </form>
            </div>
            <!-- Quiz Screen -->
            <div class="quiz-screen" id="quizScreen">
                <div class="quiz-header">
                    <div class="quiz-info">
                        <div class="info-badge">
                            <span id="playerNameDisplay"></span>
                        </div>
                        <div class="info-badge">
                            Difficulty: <span id="difficultyDisplay"></span>
                        </div>
                    </div>
                    <div class="timer" id="timer">
                        ⏱️ <span id="timeLeft">60</span>s
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="question-container">
                    <div class="question-header">
                        <div class="question-number" id="questionNumber">
                            Question 1 of 20
                        </div>
                        <div class="category-badge" id="categoryBadge">
                            Category
                        </div>
                    </div>
                    <div class="question-text" id="questionText">
                        Question will appear here
                    </div>
                    <div class="options-container" id="optionsContainer">
                        <!-- Options will be inserted here -->
                    </div>
                </div>
                <div class="quiz-actions">
                    <button class="btn" id="submitAnswerBtn" disabled>
                        Submit Answer 💝
                    </button>
                </div>
            </div>
            <!-- Results Screen -->
            <div class="results-screen" id="resultsScreen">
                <div class="results-header">
                    <div class="badge-container" id="badgeDisplay">
                        💖
                    </div>
                    <div class="rank-title" id="rankTitle">
                        Love Master
                    </div>
                    <div class="score-display">
                        Score: <span id="finalScore">0</span>/100
                    </div>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value" id="correctCount">0</div>
                        <div class="stat-label">Correct</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="incorrectCount">0</div>
                        <div class="stat-label">Incorrect</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="timeTaken">0:00</div>
                        <div class="stat-label">Time Taken</div>
                    </div>
                </div>
                <div class="category-scores">
                    <h3>Category Breakdown</h3>
                    <div id="categoryScoresContainer">
                        <!-- Category scores will be inserted here -->
                    </div>
                </div>
                <div class="results-actions">
                    <button class="btn" onclick="location.reload()">
                        Try Again 💕
                    </button>
                        <button class="btn" onclick="window.location.href='{{ url('/') }}'">
                    Back to Home
                    </button>
                    <button class="btn btn-secondary" id="shareBtn">
                        Share Results 📤
                    </button>
                </div>
            </div>
        </div>
        <!-- Leaderboard -->
        <div class="leaderboard-card">
            <h2>🏆 Leaderboard 🏆</h2>
            <div class="leaderboard-header">
                <div>Rank</div>
                <div>Player</div>
                <div>Score</div>
                <div>Difficulty</div>
            </div>
            <div id="leaderboardContainer">
                @if(isset($leaderboard) && count($leaderboard) > 0)
                    @foreach($leaderboard as $entry)
                    <div class="leaderboard-row">
                        <div class="rank-badge rank-{{ $entry['rank'] <= 3 ? $entry['rank'] : 'other' }}">
                            {{ $entry['rank'] }}
                        </div>
                        <div class="player-info">
                            <div class="player-name">{{ $entry['name'] }}</div>
                            <div class="player-badge">{{ $entry['badge'] }}</div>
                        </div>
                        <div class="score">{{ $entry['score'] }}</div>
                        <div class="difficulty-tag difficulty-{{ $entry['difficulty'] }}">
                            {{ $entry['difficulty'] }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 40px; color: #999;">
                        No entries yet. Be the first to take the quiz!
                    </div>
                @endif
            </div>
        </div>
    </div>
<script src="{{ asset('js/love-quiz.js') }}"></script>
</body>
</html>