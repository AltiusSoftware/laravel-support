<x-layout>


<div class="grid grid-cols-2 gap-2">
    <x-portal type="blue" class="w-full">
            <x-portal.header>
        
                {{ $record->singular}}: {{ $record->summary }}
                <x-portal.actions>
                                    @include($record->view('record.actions'))

                </x-portal.actions>
            </x-portal.header>
            <table class="table table-md w-full">
                @include('altius::fields.table.rows', ['fields'=>$record->getFields()->setValues($record)])
            </table>
    </x-portal>
   
    @foreach($record->getChildrenInfo() as $c)

        <x-portal type="blue" class="w-full">
            <x-portal.header>
                    {{ $c->new->plural }}
                <x-portal.actions>
                    <a class="btn btn-xs btn-blue" href="{{ $c->new->routeAll()}}">View {{ $c->new->plural }}</a>
                </x-portal.actions>
            </x-portal.header>
            
    </x-portal>
    @endforeach
    @include($record->view('record.grid'))
</div>
    
</x-layout>
