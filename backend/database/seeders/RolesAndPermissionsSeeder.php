<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arr = [
            'AboutUs',
            'AboutUsDetail',
            'Award',
            'ContactUs',
            'Conventional',
            'CorporateGovernance',
            'CorporateGovernanceCategory',
            'CreditCalculator',
            'Csr',
            'Education',
            'ExchangeRate',
            'HeroBanner',
            'InformationCategory',
            'InformationFinance',
            'InformationFinanceCategory',
            'LocationCategory',
            'LocationDetail',
            'News',
            'Policy',
            'PolicyDetail',
            'Product',
            'ProductCategory',
            'ProductDetail',
            'ProductType',
            'Profile',
            'ProfileCategory',
            'Promo',            
            'Sbdk',
            'Service',
            'ServiceCategory',
            'ServiceDetail',
            'Sustainable',
            'SustainableCategory',
            'Syariah',
            'TypeProfileCategory',
            'TypeWebsite',
            'UnitTeam',
            'User'
        ];        

        $collection = collect($arr);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['group' => $item, 'name' => 'viewAny' . $item]);
            Permission::create(['group' => $item, 'name' => 'view' . $item]);
            Permission::create(['group' => $item, 'name' => 'update' . $item]);
            Permission::create(['group' => $item, 'name' => 'create' . $item]);
            Permission::create(['group' => $item, 'name' => 'delete' . $item]);
            Permission::create(['group' => $item, 'name' => 'destroy' . $item]);
        });

        // Create a Super-Admin Role and assign all Permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
                
        
        $toRemove = ['TypeWebsite','Role','Permission'];
        $arr = array_values(array_diff($arr, $toRemove));
        $role = Role::create(['name' => 'supervisor']);
        $role->givePermissionTo(Permission::whereIn('group', $arr)->get());

        $toRemove = ['Profile','ProfileCategory','Conventional','Syariah','AboutUs','AboutUsDetail','Award','CorporateGovernance','CorporateGovernanceCategory','ContactUs','TypeProfileCategory','UnitTeam','InformationCategory','InformationFinance','InformationFinanceCategory','LocationCategory','LocationDetail','Policy','PolicyDetail'];
        $arr = array_values(array_diff($arr, $toRemove));
        $role = Role::create(['name' => 'operator']);
        $role->givePermissionTo(Permission::whereIn('group', $arr)->get());

        ##User
        User::create([
            'name' => 'Root',
            'email' => 'root@email.com',
            //'type_website_id' => 11,
            'password' => Hash::make('12345678') 
        ]);
        
        User::create([
            'name' => 'Operator Bank Kalsel',
            'email' => 'operator@email.com',
            'type_website_id' => 1,
            'password' => Hash::make('12345678')  
        ]);
        
        User::create([
            'name' => 'Operator Syariah',
            'email' => 'operator_syariah@email.com',
            'type_website_id' => 2,
            'password' => Hash::make('12345678')  
        ]);
        
        User::create([
            'name' => 'Supervisor Bank Kalsel',
            'email' => 'supervisor@email.com',
            'type_website_id' => 1,
            'password' => Hash::make('12345678')  
        ]);
        
        User::create([
            'name' => 'Supervisor Syariah',
            'email' => 'supervisor_syariah@email.com',
            'type_website_id' => 2,
            'password' => Hash::make('12345678')  
        ]);

        //Give User Super-Admin Role
        $user = \App\Models\User::whereEmail('root@email.com')->first(); // Change this to your email.
        $user->assignRole('super-admin');
        
        $user = \App\Models\User::whereEmail('operator_syariah@email.com')->first(); // Change this to your email.
        $user->assignRole('operator');
        
        $user = \App\Models\User::whereEmail('operator@email.com')->first(); // Change this to your email.
        $user->assignRole('operator');
        
        $user = \App\Models\User::whereEmail('supervisor@email.com')->first(); // Change this to your email.
        $user->assignRole('supervisor');
        
        $user = \App\Models\User::whereEmail('supervisor_syariah@email.com')->first(); // Change this to your email.
        $user->assignRole('supervisor');
    }
}
