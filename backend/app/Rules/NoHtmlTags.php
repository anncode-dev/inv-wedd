<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoHtmlTags implements Rule
{
    public function passes($attribute, $value)
    {
        // Cek apakah nilai setelah strip_tags sama dengan nilai aslinya
        return strip_tags($value) === $value;
        
        // Atau bisa juga menggunakan regex:
        // return !preg_match('/<[^>]*>/', $value);
    }

    public function message()
    {
        return 'The :attribute field must not contain HTML or JavaScript code.';
    }
}