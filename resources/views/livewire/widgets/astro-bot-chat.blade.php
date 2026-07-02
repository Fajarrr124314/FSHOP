<div class="astro-bot-container">
    <button class="astro-trigger" wire:click="toggleChat" title="AstroBot Support">
        <i class="fa-solid fa-robot"></i>
    </button>

    <div class="chat-box-window glass-card {{ $isOpen ? 'show' : '' }}">
        <div class="chat-header">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
                <i class="fa-solid fa-robot" style="color: var(--accent-color);"></i>
                <div>
                    <h4 style="font-size: 0.95rem; margin: 0; color: var(--text-primary);">AstroBot FSHOP</h4>
                    <span style="font-size: 0.75rem; color: #2ecc71;">Online Assistant</span>
                </div>
            </div>
            <button wire:click="toggleChat" style="background: none; border: none; color: var(--text-secondary); cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="chat-body">
            @foreach($messages as $msg)
                <div class="chat-msg {{ $msg['sender'] === 'bot' ? 'msg-bot' : 'msg-user' }}">
                    {{ $msg['text'] }}
                </div>
            @endforeach
        </div>

        <div style="padding: 0.4rem 0.8rem; display: flex; gap: 0.4rem; overflow-x: auto; background: rgba(0,0,0,0.1);">
            <button type="button" style="padding: 0.2rem 0.6rem; border-radius: 12px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); font-size: 0.75rem; white-space: nowrap; cursor: pointer;" wire:click="sendMessage('Berapa harga pembuatan web?')">Harga Web?</button>
            <button type="button" style="padding: 0.2rem 0.6rem; border-radius: 12px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); font-size: 0.75rem; white-space: nowrap; cursor: pointer;" wire:click="sendMessage('Bagaimana cara buat CV?')">Cara Buat CV?</button>
            <button type="button" style="padding: 0.2rem 0.6rem; border-radius: 12px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); font-size: 0.75rem; white-space: nowrap; cursor: pointer;" wire:click="sendMessage('Bisa lihat portofolio FSHOP?')">Portofolio?</button>
        </div>

        <form wire:submit.prevent="sendMessage()" class="chat-footer">
            <input type="text" class="form-input" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;" placeholder="Ketik pertanyaan..." wire:model="userMessage">
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.5rem 0.8rem;">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>
