
<div class="alert alert-{{ $getClass() }} {{ $isDismissable() ? 'alert-dismissible' : '' }}" role="alert">
    @if ($shouldShowIcon())
    {!! $getIcon() !!}
    @endif
    @if ($shouldShowTitle())
    <strong>{{ $getTitle() }}: </strong>
    @endif
    {!! $getMessage() !!}
    @if ($isDismissable())
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
