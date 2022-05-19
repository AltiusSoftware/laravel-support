
<div class="w-full">
    @if($record = $field->getRecord() )
        {{ $record->summary }} ({{ $record->id }}) <a class="link" href="{{ $record->route()}}">View</a>
    @else
        <null>
    @endif


</div>

