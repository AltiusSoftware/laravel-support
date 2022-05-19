@php $record= $field->getRecord(); 
    
@endphp
<div class="w-full">
    @if($record)
        {{ $record->summary }} ({{ $record->id }}) <a class="link" href="{{ $record->route()}}">View</a>
    @else
        <null>
    @endif


</div>