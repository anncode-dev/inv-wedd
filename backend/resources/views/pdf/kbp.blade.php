@php              
    $angsuranData = hitungAngsuranKBP($loanAmount, $months, $interestRate) ?? [];

    // Hitung total dari masing-masing kolom
    $totalPokok = array_sum(array_column($angsuranData, 'pokok'));
    $totalBunga = array_sum(array_column($angsuranData, 'bunga'));
    $totalAngsuran = array_sum(array_column($angsuranData, 'total'));
@endphp

<h3>Schedule Angsuran Pinjaman $q->name Bank Kalsel</h3>
<table class="lft">
    <tr>
        <td width="120"><strong>Jenis Pinjaman</strong></td>
        <td width="8">:</td>
        <td>{{ $q->name ?? '-' }}</td>
    </tr>
    <tr>
        <td><strong>Pinjaman</strong></td>
        <td>:</td>
        <td>{{ isset($loanAmount) ? 'Rp ' . number_format($loanAmount, 0, ',', '.') : '-' }}</td>
    </tr>
    <tr>
        <td><strong>Bunga</strong></td>
        <td>:</td>
        <td>{{ isset($interestRate) ? number_format($interestRate, 2) . '%' : '-' }}</td>
    </tr>
    <tr>
        <td><strong>Jangka Waktu</strong></td>
        <td>:</td>
        <td>{{ @($year) ? $year.' ('.$months.' bulan )' : $months . ' bulan' }}</td>
    </tr>
</table>

<br>

<table border="1">
    <tr>
        <th rowspan="2">BULAN KE</th>
        <th colspan="2">ANGSURAN</th>
        <th rowspan="2">TOTAL ANGSURAN</th>
    </tr>
    <tr>
        <th>POKOK</th>
        <th>BUNGA</th>
    </tr>

    @if (!empty($angsuranData))
        @foreach ($angsuranData as $angsuran)
            <tr>
                <td align="center">{{ $angsuran['bulan'] ?? '-' }}</td>
                <td>{{ isset($angsuran['pokok']) ? 'Rp ' . number_format($angsuran['pokok'], 2, ',', '.') : '-' }}</td>
                <td>{{ isset($angsuran['bunga']) ? 'Rp ' . number_format($angsuran['bunga'], 2, ',', '.') : '-' }}</td>
                <td>{{ isset($angsuran['total']) ? 'Rp ' . number_format($angsuran['total'], 2, ',', '.') : '-' }}</td>
            </tr>
        @endforeach

        <!-- Baris Total -->
        <tr>
            <th align="center"><strong>TOTAL</strong></th>
            <th><strong>{{ 'Rp ' . number_format($totalPokok, 2, ',', '.') }}</strong></th>
            <th><strong>{{ 'Rp ' . number_format($totalBunga, 2, ',', '.') }}</strong></th>
            <th><strong>{{ 'Rp ' . number_format($totalAngsuran, 2, ',', '.') }}</strong></th>
        </tr>
    @else
        <tr>
            <td colspan="4" align="center">Tidak ada data angsuran</td>
        </tr>
    @endif
</table>
