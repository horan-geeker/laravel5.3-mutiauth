<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ elixir('assets/css/web/app.css') }}" rel="stylesheet" type="text/css">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body>

<div id="app"></div>

<script src="{{ elixir('assets/js/web/app.js') }}"></script>
</body>
</html>
