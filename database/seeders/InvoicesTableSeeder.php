<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoicesTableSeeder extends Seeder
{
    // seeder data for invoice table
    public function run()
    {
        $invoices = [
            [
                'amount' => 199.99,
                'invoice_number' => 'INV-001',
                'customer_email' => 'john@example.com',
                'status' => Invoice::STATUS_DRAFT
            ],
            [
                'amount' => 299.50,
                'invoice_number' => 'INV-002',
                'customer_email' => 'jane@example.com',
                'status' => Invoice::STATUS_OUTSTANDING
            ],
            [
                'amount' => 149.75,
                'invoice_number' => 'INV-003',
                'customer_email' => 'bob@example.com',
                'status' => Invoice::STATUS_PAID
            ],
            [
                'amount' => 150.99,
                'invoice_number' => 'INV-004',
                'customer_email' => 'due@example.com',
                'status' => Invoice::STATUS_DRAFT
            ],
            [
                'amount' => 250.50,
                'invoice_number' => 'INV-005',
                'customer_email' => 'juhi@example.com',
                'status' => Invoice::STATUS_OUTSTANDING
            ],
        ];

        foreach ($invoices as $invoiceData) {
            Invoice::create($invoiceData);
        }
    }
}
