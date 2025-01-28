@php
    $invoice = $invoice ?? null;
@endphp
@if ($invoice)
    <!DOCTYPE html>
    <html>

    <head>
        <title>Invoice</title>
        <style>
            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                font-family: 'Courier New', Courier, monospace;
            }
        </style>
    </head>

    <body style="padding: 50px">
        
        <h3 style="font-size: 20px;font-weight: 600;margin-bottom: 10px;margin-top: 0">Invoice</h3>
        <p style="font-size: 18px;color:#000;margin-bottom: 10px;"> <span style="font-weight: 600;width:80px;"> Invoice Number:</span>  {{ $invoice->invoice_number }}</p>
        <p style="font-size: 18px;color:#000;margin-bottom: 10px;"> <span style="font-weight: 600;width:80px;"> Customer Email: </span> {{ $invoice->customer_email }}</p>
        <p style="font-size: 18px;color:#000;margin-bottom: 10px;"><span style="font-weight: 600;width:80px;"> Amount: </span> ${{ number_format($invoice->amount, 2) }}</p>
        <p style="font-size: 18px;color:#000;margin-bottom: 10px;"><span style="font-weight: 600;width:80px;"> Status: </span> {{ $invoice->status }}</p>
        <p style="font-size: 18px;color:#000;margin-bottom: 10px;"><span style="font-weight: 600;width:80px;"> Created: </span> {{ $invoice->created_at->format('M d, Y') }}</p>
    </body>

    </html>
@else
    <p>No invoice data provided.</p>
@endif
