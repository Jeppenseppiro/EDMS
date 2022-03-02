<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('document_categories')->insert([
            ['category_description' => 'Power\'s of Attorney', 'status' => 'Active', 'tag' => '2'],
            ['category_description' => 'Affidavits', 'status' => 'Active', 'tag' => '2'],
            ['category_description' => 'Corporate Forms', 'status' => 'Active', 'tag' => '2'],
            ['category_description' => 'Lease', 'status' => 'Active', 'tag' => '2'],
            ['category_description' => 'Pleadings', 'status' => 'Active', 'tag' => '2'],
            ['category_description' => 'Forms', 'status' => 'Active', 'tag' => '1'],
            ['category_description' => 'Procedures', 'status' => 'Active', 'tag' => '1'],
            ['category_description' => 'Work Instructions', 'status' => 'Active', 'tag' => '1'],
        ]);

        DB::table('companies')->insert([
            ['company_name' => 'Premium Megastructures Inc.', 'company_code' => 'PMI', 'document_controller' => ''],
            ['company_name' => 'MAC Builders', 'company_code' => 'MAC', 'document_controller' => ''],
            ['company_name' => 'Octagon Concrete Solutions', 'company_code' => 'OCS', 'document_controller' => ''],
            ['company_name' => 'Obanana', 'company_code' => 'OBN', 'document_controller' => ''],
            ['company_name' => 'Premium Capital Holdings Inc.', 'company_code' => 'PCHI', 'document_controller' => ''],
        ]);

        DB::table('departments')->insert([
            ['department' => 'Accounting', 'head' => '', 'status' => ''],
            ['department' => 'Asset Management', 'head' => '', 'status' => ''],
            ['department' => 'Purchasing', 'head' => '', 'status' => ''],
            ['department' => 'Risk Management Group', 'head' => '', 'status' => ''],
            ['department' => 'Systems Development', 'head' => '', 'status' => ''],
        ]);

        DB::table('request_types')->insert([
            ['description' => 'New'],
            ['description' => 'Revision'],
            ['description' => 'Discontinuance'],
            ['description' => 'Obsolete'],
        ]);

        DB::table('request_entry_statuses')->insert([
            ['status' => 'New Request', 'tag' => '1'],
            ['status' => 'Endorsed', 'tag' => '1'],
            ['status' => 'Further Review', '1' => '1'],
            ['status' => 'Approved', 'tag' => '1'],
            ['status' => 'Disapproved', 'tag' => '1'],
            ['status' => 'For Fine-tuning', 'tag' => '1'],
            ['status' => 'New Request', 'tag' => '2'],
            ['status' => 'Under Review', 'tag' => '2'],
            ['status' => 'For Printing', 'tag' => '2'],
            ['status' => 'For Pick-up', 'tag' => '2'],
            ['status' => 'For Notarization', 'tag' => '2'],
            ['status' => 'Submitted', 'tag' => '2'],
            ['status' => 'Forwarded to Holdings', 'tag' => '2'],
        ]);

        DB::table('tags')->insert([
            ['description' => 'ISO'],
            ['status' => 'Legal'],
            ['status' => 'Others'],
        ]);
    }
}
