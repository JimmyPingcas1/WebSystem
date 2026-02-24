<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Store original tenant connection config
        $originalTenantDb = config('database.connections.tenant.database');

        // 1️⃣ Clear old data
        try {
            DB::table('tenant_domains')->delete();
            DB::table('tenants')->delete();
        } catch (\Exception $e) {
            $this->command->error("Error clearing tables: " . $e->getMessage());
        }

        // 2️⃣ Seed tenants with their users
        for ($i = 1; $i <= 20; $i++) {
            $tenantName = 'Tenant ' . $i;
            $slug = 'tenant_' . $i;
            $dbName = 'tenant_' . Str::random(12);
            $email = 'tenant' . $i . '@example.com';
            $password = 'password';
            $hashedPassword = Hash::make($password);

            $this->command->info("\n🔄 Processing Tenant $i ($dbName)...");

            // Create tenant database
            try {
                DB::statement('CREATE DATABASE IF NOT EXISTS `' . $dbName . '`');
                $this->command->info("  ✅ Created database: $dbName");
            } catch (\Exception $e) {
                $this->command->error("  ❌ Failed to create database: " . $e->getMessage());
                continue;
            }

            // Insert tenant in root database
            try {
                $tenantId = DB::table('tenants')->insertGetId([
                    'tenant_name' => $tenantName,
                    'slug' => $slug,
                    'database_name' => $dbName,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'metadata' => json_encode([]),
                ]);
                $this->command->info("  ✅ Inserted tenant: $slug");
            } catch (\Exception $e) {
                $this->command->error("  ❌ Failed to insert tenant: " . $e->getMessage());
                continue;
            }

            // Insert domain
            try {
                $appDomain = env('APP_DOMAIN', 'localhost');
                $domain = $slug . '.' . $appDomain;
                DB::table('tenant_domains')->insert([
                    'tenant_id' => $tenantId,
                    'domain' => $domain,
                    'is_primary' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $this->command->info("  ✅ Inserted domain: $domain");
            } catch (\Exception $e) {
                $this->command->error("  ❌ Failed to insert domain: " . $e->getMessage());
            }

            // Run migrations on tenant database
            try {
                config(['database.connections.tenant.database' => $dbName]);
                DB::purge('tenant');
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/tenant',
                    '--database' => 'tenant',
                    '--force' => true,
                ]);
                $this->command->info("  ✅ Ran migrations");
            } catch (\Exception $e) {
                $this->command->error("  ❌ Migration failed: " . $e->getMessage());
                continue;
            }

            // Insert user in tenant database
            try {
                // Ensure connection is still pointing to the tenant DB
                config(['database.connections.tenant.database' => $dbName]);
                DB::purge('tenant');

                // Verify table exists before inserting
                if (!Schema::connection('tenant')->hasTable('tenant_users')) {
                    $this->command->error("  ❌ tenant_users table does not exist in $dbName");
                    continue;
                }

                // Get table columns to verify structure
                $columns = Schema::connection('tenant')->getColumnListing('tenant_users');
                $this->command->info("  ℹ️  Table columns: " . implode(', ', $columns));

                // Insert user with all required fields
                $insertData = [
                    'name' => $tenantName . ' Admin',
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => 'admin',
                ];

                // Add optional fields if they exist
                if (in_array('email_verified_at', $columns)) {
                    $insertData['email_verified_at'] = Carbon::now();
                }
                if (in_array('created_at', $columns)) {
                    $insertData['created_at'] = Carbon::now();
                }
                if (in_array('updated_at', $columns)) {
                    $insertData['updated_at'] = Carbon::now();
                }

                $result = DB::connection('tenant')->table('tenant_users')->insert([$insertData]);
                
                if ($result) {
                    $this->command->info("  ✅ Inserted user: $email");
                    
                    // Verify insertion
                    $verify = DB::connection('tenant')->table('tenant_users')->where('email', $email)->first();
                    if ($verify) {
                        $this->command->info("  ✅ Verified user exists in database");
                    } else {
                        $this->command->error("  ❌ User inserted but not found in verification");
                    }
                } else {
                    $this->command->error("  ❌ Failed to insert user (insert returned false)");
                }
            } catch (\Exception $e) {
                $this->command->error("  ❌ Failed to insert user: " . $e->getMessage());
                $this->command->error("     " . $e->getFile() . " on line " . $e->getLine());
            }
        }

        // Restore original tenant connection config
        config(['database.connections.tenant.database' => $originalTenantDb]);
        DB::purge('tenant');
        $this->command->info("\n✅ 20 tenants seeded with users and domains!");
    }
}


