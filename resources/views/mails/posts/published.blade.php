<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            background-color: rgb(102, 239, 177);
            text-align: center;
            padding: 50px;
        }
    </style>
</head>
<body>
    <h1>Complimenti il tuo Post è stato aggiunto!!</h1>
    <h5>Titolo: {{ $post->title }}</h5>
    <p>Categoria: {{ $post->category->label }}</p>
    <address>Creato: {{ $post->created_at }}</address>
</body>
</html>
      
      
      
