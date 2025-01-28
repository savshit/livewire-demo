<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class InvoiceDashboard extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $activeTab = 'All Invoices';
    public $dropdownOpen = null;
    public $showDeleteModal = false;
    public $invoiceToDelete = null;
    public $newInvoice = [
        'amount' => null,
        'invoice_number' => null,
        'customer_email' => null,
        'status' => 'Draft',
    ];
    protected $paginationTheme = 'tailwind';
    protected $listeners = [
        'invoice-created' => '$refresh',
        'closeDropdown' => 'closeDropdown',
        'click.outside' => 'closeDropdown'
    ];

    // Filter properties
    public $filterAmount = null;
    public $filterInvoiceNumber = null;
    public $filterCustomerEmail = null;
    public $filterDateFrom = null;
    public $filterDateTo = null;

    // Toggle filter visibility
    public $showFilter = false;
    public $filterApplied = false;
    public $perPage = 10;

    /**
     * Author Name: Payal Appgenix
     * Function Name: mount()
     * Use: Reset pagination when component mounts
     * @param empty
     * @return empty
     */
    public function mount()
    {
        $this->resetPage();
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: toggleFilter()
     * Use: Toggle filter visibility method
     * @param empty
     * @return empty
     */
    public function toggleFilter()
    {
        $this->showFilter = !$this->showFilter;
        if (!$this->showFilter) {
            $this->resetFilter();
        }
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: resetFilter()
     * Use: Reset filter method
     * @param empty
     * @return empty
     */
    public function resetFilter()
    {
        $this->filterAmount = null;
        $this->filterInvoiceNumber = null;
        $this->filterCustomerEmail = null;
        $this->filterDateFrom = null;
        $this->filterDateTo = null;
        $this->filterApplied = false;
        $this->resetPage(); // Reset to first page when filters are reset
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: getInvoicesProperty()
     * Use: get invoice filter all data tab wise
     * @param empty
     * @return array
     */
    public function getInvoicesProperty()
    {
        $query = Invoice::query();

        // Filter by status tab
        if ($this->activeTab !== 'All Invoices') {
            $query->where('status', $this->activeTab);
        }

        // Apply filters
        $this->filterApplied = false;

        if ($this->filterAmount) {
            $query->where('amount', $this->filterAmount);
            $this->filterApplied = true;
        }

        if ($this->filterInvoiceNumber) {
            $query->where('invoice_number', 'like', '%' . $this->filterInvoiceNumber . '%');
            $this->filterApplied = true;
        }

        if ($this->filterCustomerEmail) {
            $query->where('customer_email', 'like', '%' . $this->filterCustomerEmail . '%');
            $this->filterApplied = true;
        }

        if ($this->filterDateFrom) {
            $query->whereDate('created_at', '>=', $this->filterDateFrom);
            $this->filterApplied = true;
        }

        if ($this->filterDateTo) {
            $query->whereDate('created_at', '<=', $this->filterDateTo);
            $this->filterApplied = true;
        }

        return $query->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: setTab()
     * Use: Set active tab and reset pagination
     * @param tab
     * @return string
     */
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); // Reset to first page when changing tabs
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: closeDropdown()
     * Use: close action dropdown
     * @param empty
     * @return empty
     */
    public function closeDropdown()
    {
        $this->dropdownOpen = null;
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: toggleDropdown()
     * Use: toggle action dropdown
     * @param invoiceId
     * @return string
     */
    public function toggleDropdown($invoiceId)
    {
        if ($this->dropdownOpen === $invoiceId) {
            $this->dropdownOpen = null;
        } else {
            $this->dropdownOpen = $invoiceId;
        }
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: downloadInvoice()
     * Use: Download invoice
     * @param invoice
     * @return json
     */
    public function downloadInvoice(Invoice $invoice)
    {
        $this->closeDropdown(); // Close dropdown after action
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $invoice])->output();
        return response()->streamDownload(
            fn() => print($pdf),
            $invoice->invoice_number . '.pdf'
        );
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: duplicateInvoice()
     * Use: Duplicate invoice
     * @param invoice
     * @return empty
     */
    public function duplicateInvoice(Invoice $invoice)
    {
        $this->closeDropdown(); // Close dropdown after action
        $newInvoice = $invoice->replicate();
        $newInvoice->invoice_number = 'Copy-' . rand(1000, 9999) . '-' . $invoice->invoice_number;
        $newInvoice->save();

        $this->dispatch('close-dropdown');
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: confirmDelete()
     * Use: Show delete confirmation modal
     * @param invoice
     * @return empty
     */
    public function confirmDelete($invoiceId)
    {
        $this->invoiceToDelete = $invoiceId;
        $this->showDeleteModal = true;
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: cancelDelete()
     * Use: Cancel delete operation
     * @param empty
     * @return empty
     */
    public function cancelDelete()
    {
        $this->invoiceToDelete = null;
        $this->showDeleteModal = false;
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: deleteInvoice()
     * Use: Delete invoice after confirmation
     * @param empty
     * @return empty
     */
    public function deleteInvoice()
    {
        if ($this->invoiceToDelete) {
            $invoice = Invoice::find($this->invoiceToDelete);
            if ($invoice) {
                $invoice->delete();
            }
            $this->showDeleteModal = false;
            $this->invoiceToDelete = null;
            $this->closeDropdown();
        }
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: createInvoice()
     * Use: create invoice manage
     * @param empty
     * @return empty
     */
    public function createInvoice()
    {
        $validatedData = $this->validate([
            'newInvoice.amount' => 'required|numeric',
            'newInvoice.invoice_number' => 'required|unique:invoices,invoice_number',
            'newInvoice.customer_email' => 'required|email',
            'newInvoice.status' => 'required|in:Draft,Outstanding,Paid',
        ]);

        Invoice::create($validatedData['newInvoice']);
        $this->newInvoice = [
            'amount' => null,
            'invoice_number' => null,
            'customer_email' => null,
            'status' => 'Draft',
        ];
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: export()
     * Use: export invoice data
     * @param empty
     * @return json
     */
    public function export()
    {
        $invoices = $this->invoices;
        $pdf = Pdf::loadView('invoices.export', compact('invoices'))->output();
        return response()->streamDownload(
            fn() => print($pdf),
            'invoices.pdf'
        );
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: openCreateInvoiceModal()
     * Use: invoice create modal open
     * @param empty
     * @return string
     */
    public function openCreateInvoiceModal()
    {
        $this->dispatch('open-create-invoice-modal');
    }

    /**
     * Author Name: Payal Appgenix
     * Function Name: render()
     * Use: invoice file render
     * @param invoices
     * @return array
     */
    public function render()
    {
        return view('livewire.invoice-dashboard', [
            'invoices' => $this->invoices,
            'noRecordsFound' => $this->invoices->isEmpty(),
        ]);
    }
}
