<!DOCTYPE html>

<html>

    <head>

        <title>Laravel 6 Uploads Example</title>
        
        {{-- jQuery is used in a few places to save time --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

        {{-- Dropzone Stuff --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js" integrity="sha256-cs4thShDfjkqFGk5s2Lxj35sgSRr4MRcyccmi0WKqCM=" crossorigin="anonymous"></script>

    </head>

    <body>

        <div>

            @yield('content')

        </div>

    </body>

</html>