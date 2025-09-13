@extends('layouts.app')

@section('title', 'GlobalGPT - AI Sohbet Asistanı')

@section('content')
<div class="chat-container">
    <div class="chat-header">
        <h1 class="brand-title mb-2" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
            <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="me-2" style="width: 32px; height: 32px; display: inline-block; vertical-align: middle;">
            GlobalGPT
        </h1>
        <p class="subtitle mb-0" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
            Yapay zeka destekli sohbet asistanınız
        </p>
    </div>
    
    <div class="chat-messages" id="chatMessages">
        <div class="message assistant">
            <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="me-2" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;">
            <span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">Merhaba! Ben GlobalGPT, sizin AI asistanınızım. Size nasıl yardımcı olabilirim?</span>
        </div>
    </div>
    
    <div class="typing-indicator" id="typingIndicator">
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <div class="message-input">
        <form id="chatForm">
            @csrf
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control" 
                    id="messageInput" 
                    placeholder="Mesajınızı yazın..." 
                    required
                    autocomplete="off"
                >
                <button class="btn btn-send" type="submit" id="sendButton">
                    <i class="fas fa-paper-plane me-2"></i>
                    Gönder
                </button>
            </div>
        </form>
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
    
    // Add message to chat
    function addMessage(message, isUser = false) {
        const messageClass = isUser ? 'user' : 'assistant';
        const icon = isUser ? '<i class="fas fa-user me-2"></i>' : '<img src="{{ asset("ggpt.png") }}" alt="GlobalGPT" class="me-2" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;">';
        
        const messageHtml = `
            <div class="message ${messageClass}">
                ${!isUser ? icon : ''}
                <span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">${message}</span>
                ${isUser ? icon : ''}
            </div>
        `;
        
        chatMessages.append(messageHtml);
        scrollToBottom();
    }
    
    // Show typing indicator
    function showTyping() {
        typingIndicator.show();
        chatMessages.append(typingIndicator);
        scrollToBottom();
    }
    
    // Hide typing indicator
    function hideTyping() {
        typingIndicator.hide();
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
        sendButton.html('<i class="fas fa-spinner fa-spin me-2"></i>Gönderiliyor...');
        
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
                    addMessage('Üzgünüm, bir hata oluştu. Lütfen tekrar deneyin.', false);
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
                
                addMessage(errorMessage, false);
            },
            complete: function() {
                // Re-enable send button
                sendButton.prop('disabled', false);
                sendButton.html('<i class="fas fa-paper-plane me-2"></i>Gönder');
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
    
    // Welcome animation
    setTimeout(function() {
        $('.chat-container').addClass('animate__animated animate__fadeInUp');
    }, 100);
});
</script>
@endsection
