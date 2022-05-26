<x-layout>

<div class="w-1/2">
<x-portal type="blue">
        <x-portal.header>
        Create {{ $record->singular }}
        </x-portal.header>
        @include('altius::forms.form')
</x-portal>        
</div>


</x-layout>