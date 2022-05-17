<table class="table striped hover table-sm w-full">
    <tr>
        <th>Field</th>
        <th>Value</th>
    </tr>
    @foreach($fields as $f)
    <tr>
        <td class="text-right">
            {{ $f->getLabel() }}
        </td>
        <td>
            @include('altius::forms.fields.display',['field' => $f, 'value' => $f->getValue()])
            
        </td>
    </tr>
    @endforeach

</table>