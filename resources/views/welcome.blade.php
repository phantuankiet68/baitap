<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="https://kit.fontawesome.com/0dc07ae90e.js" crossorigin="anonymous"></script>
       
        
        @vite('resources/css/app.css')
    </head>
    <body>
         <div id="app" >

         </div>
         @vite('resources/js/app.js')
         @vite('resources/js/script.js')
    </body>
</html>
