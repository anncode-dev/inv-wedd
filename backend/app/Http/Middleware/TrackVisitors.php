<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\News;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CreditCalculator;
use App\Models\CreditCalculatorVisit;
use Illuminate\Support\Facades\Log;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $url = $request->url();

        // Simpan data pengunjung ke database
        Visitor::updateOrCreate(['ip_address' => $ip],[
            'url' => $url,
        ]);

        // Periksa URL yang diterima
        Log::info('URL: ' . $url);
        
        // Periksa ID yang diekstrak dari URL
        $id = $this->extractIdFromUrl($request);
        //Log::info('Extracted ID: ' . $id);
        
        // Perbarui field count berdasarkan URL
        if (strpos($url, '/news') !== false) {
            $id = $request->id;
            News::where('id', $id)->increment('count');
        } elseif (strpos($url, '/promo') !== false) {
            $id = $request->id;
            Promo::where('id', $id)->increment('count');
        } elseif (strpos($url, '/products') !== false) {            
            Product::where('id', $id)->increment('count');
        } elseif (strpos($url, '/table-simulate') !== false) {            
            $id = $request->credit_type;
            $id = CreditCalculator::where('type', $id)->first()->id;
            CreditCalculatorVisit::updateOrCreate(['ip_address' => $ip],[
                'credit_calculator_id' => $id,
                'ip_address' => $ip,
            ]);
        }

        return $next($request);
    }

    /**
     * Extract ID from URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function extractIdFromUrl(Request $request)
    {
        return (int) $request->query('detail_id', 0);
    }
}