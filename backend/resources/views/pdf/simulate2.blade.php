@php                
    $table = generateLoanTable($loanAmount, $interestRate, $months); 

    // Hitung total dengan pembulatan ke ribuan terdekat
    $totalPokok = round(array_sum(array_column($table, 'Pokok')), -3);
    $totalBunga = round(array_sum(array_column($table, 'Bunga')), -3);
    $totalAngsuran = round(array_sum(array_column($table, 'Angsuran')), -3);
@endphp

<h3>Kalkulator Simulasi Kredit</h3>
<table class="lft">
    <tr>
        <td width="120"><strong>Jenis Pinjaman</strong></td>
        <td width="8">:</td>
        <td>{{ $q->name }}</td>
    </tr>
    <tr>
        <td><strong>Pinjaman</strong></td>
        <td>:</td>
        <td>{{ number_format($loanAmount, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Bunga</strong></td>
        <td>:</td>
        <td>{{ number_format($interestRate, 2) }}%</td>
    </tr>
    <tr>
        <td><strong>Jangka Waktu</strong></td>
        <td>:</td>
        <td>{{ @($year) ? $year.' ('.$months.' bulan )' : $months . ' bulan' }}</td>
    </tr>
</table>

<br>

<table>
    <tr>
        <th>Bulan</th>
        <th>Pokok</th>
        <th>Bunga</th>
        <th>Angsuran</th>
        <th>Sisa</th>
    </tr>

    @foreach ($table as $row)
    <tr>
        <td>{{ $row['Bulan'] }}</td>
        <td>{{ number_format((float) $row['Pokok'], 0, ',', '.') }}</td>
        <td>{{ number_format((float) $row['Bunga'], 0, ',', '.') }}</td>
        <td>{{ number_format((float) $row['Angsuran'], 0, ',', '.') }}</td>
        <td>{{ isset($row['Sisa']) ? number_format((float) $row['Sisa'], 0, ',', '.') : '-' }}</td>
    </tr>
    @endforeach

    <!-- Tambahkan baris total -->
    <tr>
        <th>Total</th>
        <th>{{ number_format($totalPokok, 0, ',', '.') }}</th>
        <th>{{ number_format($totalBunga, 0, ',', '.') }}</th>
        <th>{{ number_format($totalAngsuran, 0, ',', '.') }}</th>
        <th>-</th> <!-- Sisa tidak dijumlahkan karena hanya menunjukkan saldo akhir -->
    </tr>
</table>
