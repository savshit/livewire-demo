<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg my-10  p-6">
        @livewire('create-invoice')
        <div class="flex justify-between items-center w-100 flex-wrap">
            <h2 class="text-base md:text-[28px] font-extrabold text-black">
                Invoices
            </h2>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="relative">
                    <button wire:click="toggleFilter"
                        class="px-3 py-1 text-sm text-[#6d6d6d] font-semibold border rounded shadow-md flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M19 6H5c-1.1 0-1.4.6-.6 1.4l4.2 4.2c.8.8 1.4 2.3 1.4 3.4v5l4-2v-3.5c0-.8.6-2.1 1.4-2.9l4.2-4.2c.8-.8.5-1.4-.6-1.4" />
                        </svg>
                        Filter
                    </button>

                    @if ($showFilter)
                        <div class="absolute z-10 md:w-80 w-64 bg-white shadow-lg rounded-lg p-4 mt-2 border">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm font-semibold text-gray-700">Filter Invoices</h3>
                                <button wire:click="toggleFilter" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-3">
                                <input wire:model.live="filterAmount" type="number" placeholder="Filter by Amount"
                                    class="border rounded-lg text-base text-black border-[#d9d9d9] w-full">

                                <input wire:model.live="filterInvoiceNumber" type="text" placeholder="Invoice Number"
                                    class="border rounded-lg text-base text-black border-[#d9d9d9] w-full">

                                <input wire:model.live="filterCustomerEmail" type="email" placeholder="Customer Email"
                                    class="border rounded-lg text-base text-black border-[#d9d9d9] w-full">

                                <div class="flex gap-2 sm:flex-row flex-col">
                                    <div class="sm:w-1/2 w-full">
                                        <label class="text-base">From Date</label>
                                        <input wire:model.live="filterDateFrom" type="date"
                                            class="border rounded-lg text-base text-black border-[#d9d9d9] w-full">
                                    </div>
                                    <div class="sm:w-1/2 w-full">
                                        <label class="text-base">To Date</label>
                                        <input wire:model.live="filterDateTo" type="date"
                                            class="border rounded-lg text-base text-black border-[#d9d9d9] w-full">
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <button wire:click="resetFilter" class="text-sm text-red-600">
                                        Clear Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <button wire:click="export"
                    class="px-3 py-1 text-sm text-[#6d6d6d] font-semibold border rounded shadow-md flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m11.93 5l2.83 2.83L5 17.59L6.42 19l9.76-9.75L19 12.07V5z" />
                    </svg>
                    Export
                </button>

                {{-- Button to Open Create Invoice Modal --}}
                <button wire:click="$dispatch('open-create-invoice-modal')"
                    class="create-invoice px-3 py-1.5 text-sm text-white border rounded shadow-md bg-[#6875f5] flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                        <path fill="#ffffff" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6z" />
                    </svg>
                    Create Invoice
                </button>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="w-full mb-4">
            <div class="border-b-2 flex gap-10 overflow-auto">
                @php $tabs = ['All Invoices', 'Draft', 'Outstanding', 'Paid'] @endphp
                @foreach ($tabs as $tab)
                    <button wire:click="setTab('{{ $tab }}')"
                        class="p-0 py-2 text-base font-semibold whitespace-nowrap {{ $activeTab === $tab ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 ' }}">
                        {{ $tab }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Invoice Table --}}

        @if ($noRecordsFound)
            <div class="text-center py-6 text-gray-500">
                <p class="text-xl">No records found matching your filters.</p>
            </div>
        @else
            <div class="w-100 overflow-x-auto ct-invoices-table-row min-h-[335px]">
                <table class="w-full">
                    <thead class=" text-left">
                        <tr class="border-b">
                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap ">Amount</th>
                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap"></th>
                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap"></th>
                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap">Invoice Number</th>
                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap">Customer Email</th>

                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap">Created Date</th>
                            <th class="p-2 text-sm font-semibold uppercase whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 text-base font-semibold text-gray-600 whitespace-nowrap">
                                    ${{ number_format($invoice->amount, 2) }}
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <span class="text-base font-semibold text-gray-600 d-block">
                                            USD
                                        </span>
                                        <span class="d-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 16 16">
                                                <path fill="none" stroke="#797979" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4.75 10.75h-3m12.5-2c0 3-2.798 5.5-6.25 5.5c-3.75 0-6.25-3.5-6.25-3.5v3.5m9.5-9h3m-12.5 2c0-3 2.798-5.5 6.25-5.5c3.75 0 6.25 3.5 6.25 3.5v-3.5" />
                                            </svg>
                                        </span>
                                    </div>
                                </td>
                                <td class="p-2 text-base font-semibold text-gray-600 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 rounded-[3px] text-xs font-semibold 
                                {{ $invoice->status === 'Draft' ? 'bg-gray-200 text-gray-800' : '' }}
                                {{ $invoice->status === 'Outstanding' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $invoice->status === 'Paid' ? 'bg-green-200 text-green-800' : '' }} ">
                                        {{ $invoice->status }}
                                    </span>
                                </td>
                                <td class="p-2 text-base font-semibold text-gray-600 whitespace-nowrap">
                                    {{ $invoice->invoice_number }}</td>
                                <td class="p-2 text-base font-semibold text-gray-600 whitespace-nowrap">
                                    {{ $invoice->customer_email }}</td>

                                <td class="p-2 text-base font-semibold text-gray-600 whitespace-nowrap">
                                    {{ $invoice->created_at->format('M d, Y') }}</td>

                                <td class="p-2 text-base font-semibold text-gray-600 relative whitespace-nowrap"
                                    x-data="{ isOpen: false }" @close-dropdown.window="isOpen = false">
                                    <button @click="isOpen = !isOpen"
                                        class="text-gray-500 hover:text-gray-700 dropdown-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 16 16">
                                            <g fill="none" stroke="#797979" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.5">
                                                <circle cx="2.5" cy="8" r=".75" />
                                                <circle cx="8" cy="8" r=".75" />
                                                <circle cx="13.5" cy="8" r=".75" />
                                            </g>
                                        </svg>
                                    </button>

                                    <div x-show="isOpen" @click.outside="isOpen = false"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="absolute right-0 mt-2 w-48 bg-white shadow-md rounded-md z-[1] border top ct-dropdown-l">
                                        <h2 class="block text-sm uppercase text-gray-500 mb-2 px-4 mt-3">
                                            Actions
                                        </h2>
                                        <a href="#" wire:click.prevent="downloadInvoice({{ $invoice->id }})"
                                            class="block px-4 py-0.5 text-[#6875f5] opacity-80 hover:bg-gray-100 text-[15px]">
                                            Download
                                        </a>
                                        <a href="#" wire:click.prevent="duplicateInvoice({{ $invoice->id }})"
                                            @click="isOpen = false"
                                            class="block px-4 py-0.5 text-[#6875f5] opacity-80 hover:bg-gray-100 text-[15px]">
                                            Duplicate
                                        </a>
                                        <a href="#" wire:click.prevent="confirmDelete({{ $invoice->id }})"
                                            class="block px-4 py-0.5 text-red-600 opacity-80 hover:bg-gray-100 text-[15px]">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 px-4 py-3">
                {{ $invoices->links() }}
            </div>
        @endif

    </div>

    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Warning icon -->
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Invoice
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this invoice?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteInvoice" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button wire:click="cancelDelete" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.querySelector('.create-invoice').addEventListener('click', () => {
            Livewire.emit('openCreateInvoiceModal');
        });
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            }));
        });
    </script>
@endpush
