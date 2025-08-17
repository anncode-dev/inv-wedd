<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{!! env('APP_NAME') !!}</title>
    <style type="text/css">
        body { overflow: hidden; font-family: sans-serif; background:#fff; }

        #container { width:100%; height:100%; background:#fff; position:relative }
        .centerForm {
            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .fill { padding: 1rem; width: 100%; max-width: 400px; margin: auto; }
        input[type="text"] {
            width: 100%;
            padding: 0.8rem;
            font-size: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #333;
        }
        .logo { width: 25%; margin-bottom: 2rem; }
        @media (max-width:480px)  { 
            .logo { width: 50%;} 
        } 
    </style>
</head>
<body>        
    <div id="container">
        <div class="fill">
            <div class="centerForm">
                <img class="logo" src="/img/logo.svg" alt="Logo">
                
                <form id="guestForm">
                    <input type="text" id="guestName" placeholder="Masukkan nama Anda" required>
                    <button type="submit">Masuk</button>
                </form>
            </div>
        </div>            
    </div>

    <script>
        function generateCode(length = 8) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for (let i = 0; i < length; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return code;
        }

        document.getElementById('guestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('guestName').value.trim();
            if(name === '') return alert('Silakan masukkan nama Anda');

            const code = generateCode();
            const url = `https://inv-wedd.vercel.app/kodetamu?code=${code}&name=${encodeURIComponent(name)}`;
            window.location.href = url;
        });
    </script>
</body>
</html>
