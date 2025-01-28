<div>
    @if ($isModalOpen)
        <!-- Modal -->
        <div class="fixed inset-0 block justify-center items-center bg-gray-500 z-[999] bg-opacity-50 p-2 overflow-auto">

            <div class="bg-white rounded-lg max-w-[400px] mx-auto w-full">
                <div class="px-6 py-4 border-b flex items-center justify-between w-full gap-1">
                    <h3 class="text-xl font-medium">Create Invoice</h3>
                    <button wire:click="closeModal" class="bg-transparent border-0 p-0 m-0 opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 w-100">
                    <form wire:submit.prevent="createInvoice" class="space-y-4">
                        <div class="grid col-span-1 gap-4">
                            <div class="w-full flex flex-col gap-1">
                                <label for="amount" class="text-base">Amount <span class="text-sm text-red-700 -mt-1">*</span></label>
                                <input type="number" wire:model="amount" class="border rounded-lg text-base text-black border-[#d9d9d9]">
                                @error('amount')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="invoice_number" class="text-base">Invoice Number <span class="text-sm text-red-700 -mt-1">*</span></label>
                                <input type="text" wire:model="invoice_number" class="border rounded-lg text-base text-black border-[#d9d9d9]">
                                @error('invoice_number')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="customer_email" class="text-base">Customer Email <span class="text-sm text-red-700 -mt-1">*</span></label>
                                <input type="email" wire:model="customer_email" class="border rounded-lg text-base text-black border-[#d9d9d9]">
                                @error('customer_email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="status" class="text-base">Status <span class="text-sm text-red-700 -mt-1">*</span></label>
                                <select wire:model="status" id="status" class="border rounded-lg text-base text-black border-[#d9d9d9]">
                                    <option value="" selected>Select Status</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Outstanding">Outstanding</option>
                                    <option value="Paid">Paid</option>
                                </select>

                                @error('status')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex gap-2 justify-end">
                                <button type="submit" class="bg-[#6875f5] text-white px-4 py-2 rounded-md hover:bg-[#4954bd]">
                                    Create Invoice
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

