@extends('layouts.app')

@section('content')
<style>
    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        margin-bottom: 0.5rem;
        max-width: 70%;
        word-wrap: break-word;
    }
    .sent {
        background: var(--primary-color);
        color: var(--white);
        align-self: flex-end;
        border-bottom-right-radius: 0.25rem;
    }
    .received {
        background: var(--light-color);
        color: var(--dark-color);
        align-self: flex-start;
        border-bottom-left-radius: 0.25rem;
    }
</style>

<div style="margin-top: 3rem;">
    @php
        $otherUser = $conversation->userOne->is(Auth::user()) ? $conversation->userTwo : $conversation->userOne;
    @endphp
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Conversation with {{ $otherUser->name }}</h1>
        <a href="{{ route('messages.index') }}" class="btn" style="background: var(--dark-color); color: var(--white);">Back to Inbox</a>
    </div>

    <div class="card" style="padding: 2rem;">
        <div id="message-container" style="display: flex; flex-direction: column; gap: 1rem; height: 60vh; overflow-y: auto; padding-right: 1rem; margin-bottom: 2rem;">
            @forelse($conversation->messages as $message)
                <div class="message-bubble {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}">
                    <p>{{ $message->content }}</p>
                    <small style="font-size: 0.7rem; opacity: 0.7;">{{ $message->created_at->format('h:i A') }}</small>
                </div>
            @empty
                <p style="text-align: center; margin-top: 4rem;">No messages in this conversation yet. Start by sending one below.</p>
            @endforelse
        </div>

        <form action="{{ route('messages.send', $conversation) }}" method="POST">
            @csrf
            <div class="form-group" style="display: flex; gap: 1rem;">
                <textarea name="content" rows="2" required placeholder="Type your message..." style="flex: 1;"></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
</div>

<script>
    const container = document.getElementById('message-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
