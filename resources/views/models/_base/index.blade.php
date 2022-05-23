<x-layout>

@php $fields = $record->getFields();    @endphp
    <altius::x-portal type="blue" class="w-1/2">
        <altius::x-portal.header>
        {{ $record->plural }}
            <altius::x-portal.actions>
                <a href="{{ $record->routeAll('create') }}" class="btn btn-blue">Create {{ $record->singular }}</a>
                </altius::x-portal.actions>
        </altius::x-portal.header>
        <table class="table table-sm w-full">
            <tr>
                <th>Action</th>
                @foreach($fields as $f)
                <th>{{ $f->getLabel() }}</th>
                @endforeach
            </tr>
            @foreach($records as $r)
            <tr>
                <td><a class="btn btn-xs btn-blue" href="{{ $r->route()}}">View</a>
                    <a class="btn btn-xs btn-blue" href="{{ $r->route('edit') }}">Edit</a>
                    <a class="btn btn-xs btn-blue" href="{{ $r->route('delete') }}">Delete</a>      
                </td>
                    @php $fields->setValues($r) @endphp
                    @foreach($fields as $f)
                    <td>
                        @include('altius::forms.fields.display',['field' => $f, 'value' => $r->{$f->name}])
                    </td>
                    @endforeach
            </tr>   
            @endforeach
            <tr><td colspan="100">
                {!! $records->links() !!}

            </td></tr>

            </table>
    </altius::x-portal>









</x-layout>