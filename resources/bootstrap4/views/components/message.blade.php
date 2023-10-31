
<div class="alert alert-{{ $getClass() }} {{ $isDismissable() ? 'alert-dismissible' : '' }}" role="alert">
    @if ($shouldShowIcon())
    {!! $getIcon() !!}
    @endif
    @if ($shouldShowTitle())
    <strong>{{ $getTitle() }}: </strong>
    @endif
    {!! $getMessage() !!}
    @if ($isDismissable())
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @endif
</div>
