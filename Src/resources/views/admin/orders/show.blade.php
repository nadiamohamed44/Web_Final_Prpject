@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تفاصيل الطلب #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> رجوع
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- معلومات الطلب -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">تفاصيل الطلب</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->name ?? 'منتج محذوف' }}</strong>
                                    </td>
                                    <td>{{ number_format($item->price, 2) }} جنيه</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><strong>{{ number_format($item->price * $item->quantity, 2) }} جنيه</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>الإجمالي:</strong></td>
                                    <td><strong class="text-success">{{ number_format($order->total, 2) }} جنيه</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- معلومات العميل -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">معلومات العميل</h5>
                </div>
                <div class="card-body">
                    <p><strong>الاسم:</strong> {{ $order->user->name }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
                    <p><strong>الهاتف:</strong> {{ $order->phone }}</p>
                    <p><strong>العنوان:</strong> {{ $order->delivery_address }}</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">معلومات الطلب</h5>
                </div>
                <div class="card-body">
                    <p><strong>رقم الطلب:</strong> #{{ $order->id }}</p>
                    <p><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>طريقة الدفع:</strong>
                        @if($order->payment_method == 'cash')
                            <span class="badge bg-success">كاش</span>
                        @else
                            <span class="badge bg-primary">بطاقة</span>
                        @endif
                    </p>
                    <p><strong>الحالة:</strong>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">قيد الانتظار</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">قيد المعالجة</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success">مكتمل</span>
                        @else
                            <span class="badge bg-danger">ملغي</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- تحديث الحالة -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">تحديث حالة الطلب</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">الحالة الجديدة</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check"></i> تحديث الحالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
