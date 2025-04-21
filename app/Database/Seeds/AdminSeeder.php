<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Verifica se já existe um admin
        $builder = $db->table('users');
        $existingAdmin = $builder->where('email', 'admin@crm.com')->get()->getRow();
        
        if (!$existingAdmin) {
            $data = [
                'name'     => 'Admin',
                'email'    => 'admin@crm.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'active'   => 1,
            ];

            $builder->insert($data);
            echo "Admin user created successfully.\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}