{{header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0")}}
{{header("Expires: Sat, 26 Jul 1997 05:00:00 GMT")}}
<!doctype html>
<html>

<head>
    <title>
        @section('title')@show
    </title>
    <meta lang="ru">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.svg" type="image/svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body  class="bg-dark" style="--bs-bg-opacity: .15; font-size: 0.75em">
    <div class="container-fluid p-0">
        @yield('header')
        @yield('content')
        @yield('footer')
    </div>
</body>

</html>
