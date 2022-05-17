@foreach($fields as $f)
    <tr>
        <td class="text-right font-bold">
            {{ $f->getLabel() }}
        </td>
        <td>
            @include('altius::forms.fields.display',['field' => $f, 'value' => $f->getValue()])
        </td>
    </tr>
@endforeach