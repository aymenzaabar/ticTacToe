<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Morpion</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet">
<style>
        /* Ajouter l'image comme arrière-plan */
        body {
    background: rgba(0, 0, 0, 0.5); /* Un fond semi-transparent */
    background-image: url('https://static.vecteezy.com/system/resources/thumbnails/046/558/099/small_2x/cartoon-planet-surface-with-craters-space-scene-vector.jpg');



}

    </style>
</head>
<body class="bg-gray-100 text-gray-900">
<div class="max-w-xl mx-auto p-6">
@yield('content')
</div>
</body>
</html>