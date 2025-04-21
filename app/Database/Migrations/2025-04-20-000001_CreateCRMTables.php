<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCRMTablesSafe extends Migration
{
    public function up()
    {
        // Users table
        if (!$this->db->tableExists('users')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'unique' => true,
                ],
                'password' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ],
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['admin', 'user'],
                    'default' => 'user',
                ],
                'active' => [
                    'type' => 'BOOLEAN',
                    'default' => true,
                ],
                'created_at datetime default current_timestamp',
                'updated_at datetime default current_timestamp on update current_timestamp',
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('users');
        }

        // Pipelines table
        if (!$this->db->tableExists('pipelines')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
                'created_by' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'created_at datetime default current_timestamp',
                'updated_at datetime default current_timestamp on update current_timestamp',
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('created_by', 'users', 'id', '', '');
            $this->forge->createTable('pipelines');
        }

        // Pipeline stages table
        if (!$this->db->tableExists('pipeline_stages')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'pipeline_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'order_position' => [
                    'type' => 'INT',
                    'constraint' => 11,
                ],
                'created_at datetime default current_timestamp',
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('pipeline_id', 'pipelines', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('pipeline_stages');
        }

        // Leads table
        if (!$this->db->tableExists('leads')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                ],
                'phone' => [
                    'type' => 'VARCHAR',
                    'constraint' => '20',
                    'null' => true,
                ],
                'company' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                ],
                'value' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'null' => true,
                ],
                'pipeline_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'stage_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'notes' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at datetime default current_timestamp',
                'updated_at datetime default current_timestamp on update current_timestamp',
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('pipeline_id', 'pipelines', 'id', '', '');
            $this->forge->addForeignKey('stage_id', 'pipeline_stages', 'id', '', '');
            $this->forge->addForeignKey('user_id', 'users', 'id', '', '');
            $this->forge->createTable('leads');
        }

        // Lead activities table
        if (!$this->db->tableExists('lead_activities')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'lead_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'activity_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at datetime default current_timestamp',
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('lead_id', 'leads', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('user_id', 'users', 'id', '', '');
            $this->forge->createTable('lead_activities');
        }
    }

    public function down()
    {
        $this->forge->dropTable('lead_activities', true);
        $this->forge->dropTable('leads', true);
        $this->forge->dropTable('pipeline_stages', true);
        $this->forge->dropTable('pipelines', true);
        $this->forge->dropTable('users', true);
    }
}