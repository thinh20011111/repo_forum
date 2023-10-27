@foreach ($messages as $message)
<div class="chat-message-{{ $message->infor_sender->id == Auth::user()->id ? 'right' : 'left' }} pb-4">
    <div>
        <img src="front/img/users/{{ $message->infor_sender->avatar ?? 'default_user.png' }}" class="rounded-circle mr-1" alt="{{ $message->infor_sender->name }}" style="width: 40px;height: 40px;object-fit: cover;">
    </div>
    <div class="flex-shrink-1 bg-light rounded py-2 px-3 {{ $message->infor_sender->id == Auth::user()->id ? 'mr-3' : 'ml-3' }}">
        <span class="d-inline-block d-sm-block messages-content">
            {{ $message->content }}
        </span>
        <div class="text-muted small text-nowrap mt-2">
            {{ formatTime($message->created_at) }}
        </div>
    </div>
</div>
@endforeach