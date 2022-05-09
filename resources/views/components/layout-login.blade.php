<!doctype html>
<html>
  @push('css')
    <link href="https://insight.pizzaforno.com/css/app.css?id=68d34c6dc3ae686e3728" rel="stylesheet">    
  @endpush

  <head>
    @include('altius::layout.head')
  </head>

  <body class="p-2">


  {{ $slot }}

  @include('altius::layout.scripts')
</body>
</html>

