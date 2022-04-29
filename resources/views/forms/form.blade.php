<hr>
Form in Altius namespace
<hr>
<h1>Title:  {{$form->title}}</h1>

<form method="POST" action="{{ $form->action }}">
    @csrf
    @method($form->method)

    @foreach($form->fields() as $f)
        @include('altius::forms.field',['field'=>$f])
        @json($f)<hr>
    @endforeach
    <hr>
    <button class="btn btn-blue" type="submit">Submit</button>
</form>
