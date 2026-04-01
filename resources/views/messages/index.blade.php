@extends('layouts.app')

@section('content')
<div style="margin-top: 3rem;">
    <h1>My Messages</h1>
    <p class="card-meta">You have {{ $conversations->count() }} conversations.</p>

    <div class="card" style="margin-top: 2rem;">
        @if($conversations->isEmpty())
            <p style="text-align: center; padding: 2rem;">You have no messages.</p>
        @else
            <ul style="list-style: none; padding: 0;">
                @foreach($conversations as $conversation)
                    @php
                        $otherUser = $conversation->userOne->is(Auth::user()) ? $conversation->userTwo : $conversation->userOne;
                        $lastMessage = $conversation->messages->last();
                    @endphp
                    <li style="border-bottom: 1px solid var(--border-color); padding: 1rem;">
                        <a href="{{ route('messages.show', $conversation) }}" style="text-decoration: none; color: inherit; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="font-weight: 600;">{{ $otherUser->name }}</h4>
                                <p style="color: #555; font-size: 0.9rem;">
                                    @if($lastMessage)
                                        {{ Str::limit($lastMessage->content, 50) }}
                                    @else
                                        <em>No messages yet.</em>
                                    @endif
                                </p>
                            </div>
                            <span style="font-size: 0.8rem; color: #777;">{{ $conversation->updated_at->diffForHumans() }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
