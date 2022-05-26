<x-layout>

@php $fields = $record->getFields();    @endphp


    <x-portal type="blue" class="w-1/2">
        <x-portal.header>
            {{ $record->plural }}
            <x-portal.actions>
                <a href="{{ $record->routeAll('create') }}" class="btn btn-blue">Create {{ $record->singular }}</a>
            </x-portal.actions>
        </x-portal.header>
        <form>
            Search:  <input type="text" name="q" placeholder="Search" value="{{ request()->get('q')}}">
        </form>

        Records: <a class="link" href="{{ $record->routeAll('index',['rows' => 20]) }}"> 20 </a> 
                 <a class="link" href="{{ $record->routeAll('index',['rows' => 50]) }}"> 50 </a>
                 <a class="link" href="{{ $record->routeAll('index',['rows' => 100]) }}"> 100 </a>

        <table class="table table-sm w-full">
            <tr>
                <th>Action</th>
                @foreach($fields as $f)
                <th>{{ $f->getLabel() }}</th>
                @endforeach
                @include($record->view('browse.extraHeaders'))
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
                        @include('forms.fields.display',['field' => $f, 'value' => $r->{$f->name}])
                    </td>
                    @endforeach
                    @include($record->view('browse.extraColumns'),['record'=>$r])
            </tr>   
            @endforeach
            <tr><td colspan="100">
                {!! $records->links() !!}

            </td></tr>

            </table>
    </x-portal>









</x-layout>