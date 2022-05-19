<!doctype html>
<html>

  <head>
    @include('altius::layout.head')
  </head>

  <body class="bg-blue-200">
    <div class="w-full sm:w-2/3 lg:w-1/3 mx-auto p-2 mt-8">
      @include('altius::layout.login.header')

        {{ $slot }}

        {!! messages()->showAll() !!}
        
      @include('altius::layout.login.footer')

</div>
  @include('altius::layout.scripts')
</body>
</html>

