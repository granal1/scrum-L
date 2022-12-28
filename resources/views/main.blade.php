<!doctype html>
<html>

<head>
    <title>
        @section('title')@show
    </title>
    <meta lang="ru">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body  class="bg-dark" style="--bs-bg-opacity: .15;">
    <div class="container-fluid p-0">
        @yield('header')
        @yield('content')
        @yield('footer')
    </div>
</body>

</html>
