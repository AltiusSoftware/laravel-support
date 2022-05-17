<select
    id = "{{ $field->getID() }}"
    class="@error($field->name) is-invalid @enderror w-full"
    name="{{ $field->name }}"
>    
    @foreach($field->getOptions()  as $k =>$v)
        <option @if($field->getFormValue()==$k)selected @endif value="{{$k}}">{{ $v }}</option>
    @endforeach
</select>
