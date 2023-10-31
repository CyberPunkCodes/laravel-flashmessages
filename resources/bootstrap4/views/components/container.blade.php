<div>
    @foreach($messages as $message)
    <x-flashmessages-message :message-data="$message"></x-flashmessages-message>
    @endforeach
</div>
