@extends('admin.layouts.app')

@section('title', 'الطلبات')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>الطلبات</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- فلاتر الحالة -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}">
                    الكل
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">
                    قيد الانتظار
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn btn-outline-info {{ request('status') == 'processing' ? 'active' : '' }}">
                    قيد المعالجة
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="btn btn-outline-success {{ request('status') == 'completed' ? 'active' : '' }}">
                    مكتملة
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="btn btn-outline-danger {{ request('status') == 'cancelled' ? 'active' : '' }}">
                    ملغية
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>الهاتف</th>
                            <th>المبلغ الإجمالي</th>
                            <th>الحالة</th>
                            <th>طريقة الدفع</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <div>
                                    <strong>{{ $order->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </div>
                            </td>
                            <td>{{ $order->phone }}</td>
                            <td><strong>{{ number_format($order->total, 2) }}</strong> جنيه</td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">قيد الانتظار</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-info">قيد المعالجة</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-success">مكتمل</span>
                                @else
                                    <span class="badge bg-danger">ملغي</span>
                                @endif
                            </td>
                            <td>
                                @if($order->payment_method == 'cash')
                                    <i class="fas fa-money-bill-wave"></i> كاش
                                @else
                                    <i class="fas fa-credit-card"></i> بطاقة
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">لا توجد طلبات</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
