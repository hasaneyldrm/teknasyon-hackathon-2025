@extends('layouts.admin')

@section('title', 'GlobalGPT - AI Chat Assistant')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">AI Chat Assistant</h1>
    <p class="text-gray-400">OpenAI GPT ile güçlendirilmiş yapay zeka sohbet asistanı</p>
</div>

<!-- Main Chat Area -->
<div class="flex-1 flex flex-col p-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
        <!-- Chat Messages Area -->
        <div class="lg:col-span-2">
            <div class="card rounded-xl shadow-sm h-full flex flex-col">
                <!-- Chat Header -->
                <div class="border-b border-gray-700 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center">
                                <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="w-12 h-12 rounded-lg">
                            </div>
                            <div>
                                <h3 class="font-medium text-white" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">GlobalGPT</h3>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-400">Online</span>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="flex-1 overflow-y-auto p-4 scrollbar-thin" id="chatMessages" style="min-height: 400px; max-height: 500px;">
                    <!-- Welcome Message -->
                    <div class="chat-message mb-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="w-10 h-10 rounded-lg">
                            </div>
                            <div class="bg-gray-700 rounded-lg px-4 py-2 max-w-md">
                                <p class="text-white" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">Merhaba! Ben GlobalGPT, sizin AI asistanınızım. Size nasıl yardımcı olabilirim?</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Typing Indicator -->
                <div class="typing-indicator hidden px-4 pb-4" id="typingIndicator">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="w-10 h-10 rounded-lg">
                        </div>
                        <div class="bg-gray-700 rounded-lg px-4 py-2">
                            <div class="typing-dots">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="border-t border-gray-700 p-4">
                    <form id="chatForm" class="flex gap-3">
                        @csrf
                        <div class="flex-1">
                            <input 
                                type="text" 
                                id="messageInput"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Mesajınızı yazın..."
                                autocomplete="off"
                                required
                            >
                        </div>
                        <button 
                            type="submit" 
                            id="sendButton"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-colors duration-200 flex items-center gap-2"
                        >
                            <i class="fas fa-paper-plane"></i>
                            <span>Gönder</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="space-y-6">
                <!-- Chat Stats -->
                <div class="card rounded-xl p-4">
                    <h3 class="font-medium text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-400"></i>
                        Sohbet İstatistikleri
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Bu Oturum</span>
                            <span class="text-white font-medium" id="sessionMessages">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Toplam Mesaj</span>
                            <span class="text-white font-medium" id="totalMessages">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Durum</span>
                            <span class="text-green-400 font-medium">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card rounded-xl p-4">
                    <h3 class="font-medium text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-400"></i>
                        Hızlı İşlemler
                    </h3>
                    <div class="space-y-2">
                        <button class="w-full text-left px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-md transition-colors duration-200 text-sm" onclick="clearChat()">
                            <i class="fas fa-trash-alt mr-2 text-red-400"></i>
                            Sohbeti Temizle
                        </button>
                        <button class="w-full text-left px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-md transition-colors duration-200 text-sm" onclick="exportChat()">
                            <i class="fas fa-download mr-2 text-green-400"></i>
                            Sohbeti Dışa Aktar
                        </button>
                        <button class="w-full text-left px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-md transition-colors duration-200 text-sm" onclick="copyLastResponse()">
                            <i class="fas fa-copy mr-2 text-blue-400"></i>
                            Son Yanıtı Kopyala
                        </button>
                    </div>
                </div>

                <!-- Model Info -->
                <div class="card rounded-xl p-4">
                    <h3 class="font-medium text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-cog text-gray-400"></i>
                        Model Bilgileri
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Model</span>
                            <span class="text-white font-medium text-sm">GPT-3.5-turbo</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Sıcaklık</span>
                            <span class="text-white font-medium text-sm">0.7</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Max Token</span>
                            <span class="text-white font-medium text-sm">4096</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const chatMessages = $('#chatMessages');
    const messageInput = $('#messageInput');
    const sendButton = $('#sendButton');
    const typingIndicator = $('#typingIndicator');
    const chatForm = $('#chatForm');
    
    let sessionMessageCount = 0;
    let totalMessageCount = 0;
    
    // CSRF token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Auto scroll to bottom
    function scrollToBottom() {
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
    
    // Update message counters
    function updateCounters() {
        $('#sessionMessages').text(sessionMessageCount);
        $('#totalMessages').text(totalMessageCount);
    }
    
    // Add message to chat
    function addMessage(message, isUser = false) {
        const messageClass = isUser ? 'user' : 'assistant';
        const bgClass = isUser ? 'bg-blue-600' : 'bg-gray-700';
        const iconContent = isUser ? '<i class="fas fa-user text-white text-sm"></i>' : '<img src="{{ asset("ggpt.png") }}" alt="GlobalGPT" class="w-10 h-10 rounded-lg">';
        const alignment = isUser ? 'flex-row-reverse' : '';
        const messageAlignment = isUser ? 'text-right' : '';
        
        const messageHtml = `
            <div class="chat-message mb-4">
                <div class="flex items-start gap-3 ${alignment}">
                    <div class="w-10 h-10 ${isUser ? bgClass : ''} rounded-full flex items-center justify-center flex-shrink-0">
                        ${iconContent}
                    </div>
                    <div class="${bgClass} rounded-lg px-4 py-2 max-w-md ${messageAlignment}">
                        <p class="text-white">${message}</p>
                    </div>
                </div>
            </div>
        `;
        
        chatMessages.append(messageHtml);
        scrollToBottom();
        
        sessionMessageCount++;
        totalMessageCount++;
        updateCounters();
    }
    
    // Show typing indicator
    function showTyping() {
        typingIndicator.removeClass('hidden');
        scrollToBottom();
    }
    
    // Hide typing indicator
    function hideTyping() {
        typingIndicator.addClass('hidden');
    }
    
    // Handle form submission
    chatForm.on('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.val().trim();
        if (!message) return;
        
        // Add user message
        addMessage(message, true);
        
        // Clear input and disable send button
        messageInput.val('');
        sendButton.prop('disabled', true);
        sendButton.html('<i class="fas fa-spinner fa-spin mr-2"></i>Gönderiliyor...');
        
        // Show typing indicator
        showTyping();
        
        // Send AJAX request
        $.ajax({
            url: '/chat',
            method: 'POST',
            data: {
                message: message
            },
            success: function(response) {
                hideTyping();
                
                if (response.success) {
                    addMessage(response.message);
                } else {
                    addMessage('Üzgünüm, bir hata oluştu. Lütfen tekrar deneyin.');
                }
            },
            error: function(xhr, status, error) {
                hideTyping();
                
                let errorMessage = 'Bir hata oluştu. Lütfen tekrar deneyin.';
                
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.status === 422) {
                    errorMessage = 'Mesajınız çok uzun. Lütfen daha kısa bir mesaj yazın.';
                } else if (xhr.status === 429) {
                    errorMessage = 'Çok fazla istek gönderdiniz. Lütfen biraz bekleyin.';
                }
                
                addMessage(errorMessage);
            },
            complete: function() {
                // Re-enable send button
                sendButton.prop('disabled', false);
                sendButton.html('<i class="fas fa-paper-plane mr-2"></i>Gönder');
                messageInput.focus();
            }
        });
    });
    
    // Handle Enter key
    messageInput.on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            chatForm.submit();
        }
    });
    
    // Focus on input
    messageInput.focus();
    
    // Initialize counters
    updateCounters();
});

// Quick action functions
function clearChat() {
    if (confirm('Sohbet geçmişini temizlemek istediğinizden emin misiniz?')) {
        $('#chatMessages').html(`
            <div class="chat-message mb-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="w-10 h-10 rounded-lg">
                    </div>
                    <div class="bg-gray-700 rounded-lg px-4 py-2 max-w-md">
                        <p class="text-white" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">Merhaba! Ben GlobalGPT, sizin AI asistanınızım. Size nasıl yardımcı olabilirim?</p>
                    </div>
                </div>
            </div>
        `);
        $('#sessionMessages').text('0');
    }
}

function exportChat() {
    const messages = [];
    $('#chatMessages .chat-message').each(function() {
        const text = $(this).find('p').text();
        const isUser = $(this).find('.fa-user').length > 0;
        messages.push({
            role: isUser ? 'user' : 'assistant',
            content: text
        });
    });
    
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(messages, null, 2));
    const downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", "globalgpt-chat-" + new Date().toISOString().split('T')[0] + ".json");
    document.body.appendChild(downloadAnchorNode);
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}

function copyLastResponse() {
    const lastAssistantMessage = $('#chatMessages .chat-message').last().find('p').text();
    if (lastAssistantMessage) {
        navigator.clipboard.writeText(lastAssistantMessage).then(function() {
            // Show temporary success message
            const originalText = $('#sendButton').html();
            $('#sendButton').html('<i class="fas fa-check mr-2"></i>Kopyalandı!');
            setTimeout(function() {
                $('#sendButton').html(originalText);
            }, 2000);
        });
    }
}
</script>
@endsection
