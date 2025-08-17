<?php
use App\Models\TypeProfileCategory;

function getyears() {
    $currentYear = (int)date('Y');
    $years = [];

    for ($i = 0; $i < 10; $i++) {
        $year = $currentYear - $i;
        $years[$year] = $year;
    }

    return $years;
}

function getNamaBulan()
{
    return [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
}

function MonthlyReport(){            
    return TypeProfileCategory::pluck('title', 'id')->toArray();
}

function convertYearsToMonths($years)
{
    return $years * 12;
}

function Triwulan()
{
    return [1 => 'Triwulan 1', 2 => 'Triwulan 2', 3 => 'Triwulan 3', 4 => 'Triwulan 4'];
}

function Caturwulan()
{
    return [5 => 'Caturwulan 1', 6 => 'Caturwulan 2', 7 => 'Caturwulan 3'];
}

function generateLoanTable($loanAmount, $interestRate, $months) {
    $monthlyPrincipal = round($loanAmount / $months, 0); 
    $remainingBalance = $loanAmount;
    $data = [];

    for ($i = 1; $i <= $months; $i++) {
        $monthlyInterest = round(($remainingBalance * ($interestRate / 100)) / 12, 0);
        $monthlyInstallment = round($monthlyPrincipal + $monthlyInterest, 0);
        $remainingBalance -= $monthlyPrincipal;

        if ($i == $months) {
            $remainingBalance = 0;
        }

        $data[] = [
            'Bulan' => $i,
            'Pokok' => $monthlyPrincipal,
            'Bunga' => $monthlyInterest,
            'Angsuran' => $monthlyInstallment,
            'Sisa' => max(0, round($remainingBalance, 0))
        ];
    }

    return $data;
}

function calculateAnnuityLoanKBR($loanAmount, $interestRate, $months) {
    $monthlyRate = ($interestRate / 100) / 12; // Suku bunga per bulan
    $annuityFactor = ($monthlyRate * pow(1 + $monthlyRate, $months)) / (pow(1 + $monthlyRate, $months) - 1);
    $monthlyInstallment = round($loanAmount * $annuityFactor, 0); // Total angsuran per bulan

    $schedule = [];
    $outstanding = $loanAmount;

    // Variabel total
    $totalPokok = 0;
    $totalBunga = 0;
    $totalAngsuran = 0;

    for ($i = 1; $i <= $months; $i++) {
        $interest = round($outstanding * $monthlyRate, 0); // Hitung bunga
        $principal = $monthlyInstallment - $interest; // Hitung angsuran pokok
        $outstanding -= $principal; // Update saldo kredit

        // Jika di cicilan terakhir masih ada sisa outstanding, sesuaikan
        if ($i == $months && $outstanding != 0) {
            $principal += $outstanding;
            $outstanding = 0;
        }

        // Akumulasi total
        $totalPokok += $principal;
        $totalBunga += $interest;
        $totalAngsuran += $monthlyInstallment;

        $schedule[] = [
            'no' => $i,
            'angsuran_pokok' => $principal,
            'angsuran_bunga' => $interest,
            'total_angsuran' => $monthlyInstallment,
            'outstanding_kredit' => $outstanding,
        ];

        if ($outstanding < 0) {
            $outstanding = 0;
        }
    }

    return [
        'schedule' => $schedule,
        'total_pokok' => $totalPokok,
        'total_bunga' => $totalBunga,
        'total_angsuran' => $totalAngsuran,
    ];
}

function calculateAnnuityLoanKMG($plafon, $rate, $months)
    {
        $monthlyRate = $rate / 12 / 100; // Suku bunga per bulan dalam desimal
        $annuityFactor = ($monthlyRate * pow(1 + $monthlyRate, $months)) / (pow(1 + $monthlyRate, $months) - 1);
        $monthlyInstallment = $plafon * $annuityFactor;

        $schedule = [];
        $outstanding = $plafon;
        
        // Variabel untuk total
        $totalPokok = 0;
        $totalBunga = 0;
        $totalAngsuran = 0;

        for ($i = 1; $i <= $months; $i++) {
            $interest = $outstanding * $monthlyRate;
            $principal = $monthlyInstallment - $interest;
            $outstanding -= $principal;

            // Akumulasi total
            $totalPokok += $principal;
            $totalBunga += $interest;
            $totalAngsuran += $monthlyInstallment;

            $schedule[] = [
                'no' => $i,
                'angsuran_pokok' => round($principal),
                'angsuran_bunga' => round($interest),
                'total_angsuran' => round($monthlyInstallment),
                'outstanding_kredit' => round($outstanding),
            ];
        }

        return [
            'schedule' => $schedule,
            'total_pokok' => round($totalPokok),
            'total_bunga' => round($totalBunga),
            'total_angsuran' => round($totalAngsuran),
        ];
    }

function hitungAngsuranKPR($bunga, $periode, $jumlah) {
    // Pastikan bunga dalam desimal (misal: 5% -> 0.05)
    if ($bunga <= 0 || $periode <= 0) {
        return 0; // Hindari pembagian dengan nol
    }

    // Hitung angsuran berdasarkan rumus yang diberikan
    $pembilang = $bunga * $jumlah;
    $penyebut = 1 - (1 / pow(1 + $bunga, $periode));
    
    if ($penyebut == 0) {
        return 0; // Hindari kesalahan matematika
    }

    $hasil = ($pembilang / $penyebut) / 12;
    return $hasil;
}

function hitungAngsuranKBP($plafond, $tenor, $bungaTahunan) {
    $bungaBulanan = $bungaTahunan / 12 / 100;
    $angsuranPokok = $plafond / $tenor;
    $data = [];

    // Tambahkan baris header untuk bulan ke-0
    $data[] = [
        'bulan' => 0,
        'pokok' => null,
        'bunga' => null,
        'total' => null,
    ];

    for ($bulan = 1; $bulan <= $tenor; $bulan++) {
        $sisaPinjaman = $plafond - ($angsuranPokok * ($bulan - 1));
        $bunga = $sisaPinjaman * $bungaBulanan;
        $totalAngsuran = $angsuranPokok + $bunga;

        $data[] = [
            'bulan' => $bulan,
            'pokok' => $angsuranPokok,
            'bunga' => $bunga,
            'total' => $totalAngsuran,
        ];
    }

    return $data;
}

function procurement(){            
    return [
        '1' => 'Pengadaan Barang dan Jasa',
        '2' => 'SDM',
        '3' => 'Lelang Agunan',                
        '4' => 'Pengumuman',                
    ];
}

function SyariahInformation(){            
    return [
        '1' => 'Bagi Hasil',                
    ];
}

function insertDateTime(){            
    return date('Y-m-d H:i:s');
}

function insertDateToDB($datetodb){            
    if($datetodb !='00-00-0000' && !empty($datetodb)){	
        $date = date('Y-m-d',strtotime($datetodb));					
    }else{
        $date = null;
    }	
    
    return $date; 
}

function DateToView($datetodb){            
    if($datetodb !='00-00-0000' && !empty($datetodb)){	
        $date = date('d M Y',strtotime($datetodb));					
    }else{
        $date = "";
    }	
    
    return $date; 
}

function DateTimeToView($datetodb){            
    if($datetodb !='00-00-0000' && !empty($datetodb)){	
        $date = date('Y-m-d H:i:s',strtotime($datetodb));					
    }else{
        $date = "";
    }	
    
    return $date; 
}

function csvToArray($filename = '', $delimiter = ',')
{
    
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    return $data;
}


