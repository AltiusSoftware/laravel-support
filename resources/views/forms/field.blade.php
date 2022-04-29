
<label for="{{ $field->getID()  }}">{{ $field->name }}</label>
 
<input id="{{ $field->getID() }}"
    name="{{ $field->name}}"
    type="{{ $field->type }}"
    class="@error($field->name) is-invalid @enderror">
 
@error($field->name)
    <div class="alert alert-danger">{{ $message }}</div>
@enderror