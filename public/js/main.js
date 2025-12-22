        // Background floating hearts
    function createFloatingHearts() {
      const container = document.getElementById('bgAnimation');
      const hearts = ['❤️', '💗', 'လမင်းအိမ်ကိုချစ်တယ်', '💝', '💖', '💕', 'ကိုကို့ချစ်ချစ်', 'မိန်းမိန်း', 'bby', 'love yaaa', 'love', 'လမင်း'];

      setInterval(() => {
        const heart = document.createElement('div');
        heart.className = 'floating-heart';
        heart.textContent = hearts[Math.floor(Math.random() * hearts.length)];
        heart.style.left = Math.random() * 100 + '%';
        heart.style.animationDelay = Math.random() * 5 + 's';
        heart.style.fontSize = (Math.random() * 20 + 20) + 'px';
        container.appendChild(heart);

        setTimeout(() => heart.remove(), 15000);
      }, 2000);
    }

    // Love meter animation
    setTimeout(() => {
      const loveMeter = document.getElementById('loveMeter');
      if (loveMeter) {
        loveMeter.style.width = '100%';
      }
      setTimeout(() => {
        const meterText = document.getElementById('meterText');
        if (meterText) {
          meterText.textContent = 'Love Level: INFINITE! 💯❤️';
        }
      }, 2000);
    }, 500);

    // Countdown timer
    function updateCountdown() {
      const target = new Date('2026-01-20T00:00:00').getTime();
      const now = new Date().getTime();
      const distance = target - now;

      const display = document.getElementById('countdownDisplay');
      if (!display) return;

      if (distance < 0) {
        display.innerHTML = '<p style="font-size: 2rem; grid-column: 1/-1;">🎉 Happy Anniversary! 🎉</p>';
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      display.innerHTML = `
        <div class="countdown-unit">
          <span class="number">${days}</span>
          <span class="label">Days</span>
        </div>
        <div class="countdown-unit">
          <span class="number">${hours}</span>
          <span class="label">Hours</span>
        </div>
        <div class="countdown-unit">
          <span class="number">${minutes}</span>
          <span class="label">Minutes</span>
        </div>
        <div class="countdown-unit">
          <span class="number">${seconds}</span>
          <span class="label">Seconds</span>
        </div>
      `;
    }
//love quiz button
   function testLove() {
            const button = document.querySelector('.love-button');
            
            // Create sparkles
            for (let i = 0; i < 12; i++) {
                createSparkle(button);
            }
            
            // You can add navigation or functionality here
            console.log('Testing love level...');
        }

        function createSparkle(button) {
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';
            
            const rect = button.getBoundingClientRect();
            const x = Math.random() * rect.width;
            const y = Math.random() * rect.height;
            
            sparkle.style.left = x + 'px';
            sparkle.style.top = y + 'px';
            sparkle.style.setProperty('--tx', (Math.random() - 0.5) * 100 + 'px');
            sparkle.style.setProperty('--ty', (Math.random() - 0.5) * 100 + 'px');
            
            button.appendChild(sparkle);
            
            setTimeout(() => sparkle.remove(), 1000);
        }

// memory wall

 // Global variables
        let memories = [];
        let isLoading = false;
        let editingId = null;

        // Get CSRF token for Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadMemories();
            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            const input = document.getElementById('memoryInput');
            
            // Enter key to add memory
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !isLoading) {
                    addMemory();
                }
            });

            // Auto-resize input (optional)
            input.addEventListener('input', (e) => {
                // You can add character counter here if needed
            });
        }

        // Load all memories from database
        async function loadMemories() {
            try {
                isLoading = true;
                const response = await fetch('/api/memories', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    memories = data.memories;
                    displayMemories();
                } else {
                    showMessage('Failed to load memories', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error loading memories: ' + error.message, 'error');
            } finally {
                isLoading = false;
            }
        }

        // Add new memory
        async function addMemory() {
            const input = document.getElementById('memoryInput');
            const memory = input.value.trim();

            if (!memory) {
                showMessage('Please enter a memory', 'error');
                return;
            }

            if (isLoading) return;

            try {
                isLoading = true;
                disableButton(true);

                const response = await fetch('/api/memories', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ memory: memory })
                });

                const data = await response.json();

                if (data.success) {
                    memories.unshift(data.memory);
                    input.value = '';
                    displayMemories();
                    showMessage('Memory added successfully! 💕', 'success');
                } else {
                    showMessage(data.error || 'Failed to add memory', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error adding memory: ' + error.message, 'error');
            } finally {
                isLoading = false;
                disableButton(false);
            }
        }

        // Edit memory
        function editMemory(id) {
            if (editingId !== null) {
                cancelEdit(editingId);
            }

            editingId = id;
            const memoryItem = document.querySelector(`[data-memory-id="${id}"]`);
            const textElement = memoryItem.querySelector('.memory-text');
            const editInput = memoryItem.querySelector('.edit-input');
            const editActions = memoryItem.querySelector('.edit-actions');

            textElement.classList.add('editing');
            editInput.classList.add('active');
            editActions.classList.add('active');
            editInput.value = textElement.textContent.trim().replace(' 💕', '');
            editInput.focus();
        }

        // Save edited memory
        async function saveEdit(id) {
            const memoryItem = document.querySelector(`[data-memory-id="${id}"]`);
            const editInput = memoryItem.querySelector('.edit-input');
            const newText = editInput.value.trim();

            if (!newText) {
                showMessage('Memory cannot be empty', 'error');
                return;
            }

            try {
                isLoading = true;

                const response = await fetch(`/api/memories/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ memory: newText })
                });

                const data = await response.json();

                if (data.success) {
                    const index = memories.findIndex(m => m.id === id);
                    if (index !== -1) {
                        memories[index] = data.memory;
                    }
                    displayMemories();
                    showMessage('Memory updated successfully! ✨', 'success');
                    editingId = null;
                } else {
                    showMessage(data.error || 'Failed to update memory', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error updating memory: ' + error.message, 'error');
            } finally {
                isLoading = false;
            }
        }

        // Cancel edit
        function cancelEdit(id) {
            const memoryItem = document.querySelector(`[data-memory-id="${id}"]`);
            const textElement = memoryItem.querySelector('.memory-text');
            const editInput = memoryItem.querySelector('.edit-input');
            const editActions = memoryItem.querySelector('.edit-actions');

            textElement.classList.remove('editing');
            editInput.classList.remove('active');
            editActions.classList.remove('active');
            editingId = null;
        }

        // Delete memory
        async function deleteMemory(id) {
            if (!confirm('Are you sure you want to delete this memory? 🥺')) {
                return;
            }

            try {
                isLoading = true;

                const response = await fetch(`/api/memories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    memories = memories.filter(m => m.id !== id);
                    displayMemories();
                    showMessage('Memory deleted successfully', 'success');
                } else {
                    showMessage(data.error || 'Failed to delete memory', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error deleting memory: ' + error.message, 'error');
            } finally {
                isLoading = false;
            }
        }

        // Display all memories
        function displayMemories() {
            const list = document.getElementById('memoriesList');

            if (memories.length === 0) {
                list.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">📝</div>
                        <p>No memories yet. Add your first one!</p>
                    </div>
                `;
                return;
            }

            list.innerHTML = memories.map(m => `
                <div class="memory-item" data-memory-id="${m.id}">
                    <div class="memory-header">
                        <span class="memory-date">${escapeHtml(m.date)} at ${escapeHtml(m.time)}</span>
                        <div class="memory-actions">
                            <button class="edit-btn" onclick="editMemory(${m.id})" title="Edit memory">
                                ✏️
                            </button>
                            <button class="delete-btn" onclick="deleteMemory(${m.id})" title="Delete memory">
                                🗑️
                            </button>
                        </div>
                    </div>
                    <div class="memory-text">${escapeHtml(m.text)} 💕</div>
                    <input type="text" class="edit-input" maxlength="1000">
                    <div class="edit-actions">
                        <button class="save-btn" onclick="saveEdit(${m.id})">Save</button>
                        <button class="cancel-btn" onclick="cancelEdit(${m.id})">Cancel</button>
                    </div>
                </div>
            `).join('');
        }

        // Show success/error message
        function showMessage(message, type = 'success') {
            const container = document.getElementById('messageContainer');
            const messageDiv = document.createElement('div');
            messageDiv.className = type;
            messageDiv.textContent = message;
            
            container.innerHTML = '';
            container.appendChild(messageDiv);

            setTimeout(() => {
                messageDiv.style.opacity = '0';
                setTimeout(() => messageDiv.remove(), 300);
            }, 3000);
        }

        // Disable/enable add button
        function disableButton(disabled) {
            const btn = document.querySelector('.add-memory-btn');
            btn.disabled = disabled;
            btn.textContent = disabled ? 'Adding...' : 'Add Memory ✨';
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
    // Allow Enter key to add memory
    const memoryInput = document.getElementById('memoryInput');
    if (memoryInput) {
      memoryInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
          addMemory();
        }
      });
    }

    // Initialize all features
    createFloatingHearts();
    updateCountdown();
    setInterval(updateCountdown, 1000);
    loadMemories();