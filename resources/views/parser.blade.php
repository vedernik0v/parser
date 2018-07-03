<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Index</title>

        <!-- Styles -->
        <style>
            html,body{background-color:#fff;color:#636b6f;font-family:'Raleway', sans-serif;font-weight:100;height:100vh;margin:0;}
            .full-height {height: 100vh;}
            .flex-center {align-items:center;display:flex;justify-content:center;}
            .position-ref {position:relative;}
            .content { text-align:center;}
            .dev {display:none};
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <form action="/" method="POST">
                        {{ csrf_field() }}
                        <input type="input" name="s">
                        <button>OK</button>
                    </form>
                </div>
                @isset($s)
                <div class="dev">
                    <small>{{ $s }}</small><br>
                    {{ $url }} {{ $cssSelector }}
                </div>
                {{ $content }}
                @endisset
            </div>
        </div>
    </body>
</html>
