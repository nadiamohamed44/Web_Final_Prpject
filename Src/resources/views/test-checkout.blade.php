<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تم الطلب بنجاح!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">

<div class="max-w-3xl mx-auto mt-10 bg-white rounded-2xl shadow-2xl overflow-hidden">

    <div class="bg-gradient-to-r from-green-500 to-teal-600 p-8 text-white text-center">
        <h1 class="text-4xl font-bold">تم إنشاء الطلب بنجاح!</h1>
        <p class="text-xl mt-2">شكراً يا {{ $user->first_name }} على طلبك</p>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-2 gap-6 mb-8 text-lg">
            <div class="bg-gray-100 p-4 rounded-lg">
                <strong>رقم الطلب:</strong> #{{ $order->id }}
            </div>
            <div class="bg-gray-100 p-4 rounded-lg">
                <strong>التاريخ:</strong> {{ $order->created_at->format('d/m/Y h:i A') }}
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800">تفاصيل الطلب</h2>
        <table class="w-full text-right border-collapse mb-8">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4">الصنف</th>
                    <th class="p-4">الكمية</th>
                    <th class="p-4">سعر الوحدة</th>
                    <th class="p-4">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-semibold">{{ $item->menuItem->name }}</td>
                    <td class="p-4 text-center">{{ $item->quantity }}</td>
                    <td class="p-4">{{ number_format($item->price, 2) }} ج.م</td>
                    <td class="p-4 font-bold text-green-600">
                        {{ number_format($item->price * $item->quantity, 2) }} ج.م
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bg-green-50 p-6 rounded-xl text-xl font-bold text-left">
            <p>المجموع قبل الضريبة: <span class="text-2xl">{{ number_format($summary['subtotal'], 2) }}</span> ج.م</p>
            <p>ضريبة 14%: <span class="text-red-600">{{ number_format($summary['tax'], 2) }}</span> ج.م</p>
            <p class="text-3xl mt-4 text-green-700">
                الإجمالي الكلي: {{ number_format($summary['total'], 2) }} ج.م
            </p>
        </div>

        <div class="mt-10 text-center">
            <p class="text-2xl mb-4">
                السلة الآن: 
                <span class="font-bold text-red-600">
                    {{ $cartService->isEmpty() ? 'فارغة تماماً' : 'لسه فيها حاجات!' }}
                </span>
            </p>
            <a href="{{ route('test.checkout') }}" 
               class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-full text-xl hover:shadow-xl transform hover:scale-105 transition">
                جربي تاني من الأول
            </a>
        </div>
    </div>
</div>

</body>
</html>