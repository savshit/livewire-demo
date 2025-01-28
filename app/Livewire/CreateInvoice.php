<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;

class CreateInvoice extends Component
{
    public $amount;
    public $invoice_number;
    public $customer_email;
    public $status = '';
    public $isModalOpen = false;

    protected $listeners = [
        'open-create-invoice-modal' => 'openModal'
    ];

    /**
     * Author Name: Payal Appgenix
     * Function Name: mount()
     * Use: invoice create modal mount
     * @param empty
     * @return string
     */
    public function mount()
    {
        $this->listeners['open-create-invoice-modal'] = 'openModal';
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: openModal()
     * Use: open modal for create invoice
     * @param empty
     * @return boolean
     */
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: closeModal()
     * Use: close modal for create invoice
     * @param empty
     * @return boolean
     */
    public function closeModal()
    {
        // Reset all form fields
        $this->reset(['amount', 'invoice_number', 'customer_email', 'status']);
        $this->resetValidation();
        $this->isModalOpen = false;
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: createInvoice()
     * Use: create invoice with validation
     * @param empty
     * @return array
     */
    public function createInvoice()
    {
        $validatedData = $this->validate([
            'amount' => [
                'required',
                'numeric',
                'decimal:0,2',      
                'min:0.01',       
                'max:99999999.99'  
            ],
            'invoice_number' => [
                'required',
                'string',
                'max:255',           
                'unique:invoices,invoice_number'
            ],
            'customer_email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255'         
            ],
            'status' => [
                'required',
                'in:Draft,Outstanding,Paid' 
            ]
        ], [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.decimal' => 'Amount can only have up to 2 decimal places',
            'amount.min' => 'Amount must be at least 0.01',
            'amount.max' => 'Amount cannot exceed 99,999,999.99',

            'invoice_number.required' => 'Invoice number is required',
            'invoice_number.max' => 'Invoice number cannot exceed 255 characters',
            'invoice_number.unique' => 'This invoice number is already in use',

            'customer_email.required' => 'Customer email is required',
            'customer_email.email' => 'Please enter a valid email address',
            'customer_email.max' => 'Email cannot exceed 255 characters',

            'status.required' => 'Status is required',
            'status.in' => 'Status must be Draft, Outstanding, or Paid',
        ]);

        $invoice = Invoice::create([
            'amount' => $this->amount,
            'invoice_number' => $this->invoice_number,
            'customer_email' => $this->customer_email,
            'status' => $this->status,
        ]);

        $this->dispatch('invoice-created');
        $this->reset(['amount', 'invoice_number', 'customer_email', 'status']);
        $this->isModalOpen = false;
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: render()
     * Use: create invoice file render
     * @param empty
     * @return empty
     */
    public function render()
    {
        return view('livewire.create-invoice');
    }
}
