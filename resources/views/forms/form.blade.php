<div class="w-full m-auto">
<form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              @if($form->ajax) data-ajax @endif
              action="{{ $form->action }}" method="POST">
              @csrf        
              @method($form->method)
              @if($form->title)
                <div class="mb-6 text-md font-bold text-center">{{ $form->title}}</div>
              @endif
              <p data-error="__form" class="text-red-500 font-bold text-sm"></p>        
                @foreach($form->fields() as $f)
                    <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-0" for="{{ $f->getID()  }}">
                                {{ $f->getLabel() }}
                                {!! $f->isRequired() ? '<i class="fas fa-sm fa-asterisk">*</i>':'' !!}
                                @if(config('app.debug'))
                                    <span class="float-right text-gray-400 hover:text-gray-800">{{ $f->name}}: {{ $f->type }}</span>
                                @endif
                            </label>        
                            @include('altius::forms.fields.editor',['field' => $f, 'value' => $f->getValue()])  

                            <p data-error="{{ $f->name }}" class="text-red-500 text-sm">@error($f->name){{ $message }}@enderror</p>
                                @if($help=$f->help)
                                <p class="text-grey-500 text-sm ">
                                @foreach(Arr::wrap($help) as $h)
                                    {{ $h }} <br/>
                                @endforeach
                                </p>
                
                            @endif
                    </div>
                @endforeach

    <button class="btn btn-blue" type="submit">Submit</button>
</form>
</div>