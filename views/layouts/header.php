<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
    <link rel="stylesheet" href="{{asset}}css/style.css">
    <script src="{{asset}}js/scrolling.js" defer></script>
    <script src="{{asset}}js/select-options.js" defer></script>
</head>
<body>
    <nav>
        <div class="logo">
            <div class="logo-img"><img src="{{asset}}img/nav/logo.jpg" alt="logo_img"></div>
            <h2>Deluxe Location</h2>
        </div>
        {% if isError is empty %}
        {{ include('layouts/nav.php')}}
        {% endif %}
    </nav>
<main>