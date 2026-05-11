<!-- Chatbot Widget -->
<div id="chatbotWidget" class="chatbot-widget">
  <!-- Chat Button -->
  <button id="chatbotToggle" class="chatbot-toggle" onclick="toggleChatbot()">
    <i data-lucide="message-circle" class="chatbot-icon-open"></i>
    <i data-lucide="x" class="chatbot-icon-close" style="display:none;"></i>
    <span class="chatbot-badge"></span>
  </button>

  <!-- Chat Window -->
  <div id="chatbotWindow" class="chatbot-window" style="display:none;">
    <!-- Header -->
    <div class="chatbot-header">
      <div class="chatbot-header-content">
        <div class="chatbot-avatar">
          <i data-lucide="leaf"></i>
        </div>
        <div class="chatbot-info">
          <h3 class="chatbot-title">NutriGreen Assistant</h3>
          <p class="chatbot-status">En ligne</p>
        </div>
      </div>
      <button class="chatbot-close" onclick="toggleChatbot()">
        <i data-lucide="x"></i>
      </button>
    </div>

    <!-- Messages -->
    <div id="chatbotMessages" class="chatbot-messages">
      <!-- Messages will be added here -->
    </div>

    <!-- Suggestions -->
    <div id="chatbotSuggestions" class="chatbot-suggestions">
      <!-- Suggestions will be added here -->
    </div>

    <!-- Input -->
    <div class="chatbot-input">
      <input type="text" id="chatbotInput" placeholder="Écrivez votre message..." 
             onkeypress="handleChatbotKeypress(event)">
      <button class="chatbot-send" onclick="sendChatbotMessage()">
        <i data-lucide="send"></i>
      </button>
    </div>
  </div>
</div>

<style>
.chatbot-widget {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  z-index: 9999;
  font-family: var(--font-body);
}

.chatbot-toggle {
  width: 3.5rem;
  height: 3.5rem;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--primary) 0%, #1B4332 100%);
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 20px rgba(27, 67, 50, 0.3);
  transition: all 0.3s ease;
  position: relative;
}

.chatbot-toggle:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 25px rgba(27, 67, 50, 0.4);
}

.chatbot-toggle i {
  color: white;
  width: 1.5rem;
  height: 1.5rem;
}

.chatbot-badge {
  position: absolute;
  top: 0;
  right: 0;
  width: 0.75rem;
  height: 0.75rem;
  background: #ef4444;
  border-radius: 50%;
  border: 2px solid white;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.chatbot-window {
  position: absolute;
  bottom: 4.5rem;
  right: 0;
  width: 22rem;
  max-height: 35rem;
  background: var(--background);
  border-radius: 1rem;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.chatbot-header {
  background: linear-gradient(135deg, var(--primary) 0%, #1B4332 100%);
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  color: white;
}

.chatbot-header-content {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.chatbot-avatar {
  width: 2.5rem;
  height: 2.5rem;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.chatbot-avatar i {
  width: 1.25rem;
  height: 1.25rem;
}

.chatbot-info h3 {
  font-size: 0.95rem;
  font-weight: 600;
  margin: 0;
}

.chatbot-info p {
  font-size: 0.75rem;
  margin: 0;
  opacity: 0.9;
}

.chatbot-close {
  background: none;
  border: none;
  cursor: pointer;
  color: white;
  padding: 0.25rem;
}

.chatbot-close i {
  width: 1rem;
  height: 1rem;
}

.chatbot-messages {
  flex: 1;
  overflow-y: auto;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.chatbot-message {
  max-width: 85%;
  padding: 0.75rem 1rem;
  border-radius: 1rem;
  font-size: 0.875rem;
  line-height: 1.5;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.chatbot-message.bot {
  background: var(--surface);
  color: var(--text-primary);
  align-self: flex-start;
  border-bottom-left-radius: 0.25rem;
}

.chatbot-message.user {
  background: var(--primary);
  color: white;
  align-self: flex-end;
  border-bottom-right-radius: 0.25rem;
}

.chatbot-typing {
  display: flex;
  gap: 0.25rem;
  padding: 0.75rem 1rem;
  background: var(--surface);
  border-radius: 1rem;
  border-bottom-left-radius: 0.25rem;
  width: fit-content;
}

.chatbot-typing span {
  width: 0.5rem;
  height: 0.5rem;
  background: var(--text-muted);
  border-radius: 50%;
  animation: typing 1.4s infinite;
}

.chatbot-typing span:nth-child(2) {
  animation-delay: 0.2s;
}

.chatbot-typing span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes typing {
  0%, 60%, 100% {
    transform: translateY(0);
  }
  30% {
    transform: translateY(-0.25rem);
  }
}

.chatbot-suggestions {
  padding: 0.75rem 1rem;
  border-top: 1px solid var(--border);
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.chatbot-suggestion {
  padding: 0.5rem 0.75rem;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 2rem;
  font-size: 0.75rem;
  color: var(--text-secondary);
  cursor: pointer;
  transition: all 0.2s ease;
}

.chatbot-suggestion:hover {
  background: var(--primary);
  color: white;
  border-color: var(--primary);
}

.chatbot-input {
  padding: 1rem;
  border-top: 1px solid var(--border);
  display: flex;
  gap: 0.75rem;
}

.chatbot-input input {
  flex: 1;
  padding: 0.75rem 1rem;
  border: 1px solid var(--border);
  border-radius: 2rem;
  background: var(--surface);
  color: var(--text-primary);
  font-size: 0.875rem;
  outline: none;
  transition: border-color 0.2s ease;
}

.chatbot-input input:focus {
  border-color: var(--primary);
}

.chatbot-input input::placeholder {
  color: var(--text-muted);
}

.chatbot-send {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 50%;
  background: var(--primary);
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.chatbot-send:hover {
  transform: scale(1.05);
}

.chatbot-send i {
  color: white;
  width: 1rem;
  height: 1rem;
}

.chatbot-send:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Scrollbar */
.chatbot-messages::-webkit-scrollbar {
  width: 6px;
}

.chatbot-messages::-webkit-scrollbar-track {
  background: var(--surface);
}

.chatbot-messages::-webkit-scrollbar-thumb {
  background: var(--border);
  border-radius: 3px;
}

.chatbot-messages::-webkit-scrollbar-thumb:hover {
  background: var(--text-muted);
}

/* Responsive */
@media (max-width: 640px) {
  .chatbot-window {
    width: 20rem;
    right: -1rem;
  }
  
  .chatbot-widget {
    bottom: 1.5rem;
    right: 1.5rem;
  }
}
</style>

<script>
let chatbotOpen = false;
let chatbotInitialized = false;

function toggleChatbot() {
  chatbotOpen = !chatbotOpen;
  const window = document.getElementById('chatbotWindow');
  const iconOpen = document.querySelector('.chatbot-icon-open');
  const iconClose = document.querySelector('.chatbot-icon-close');
  
  if (chatbotOpen) {
    window.style.display = 'flex';
    iconOpen.style.display = 'none';
    iconClose.style.display = 'block';
    
    if (!chatbotInitialized) {
      initializeChatbot();
      chatbotInitialized = true;
    }
  } else {
    window.style.display = 'none';
    iconOpen.style.display = 'block';
    iconClose.style.display = 'none';
  }
}

function initializeChatbot() {
  // Add welcome message
  addBotMessage('Bonjour ! 👋 Je suis l\'assistant NutriGreen. Comment puis-je vous aider aujourd\'hui ?');
  
  // Load suggestions
  loadSuggestions();
}

function loadSuggestions() {
  fetch('<?= BASE_URL ?>/?page=api-chatbot&action=suggestions')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        displaySuggestions(data.suggestions);
      }
    })
    .catch(error => console.error('Error loading suggestions:', error));
}

function displaySuggestions(suggestions) {
  const container = document.getElementById('chatbotSuggestions');
  container.innerHTML = '';
  
  suggestions.forEach(suggestion => {
    const button = document.createElement('button');
    button.className = 'chatbot-suggestion';
    button.textContent = suggestion;
    button.onclick = () => {
      document.getElementById('chatbotInput').value = suggestion;
      sendChatbotMessage();
    };
    container.appendChild(button);
  });
}

function addBotMessage(message) {
  const container = document.getElementById('chatbotMessages');
  const messageDiv = document.createElement('div');
  messageDiv.className = 'chatbot-message bot';
  messageDiv.textContent = message;
  container.appendChild(messageDiv);
  
  // Scroll to bottom
  container.scrollTop = container.scrollHeight;
}

function addUserMessage(message) {
  const container = document.getElementById('chatbotMessages');
  const messageDiv = document.createElement('div');
  messageDiv.className = 'chatbot-message user';
  messageDiv.textContent = message;
  container.appendChild(messageDiv);
  
  // Scroll to bottom
  container.scrollTop = container.scrollHeight;
}

function showTyping() {
  const container = document.getElementById('chatbotMessages');
  const typingDiv = document.createElement('div');
  typingDiv.className = 'chatbot-typing';
  typingDiv.id = 'chatbotTyping';
  typingDiv.innerHTML = '<span></span><span></span><span></span>';
  container.appendChild(typingDiv);
  
  // Scroll to bottom
  container.scrollTop = container.scrollHeight;
}

function hideTyping() {
  const typing = document.getElementById('chatbotTyping');
  if (typing) {
    typing.remove();
  }
}

function sendChatbotMessage() {
  const input = document.getElementById('chatbotInput');
  const message = input.value.trim();
  
  if (!message) return;
  
  // Add user message
  addUserMessage(message);
  input.value = '';
  
  // Show typing indicator
  showTyping();
  
  // Send to server
  fetch('<?= BASE_URL ?>/?page=api-chatbot&action=response', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ message: message })
  })
  .then(response => response.json())
  .then(data => {
    hideTyping();
    
    if (data.success) {
      addBotMessage(data.response);
      displaySuggestions(data.suggestions);
    } else {
      addBotMessage('Désolé, une erreur s\'est produite. Veuillez réessayer.');
    }
  })
  .catch(error => {
    hideTyping();
    addBotMessage('Désolé, une erreur s\'est produite. Veuillez réessayer.');
    console.error('Error:', error);
  });
}

function handleChatbotKeypress(event) {
  if (event.key === 'Enter') {
    sendChatbotMessage();
  }
}

// Initialize Lucide icons
if (typeof lucide !== 'undefined') {
  lucide.createIcons();
}
</script>
