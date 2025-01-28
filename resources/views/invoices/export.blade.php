<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Courier New', Courier, monospace;
    }
</style>
<div style="padding: 50px;">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="background-color: #f3f4f6">
                <th style="font-size: 14px;font-weight: 600;color:#000;padding: 8px;text-align: center;">Amount</th>
                <th style="font-size: 14px;font-weight: 600;color:#000;padding: 8px;text-align: center;">Invoice Number
                </th>
                <th style="font-size: 14px;font-weight: 600;color:#000;padding: 8px;text-align: center;">Customer Email
                </th>
                <th style="font-size: 14px;font-weight: 600;color:#000;padding: 8px;text-align: center;">Status</th>
                <th style="font-size: 14px;font-weight: 600;color:#000;padding: 8px;text-align: center;">Created Date
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($invoices->isEmpty())
                <tr>
                    <td colspan="5"
                        style="font-size: 14px;font-weight: 500;color:#000;padding: 8px;text-align: center;">
                        No records found.
                    </td>
                </tr>
            @else
                @foreach ($invoices as $invoice)
                    <tr style="border-bottom: 1px solid #cccccc">
                        <td style="font-size: 14px;font-weight: 500;color:#000;padding: 8px;text-align: center;">
                            ${{ number_format($invoice->amount, 2) }}</td>
                        <td style="font-size: 14px;font-weight: 500;color:#000;padding: 8px;text-align: center;">
                            {{ $invoice->invoice_number }}</td>
                        <td style="font-size: 14px;font-weight: 500;color:#000;padding: 8px;text-align: center;">
                            {{ $invoice->customer_email }}</td>
                        <td style="font-size: 14px;font-weight: 500;color:#000;padding: 8px;text-align: center;">
                            {{ $invoice->status }}</td>
                        <td style="font-size: 14px;font-weight: 500;color:#000;padding: 8px;text-align: center;">
                            {{ $invoice->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>
