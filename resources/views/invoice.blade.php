<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة #{{ $orderId }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            max-width: 900px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffe600;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 2rem;
            color: #004aad;
        }

        .header .company-details {
            text-align: left;
        }

        .header .company-details p {
            margin: 0;
            line-height: 1.5;
            font-size: 0.9rem;
            color: #333;
        }

        .invoice-details {
            text-align: right;
            margin-top: 20px;
        }

        .invoice-details p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table thead {
            background-color: #004aad;
            color: #fff;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 0.9rem;
        }

        .table th {
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .summary {
            margin-top: 20px;
            font-size: 1rem;
            font-weight: bold;
            text-align: left;
        }

        .summary p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8rem;
            text-align: left;
            color: #555;
        }

        .footer .payment-info {
            margin-top: 10px;
            font-size: 0.9rem;
            direction: rtl;
            float: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>فاتورة</h1>
            </div>
            <div class="company-details">
                <p>شركة بناء المنازل</p>
                <p>9603 الحي الثاني، مركز اللواء</p>
                <p>الرياض</p>
                <p>الهاتف: 050 8956</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <p><strong>رقم الفاتورة:</strong> {{ $orderId }}</p>
            <p><strong>العنوان:</strong> {{ $shipping['address'] }}, {{ $shipping['city'] }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $shipping['phone'] }}</p>
        </div>

        <!-- Items Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['name']? $item['name'] :  $item['product']['name_ar'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['price'] }} ر.س</td>
                        <td>{{ $item['total'] }} ر.س</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <p><strong>الإجمالي الفرعي:</strong> {{ $subtotal }} ر.س</p>
            <p><strong>الضريبة:</strong> {{ $tax }} ر.س</p>
            <p><strong>الإجمالي:</strong> {{ $total }} ر.س</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>شكراً لتعاملكم معنا</p>
            <div class="payment-info">
                <p><strong>معلومات الدفع:</strong></p>
                <p>الاسم: ماجد الريس</p>
                <p>رقم الحساب: 5316 9518 2930 3793</p>
            </div>
        </div>
    </div>
</body>
</html>
