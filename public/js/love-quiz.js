// Quiz State
        let quizState = {
            questions: [],
            currentQuestionIndex: 0,
            selectedAnswer: null,
            timeLimit: 60,
            timeLeft: 60,
            timerInterval: null,
            startTime: null,
            answers: []
        };
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        // DOM Elements
        const startScreen = document.getElementById('startScreen');
        const quizScreen = document.getElementById('quizScreen');
        const resultsScreen = document.getElementById('resultsScreen');
        const startForm = document.getElementById('startForm');
        const errorMessage = document.getElementById('errorMessage');
        // Start Quiz
        startForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(startForm);
            const startBtn = document.getElementById('startBtn');
            
            startBtn.disabled = true;
            startBtn.textContent = 'Starting...';
            errorMessage.innerHTML = '';
            try {
                const response = await fetch('/quiz/start', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                });
             const data = await response.json();

if (!response.ok) {
    throw new Error(data.error || 'Failed to start quiz');
}

// Validate data before using it
if (!data.questions || !Array.isArray(data.questions) || data.questions.length === 0) {
    throw new Error('No questions received from server');
}

if (!data.user || !data.attempt) {
    throw new Error('Invalid server response');
}

                // Initialize quiz
                quizState.questions = data.questions;
                quizState.timeLimit = data.time_limit;
                quizState.timeLeft = data.time_limit;
                quizState.startTime = Date.now();
                // Update UI
                document.getElementById('playerNameDisplay').textContent = data.user.name;
                document.getElementById('difficultyDisplay').textContent = data.attempt.difficulty;
                // Show quiz screen
                startScreen.style.display = 'none';
                quizScreen.style.display = 'block';
                // Load first question
                loadQuestion();
                startTimer();
            } catch (error) {
                errorMessage.innerHTML = `<div class="error-message">${error.message}</div>`;
                startBtn.disabled = false;
                startBtn.textContent = 'Start Quiz 💖';
            }
        });
        // Load Question
        function loadQuestion() {
            const question = quizState.questions[quizState.currentQuestionIndex];
            const progress = ((quizState.currentQuestionIndex + 1) / quizState.questions.length) * 100;
            document.getElementById('questionNumber').textContent =
                `Question ${quizState.currentQuestionIndex + 1} of ${quizState.questions.length}`;
            document.getElementById('categoryBadge').textContent = question.category;
            document.getElementById('questionText').textContent = question.question;
            document.getElementById('progressFill').style.width = `${progress}%`;
            // Load options
            const optionsContainer = document.getElementById('optionsContainer');
            optionsContainer.innerHTML = '';
            question.options.forEach((option, index) => {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'option';
                optionDiv.innerHTML = `
                    <input type="radio" name="answer" id="option${index}" value="${index}">
                    <label for="option${index}">${option}</label>
                `;
                optionDiv.addEventListener('click', () => selectOption(index));
                optionsContainer.appendChild(optionDiv);
            });
            // Reset timer
            quizState.timeLeft = quizState.timeLimit;
            updateTimerDisplay();
            
            // Reset selected answer
            quizState.selectedAnswer = null;
            document.getElementById('submitAnswerBtn').disabled = true;
        }
        // Select Option
        function selectOption(index) {
            quizState.selectedAnswer = index;
            
            // Update UI
            document.querySelectorAll('.option').forEach((opt, i) => {
                opt.classList.remove('selected');
                if (i === index) {
                    opt.classList.add('selected');
                    opt.querySelector('input').checked = true;
                }
            });
            document.getElementById('submitAnswerBtn').disabled = false;
        }
        // Timer
        function startTimer() {
            quizState.timerInterval = setInterval(() => {
                quizState.timeLeft--;
                updateTimerDisplay();
                if (quizState.timeLeft <= 10) {
                    document.getElementById('timer').classList.add('warning');
                } else {
                    document.getElementById('timer').classList.remove('warning');
                }
                if (quizState.timeLeft <= 0) {
                    submitAnswer(true); // Auto-submit on timeout
                }
            }, 1000);
        }
        function updateTimerDisplay() {
            document.getElementById('timeLeft').textContent = quizState.timeLeft;
        }
        function stopTimer() {
            if (quizState.timerInterval) {
                clearInterval(quizState.timerInterval);
                quizState.timerInterval = null;
            }
        }
        // Submit Answer
        document.getElementById('submitAnswerBtn').addEventListener('click', () => {
            submitAnswer(false);
        });
        async function submitAnswer(isTimeout) {
            stopTimer();
            const question = quizState.questions[quizState.currentQuestionIndex];
            const answer = isTimeout ? -1 : quizState.selectedAnswer;
            const timeTaken = quizState.timeLimit - quizState.timeLeft;
            try {
                const response = await fetch('/quiz/answer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        question_id: question.id,
                        answer: answer,
                        time_taken: timeTaken
                    })
                });
                const data = await response.json();
                // Store answer
                quizState.answers.push({
                    questionId: question.id,
                    selectedAnswer: answer,
                    isCorrect: data.is_correct,
                    correctAnswer: data.correct_answer
                });
                // Show correct/incorrect briefly
                if (!isTimeout) {
                    highlightAnswer(data.correct_answer, data.is_correct);
                    await new Promise(resolve => setTimeout(resolve, 1500));
                }
                // Move to next question or finish
                quizState.currentQuestionIndex++;
                
                if (quizState.currentQuestionIndex < quizState.questions.length) {
                    loadQuestion();
                    startTimer();
                } else {
                    finishQuiz();
                }
            } catch (error) {
                console.error('Error submitting answer:', error);
                alert('Error submitting answer. Please try again.');
                startTimer();
            }
        }
        function highlightAnswer(correctIndex, isCorrect) {
            document.querySelectorAll('.option').forEach((opt, i) => {
                if (i === correctIndex) {
                    opt.classList.add('correct');
                } else if (i === quizState.selectedAnswer && !isCorrect) {
                    opt.classList.add('incorrect');
                }
            });
        }
        // Finish Quiz
        async function finishQuiz() {
            try {
                const response = await fetch('/quiz/complete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();
                // Show results
                displayResults(data.results);
                updateLeaderboard(data.leaderboard);
                // Hide quiz, show results
                quizScreen.style.display = 'none';
                resultsScreen.style.display = 'block';
            } catch (error) {
                console.error('Error finishing quiz:', error);
                alert('Error finishing quiz. Please refresh the page.');
            }
        }
        // Display Results
        function displayResults(results) {
            document.getElementById('badgeDisplay').textContent = results.badge.split(' ')[0];
            document.getElementById('rankTitle').textContent = results.rank_title;
            document.getElementById('finalScore').textContent = results.total_score;
            document.getElementById('correctCount').textContent = results.correct_answers;
            document.getElementById('incorrectCount').textContent = results.incorrect_answers;
            document.getElementById('timeTaken').textContent = formatTime(results.time_taken);
            // Display category scores
            const categoryContainer = document.getElementById('categoryScoresContainer');
            categoryContainer.innerHTML = '';
            for (const [category, scores] of Object.entries(results.category_scores)) {
                const percentage = Math.round((scores.correct / scores.total) * 100);
                const categoryDiv = document.createElement('div');
                categoryDiv.className = 'category-item';
                categoryDiv.innerHTML = `
                    <div class="category-name">${category}</div>
                    <div class="category-score">${scores.correct}/${scores.total} (${percentage}%)</div>
                `;
                categoryContainer.appendChild(categoryDiv);
            }
        }
        // Update Leaderboard
        function updateLeaderboard(leaderboard) {
            const container = document.getElementById('leaderboardContainer');
            container.innerHTML = '';
            if (leaderboard.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #999;">
                        No entries yet. Be the first to take the quiz!
                    </div>
                `;
                return;
            }
            leaderboard.forEach(entry => {
                const row = document.createElement('div');
                row.className = 'leaderboard-row';
                row.innerHTML = `
                    <div class="rank-badge rank-${entry.rank <= 3 ? entry.rank : 'other'}">
                        ${entry.rank}
                    </div>
                    <div class="player-info">
                        <div class="player-name">${escapeHtml(entry.name)}</div>
                        <div class="player-badge">${entry.badge}</div>
                    </div>
                    <div class="score">${entry.score}</div>
                    <div class="difficulty-tag difficulty-${entry.difficulty}">
                        ${entry.difficulty}
                    </div>
                `;
                container.appendChild(row);
            });
        }
        // Share Results
        document.getElementById('shareBtn').addEventListener('click', () => {
            const score = document.getElementById('finalScore').textContent;
            const rank = document.getElementById('rankTitle').textContent;
            const badge = document.getElementById('badgeDisplay').textContent;
            
            const text = `I scored ${score}/100 on the Love Quiz and earned the ${badge} ${rank} badge! Can you beat my score? 💕`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Love Quiz Results',
                    text: text,
                    url: window.location.href
                }).catch(err => console.log('Error sharing:', err));
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(text + '\n' + window.location.href)
                    .then(() => alert('Results copied to clipboard! 📋'))
                    .catch(err => console.log('Error copying:', err));
            }
        });
        // Utility Functions
        function formatTime(seconds) {
            if (!seconds) return 'N/A';
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${minutes}:${secs.toString().padStart(2, '0')}`;
        }
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        // Prevent page refresh during quiz
        window.addEventListener('beforeunload', (e) => {
            if (quizScreen.style.display === 'block') {
                e.preventDefault();
                e.returnValue = '';
            }
        });