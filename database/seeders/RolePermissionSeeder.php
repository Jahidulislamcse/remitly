<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $permissions = [
           
            ['name' => 'user all view' ],
            ['name' => 'user own view' ],
            ['name' => 'user view' ],
            ['name' => 'user create' ],
            ['name' => 'user edit' ],
            ['name' => 'user status change'],
            ['name' => 'user delete' ],
            ['name' => 'user role view' ],
            ['name' => 'user role create' ],
            ['name' => 'user role edit' ],
            ['name' => 'user role delete' ],

            ['name' => 'settings all view' ],
            ['name' => 'settings own view' ],
            ['name' => 'settings view' ],
            ['name' => 'settings create' ],
            ['name' => 'settings edit' ],
            ['name' => 'settings status change' ],
            ['name' => 'settings delete'  ],

            ['name' => 'page all view' ],
            ['name' => 'page own view' ],
            ['name' => 'page view' ],
            ['name' => 'page create' ],
            ['name' => 'page edit' ],
            ['name' => 'page status change' ],
            ['name' => 'page delete'  ],

            ['name' => 'cms view' ],
            ['name' => 'cms create' ],
            ['name' => 'cms edit' ],
            ['name' => 'cms status change' ],
            ['name' => 'cms delete'  ],

            ['name' => 'blog view' ],
            ['name' => 'blog create' ],
            ['name' => 'blog edit' ],
            ['name' => 'blog status change' ],
            ['name' => 'blog delete'  ],

            ['name' => 'product view' ],
            ['name' => 'product create' ],
            ['name' => 'product edit' ],
            ['name' => 'product status change' ],
            ['name' => 'product delete'  ],

            ['name' => 'promotional view' ],
            ['name' => 'promotional create' ],
            ['name' => 'promotional edit' ],
            ['name' => 'promotional status change' ],
            ['name' => 'promotional delete'  ],

            ['name' => 'support view' ],
            ['name' => 'support create' ],
            ['name' => 'support edit' ],
            ['name' => 'support status change' ],
            ['name' => 'support delete'  ],

            ['name' => 'category view' ],
            ['name' => 'category create' ],
            ['name' => 'category edit' ],
            ['name' => 'category status change' ],
            ['name' => 'category delete'  ],

            ['name' => 'order view'],
            ['name' => 'order create'],
            ['name' => 'order edit'],
            ['name' => 'order status change'],
            ['name' => 'order delete'],

            ['name' => 'dashboard view'],
          
        ] ;


        $permissions = [
           
           

           

            ['name' => 'support view' ],
            ['name' => 'support create' ],
            ['name' => 'support edit' ],
            ['name' => 'support status change' ],
            ['name' => 'support delete'  ],

           
            ['name' => 'order view'],
            ['name' => 'order create'],
            ['name' => 'order edit'],
            ['name' => 'order status change'],
            ['name' => 'order delete'],

            ['name' => 'dashboard view'],
          
        ] ;

        $admin = Role::create(['name'=>'super admin']);
        $customer = Role::create(['name'=>'customer']);

        foreach($permissions as $item){

            $permission = Permission::create($item);
            $permission->assignRole($admin);

        }

        $user = User::where('is_super',1)->first() ;
        $user->assignRole('super admin') ;


    }
}
