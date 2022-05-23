<x-layout>

<div class="w-1/2">
<altius::x-portal type="blue">
        <altius::x-portal.header>
        Create {{ $record->singular }}
        </altius::x-portal.header>
        @include('altius::forms.form')
</altius::x-portal>        
</div>


</x-layout>