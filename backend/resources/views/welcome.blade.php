<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{!! env('APP_NAME') !!}</title>
        <style type="text/css">
            body { overflow: hidden; }
            
            #container {width:100%; height:100%; background:#fff; position:relative }
            .centerLogo {
              display: flex;
              justify-content: center;
              text-align: center;
              align-items: center;
              height: 100vh;
            }
            .fill { padding: 1rem;} 
            .fill .logo { vertical-align:middle; width: 25%;} 

            @media (max-width:480px)  { 
                .fill .logo { vertical-align:middle; width: 50%;} 
            } 
        </style>
    </head>
    <body>        
        <div id="container">
            <div class="fill">
                <div class="centerLogo">
                    <div>
                        <img class="logo" src="/img/logo.svg"></img>
                        
                        @if (session('success'))
                            <div style="padding-top: 1rem;">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>                                
            </div>            
        </div>
    </body>
</html>
