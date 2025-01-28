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
            'amount' => 'required|numeric|min:0',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'customer_email' => 'required|email',
            'status' => 'required|in:Draft,Outstanding,Paid'
        ], [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Amount must be positive',
            'invoice_number.required' => 'Invoice number is required',
            'invoice_number.unique' => 'Invoice number must be unique',
            'customer_email.required' => 'Customer email is required',
            'customer_email.email' => 'Invalid email format',
            'status.required' => 'Status is required'
        ]);

        $invoice = Invoice::create([
            'amount' => $this->amount,
            'invoice_number' => $this->invoice_number,
            'customer_email' => $this->customer_email,
            'status' => $this->status,
        ]);

        // Emit event to refresh invoices list
        $this->dispatch('invoice-created');

        // Reset form
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
