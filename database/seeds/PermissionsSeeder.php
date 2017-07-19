<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$methods = [
			'c' => 'create',
			'r' => 'read',
			'u' => 'update',
			'd' => 'delete'
        ];

    	$permissions = [
    		'users' => 'c,r,u,d',
            'permissions' => 'r',
    	];

        // Loop through the permissions and their methods
        foreach ($permissions as $permission => $access) {

            // Explode the methods so (c,r,u,d) becomes [c,r,u,d]
            $keys = explode(',', $access);

            foreach ($methods as $short => $full) {
                if (in_array($short, $keys)) {

                	$name = ucwords($full) . ' ' . str_singular($permission); // Create user
                	$slug = str_slug($full . '-' . str_singular($permission)); // create-user
                	$description = 'Can ' . ucwords($full) . ' a ' . ucwords(str_singular($permission));

                    DB::table('permissions')->insert([
                        'name' => $name,
                        'slug' => $slug,
                        'description' => $description,
                    ]);
                }
            }
        }
    }
}
