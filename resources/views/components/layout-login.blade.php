<!doctype html>
<html>

  <head>
    @include('altius::layout.head')
  </head>

  <body class="m-10 bg-blue-200">


  {{ $slot }}

   
  @include('altius::layout.scripts')
</body>
</html>

