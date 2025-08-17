<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\AboutUsDetail;
use App\Models\CorporateGovernance;
use App\Models\CorporateGovernanceCategory;
use App\Models\CreditCalculator;
use App\Models\InformationCategory;
use App\Models\Location;
use App\Models\LocationCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Models\ProfileCategory;
use App\Models\TypeProfileCategory;
use App\Models\TypeWebsite;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        TypeWebsite::insert([
            ['name' => 'Bank Kalsel Konvensional'],
            ['name' => 'Bank Kalsel Syariah']
        ]);
        
        ProductCategory::insert([
            ['title' => '{"id":"Produk Simpanan","en":"Savings Products"}','type' => null,'type_website_id'=>1],
            ['title' => '{"id":"Produk Pinjaman","en":"Loan Products"}','type' => null,'type_website_id'=>1],
            ['title' => '{"id":"Digital Banking","en":"Digital Banking"}','type' => null, 'type_website_id'=>1],
            ['title' => '{"id":"Jasa Layanan","en":"Services"}','type' => 1,'type_website_id'=>1],
        ]);
        
        ProductType::insert([
            ['product_category_id' => 1,'title' => 'Produk Tabungan'],
            ['product_category_id' => 1,'title' => 'Produk Deposito'],
            ['product_category_id' => 1,'title' => 'Produk Giro'],

            ['product_category_id' => 2,'title' => 'Kredit Komersil'],
            ['product_category_id' => 2,'title' => 'Kredit Konsumtif'],
            ['product_category_id' => 2,'title' => 'Kredit Usaha Mikro'],
            
            ['product_category_id' => 3,'title' => 'Jasa'],
            ['product_category_id' => 3,'title' => 'Layanan Digital'],
            ['product_category_id' => 3,'title' => 'e-Banking'],
            
            ['product_category_id' => 4,'title' => 'Safe Deposit Box'],
            ['product_category_id' => 4,'title' => 'Surat Keterangan Bank & Lainnya'],
            ['product_category_id' => 4,'title' => 'Surat Dukungan Bank'],
        ]);
        
        Product::insert([
            ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 1,'title' => 'Tabungan SIMPEDA'],
            ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 1,'title' => 'Tabungan BANUA'],
            ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 1,'title' => 'Tabungan BANUA BUNGAS'],
            ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 1,'title' => 'Tabungan BANUA RENCANA'],
            ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 1,'title' => 'Tabungan SIMPEL'],
            ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 1,'title' => 'TabunganKU'],

            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 2,'title' => 'Deposito Berjangka'],
            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 2,'title' => 'Deposito Banua'],
            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 2,'title' => 'Deposito Mingguan'],
            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 2,'title' => 'Deposito on call'],
            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 2,'title' => 'Deposito Banua Plus'],
            
            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 3,'title' => 'Giro Perorangan'],
            // ['type_website_id' => 1,'product_category_id' => 1,'product_type_id' => 3,'title' => 'Giro Non Perorangan'],
        ]);
        
        CreditCalculator::insert([
            ['type' => "KBR", 'month_year' => "year", 'periods' => '[{"loan_term":3,"interest":0.5},{"loan_term":6,"interest":0.8},{"loan_term":12,"interest":1},{"loan_term":24,"interest":1}]'],            
            ['type' => "KUR",'month_year' => "month", 'periods' => '[{"loan_term":3,"interest":0.5},{"loan_term":6,"interest":0.8},{"loan_term":12,"interest":1},{"loan_term":24,"interest":2},{"loan_term":36,"interest":2}]'],            
        ]);
        
        InformationCategory::insert([
            ['name' => '{"en":"Procurement and services","id":"Pengadaan Barang dan Jasa"}'],
            ['name' => '{"en":"HR","id":"SDM"}'],
            ['name' => '{"en":"Collateral Auction","id":"Lelang Agunan"}'],
            ['name' => '{"en":"Announcement"id":"Pengumuman"}']
        ]);
       
        ProfileCategory::insert([
            ['type_website_id' => 1,'title' => 'Sejarah Bank Kalsel'],
            ['type_website_id' => 1,'title' => 'Visi Misi Bank Kalsel'],
            ['type_website_id' => 1,'title' => 'Manajemen'],
            ['type_website_id' => 1,'title' => 'Struktur Organisasi']
        ]);
        
        AboutUs::insert([
            ['profile_category_id' => 3,'title' => '{"en":"Dewan Comissioner","id":"Dewan Komisaris"}'],
            ['profile_category_id' => 1,'title' => '{"en":"Pendirian Perusahaan","id":"Lorem ipsum dolor sit amet"}'],            
        ]);
        
        AboutUsDetail::insert([            
            ['aboutus_id' => 1,'name' => 'Dr. Hatmansyah, S.Ag, ME.','title' => '{"en":"Independent President Commissioner","id":"Komisaris Utama Independen"}','desc' => '{"en":"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum<\/p>","id":"<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit<\/p>"}'],
            ['aboutus_id' => 1,'name' => 'Syahrituah Siregar, SE, MA','title' => '{"en":"Independent President Commissioner","id":"Komisaris Utama Independen"}','desc' => '{"en":"<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit<\/p>","id":"<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur<\/p>"}'],
        ]);
        
        CorporateGovernanceCategory::insert([            
            ['type_website_id' => 1,'title' => '{"en":"Monthly Report","id":"Laporan Bulanan"}','short_description' => '{"en":"Click on the box on the right to download the file.","id":"Klik pada kotak di samping kanan untuk mengunduh file"}'],
            ['type_website_id' => 1,'title' => '{"en":"Governance Implementation Report","id":"Laporan Pelaksanaan Tata Kelola"}','short_description' => '{"en":"Click on the box on the right to download the file.","id":"Klik pada kotak di samping kanan untuk mengunduh file"}'],
        ]);
        
        CorporateGovernance::insert([            
            ['corporate_governance_category_id' => 1,'category' => null,'month' => 'Feb 2025'],
            ['corporate_governance_category_id' => 2,'category' => '1','month' => 'Feb 2025'],
        ]);
        
        LocationCategory::insert(
            [
                ['type_website_id' => 1,'title' => '{"id":"Kantor Cabang","en":"Branch office"}'],
                ['type_website_id' => 1,'title' => '{"id":"Kantor Cabang Pembantu","en":"Sub-Branch Office"}'],  
                ['type_website_id' => 1,'title' => '{"id":"Kantor Kas","en":"Cash Office"}'],  
                ['type_website_id' => 1,'title' => '{"id":"Kas Mobil","en":"Car Cash"}'],  
                ['type_website_id' => 1,'title' => '{"id":"ATM","en":"ATM"}'],  
                ['type_website_id' => 1,'title' => '{"id":"EDC","en":"EDC"}'],            
            ]);
        
        // Insert default data
        TypeProfileCategory::insert(
            [
                ['id' => 1, 'title' => 'SBDK', 'type_website_id' => 1],
                ['id' => 2, 'title' => 'Laporan Keuangan Bulanan', 'type_website_id' => 1],
            ]);
        // User::factory()->create([
        //     'name' => 'Root',
        //     'email' => 'root@email.com',
        //     'password' => Hash::make('12345678')
        // ]);

        $this->call([
            CountrySeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
