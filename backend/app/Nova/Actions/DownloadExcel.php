<?php

namespace App\Nova\Actions;

use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel as BaseDownloadExcel;
use Maatwebsite\Excel\Concerns\WithMapping;

class DownloadExcel extends BaseDownloadExcel implements WithMapping
{
    /**
     * Map the data for export.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return array
     */
    public function map($contactUs): array
    {
        return [
            $contactUs->id,
            $contactUs->about,
            $contactUs->name,
            $contactUs->email,
            $contactUs->phone,
            $contactUs->desc, // Pastikan field 'desc' ada di sini
            $contactUs->created_at->format('d M Y H:i:s'),
            $contactUs->status == 1 ? 'Done' : 'Waiting', // Konversi nilai status menjadi label
        ];
    }
}