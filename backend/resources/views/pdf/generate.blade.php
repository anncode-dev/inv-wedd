<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{!! env('APP_NAME') !!}</title>  

        <style>
            @page {
                
                size: 22cm 36cm;
            }

            .page-break {
                page-break-after: always;
            }
            .logo {
                max-width: 180px;
                margin-bottom: 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;                
            }

            th, td {
                border: 1px solid #ddd;
                padding: 4px;
                text-align: center;
                background-color: white; /* Pastikan background putih */
            }

            th {
                background-color: #007bff !important;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2 !important; /* Paksa warna abu-abu hanya untuk baris genap */
            }

            .lft th, .lft td {
                border: 1px solid #ddd;
                padding: 4px;
                text-align: left !important;
                background-color: white; /* Pastikan tidak ada warna aneh */
            }
        </style>      
    </head>
    <body>      
        <div id="container">              
            <!-- Tambahkan Logo Bank Kalsel -->
            <img src="{{ public_path('img/logosmall.png') }}" alt="Bank Kalsel" class="logo">
            @if(strtolower($credit_type)=='kbr' || strtolower($credit_type)=='kbp')
                @include('pdf.simulate')                          
            @elseif(strtolower($credit_type)=='kur')
                @include('pdf.simulate2')
            @elseif(strtolower($credit_type)=='kmg')
                @include('pdf.simulate3')            
            @else
                @php abort(404, 'Jenis pinjaman tidak terdaftar'); @endphp
            @endif
        </div>
    </body>
</html>
