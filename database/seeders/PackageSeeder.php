<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing packages
        Package::truncate();
        
        // Monthly Packages
        Package::create([
            'name' => 'Starter',
            'package_type' => 'monthly',
            'cost' => 10.00,
            'status' => 1,
            'is_popular' => 0,
            'discount' => 10.00,
            'trial_days' => 7,
            'user_limit' => '5',
            'invoice_limit' => '100',
            'quotation_limit' => '100',
            'recurring_invoice' => 0,
            'customer_limit' => '50',
            'business_limit' => '1',
            'invoice_builder' => 0,
            'online_invoice_payment' => 0,
            'payroll_module' => 0,
            'others' => 'Basic document management features'
        ]);
        
        Package::create([
            'name' => 'Standard',
            'package_type' => 'monthly',
            'cost' => 20.00,
            'status' => 1,
            'is_popular' => 1,
            'discount' => 10.00,
            'trial_days' => 14,
            'user_limit' => '15',
            'invoice_limit' => '500',
            'quotation_limit' => '500',
            'recurring_invoice' => 1,
            'customer_limit' => '200',
            'business_limit' => '3',
            'invoice_builder' => 1,
            'online_invoice_payment' => 1,
            'payroll_module' => 0,
            'others' => 'Advanced features with recurring invoices and online payments'
        ]);
        
        Package::create([
            'name' => 'Professional',
            'package_type' => 'monthly',
            'cost' => 30.00,
            'status' => 1,
            'is_popular' => 0,
            'discount' => 5.00,
            'trial_days' => 30,
            'user_limit' => '-1',
            'invoice_limit' => '-1',
            'quotation_limit' => '-1',
            'recurring_invoice' => 1,
            'customer_limit' => '-1',
            'business_limit' => '-1',
            'invoice_builder' => 1,
            'online_invoice_payment' => 1,
            'payroll_module' => 1,
            'others' => 'Unlimited everything with full HR & Payroll module'
        ]);
        
        // Yearly Packages
        Package::create([
            'name' => 'Starter',
            'package_type' => 'yearly',
            'cost' => 100.00,
            'status' => 1,
            'is_popular' => 0,
            'discount' => 0.00,
            'trial_days' => 7,
            'user_limit' => '5',
            'invoice_limit' => '100',
            'quotation_limit' => '100',
            'recurring_invoice' => 0,
            'customer_limit' => '50',
            'business_limit' => '1',
            'invoice_builder' => 0,
            'online_invoice_payment' => 0,
            'payroll_module' => 0,
            'others' => 'Basic document management features - Yearly plan'
        ]);
        
        Package::create([
            'name' => 'Standard',
            'package_type' => 'yearly',
            'cost' => 210.00,
            'status' => 1,
            'is_popular' => 1,
            'discount' => 5.00,
            'trial_days' => 14,
            'user_limit' => '15',
            'invoice_limit' => '500',
            'quotation_limit' => '500',
            'recurring_invoice' => 1,
            'customer_limit' => '200',
            'business_limit' => '3',
            'invoice_builder' => 1,
            'online_invoice_payment' => 1,
            'payroll_module' => 0,
            'others' => 'Advanced features with recurring invoices and online payments - Yearly plan'
        ]);
        
        Package::create([
            'name' => 'Professional',
            'package_type' => 'yearly',
            'cost' => 300.00,
            'status' => 1,
            'is_popular' => 0,
            'discount' => 0.00,
            'trial_days' => 30,
            'user_limit' => '-1',
            'invoice_limit' => '-1',
            'quotation_limit' => '-1',
            'recurring_invoice' => 1,
            'customer_limit' => '-1',
            'business_limit' => '-1',
            'invoice_builder' => 1,
            'online_invoice_payment' => 1,
            'payroll_module' => 1,
            'others' => 'Unlimited everything with full HR & Payroll module - Yearly plan'
        ]);
        
        // Lifetime Package
        Package::create([
            'name' => 'Lifetime Gold',
            'package_type' => 'lifetime',
            'cost' => 499.00,
            'status' => 1,
            'is_popular' => 0,
            'discount' => 0.00,
            'trial_days' => 0,
            'user_limit' => '-1',
            'invoice_limit' => '-1',
            'quotation_limit' => '-1',
            'recurring_invoice' => 1,
            'customer_limit' => '-1',
            'business_limit' => '-1',
            'invoice_builder' => 1,
            'online_invoice_payment' => 1,
            'payroll_module' => 1,
            'others' => 'Lifetime access to all features with unlimited everything'
        ]);
    }
}
