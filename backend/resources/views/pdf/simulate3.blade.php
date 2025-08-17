@php                
    $result = calculateAnnuityLoanKMG($loanAmount, $interestRate, $months); 
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

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Angsuran Pokok</th>
            <th>Angsuran Bunga</th>
            <th>Total Angsuran</th>
            <th>Outstanding Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result['schedule'] as $row)
            <tr>
                <td>{{ $row['no'] }}</td>
                <td>{{ number_format($row['angsuran_pokok'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['angsuran_bunga'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['total_angsuran'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['outstanding_kredit'], 0, ',', '.') }}</td>
            </tr>
        @endforeach

         <!-- Tambahkan baris total -->
        <tr>
            <th>Total</th>
            <th>{{ number_format($result['total_pokok'], 0, ',', '.') }}</th>
            <th>{{ number_format($result['total_bunga'], 0, ',', '.') }}</th>
            <th>{{ number_format($result['total_angsuran'], 0, ',', '.') }}</th>
            <th>-</th> <!-- Sisa tidak dijumlahkan karena hanya menunjukkan saldo akhir -->
        </tr>
    </tbody>
</table>
