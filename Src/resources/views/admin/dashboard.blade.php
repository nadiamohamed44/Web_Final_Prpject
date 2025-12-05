@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <h4>{{ $stats['total_orders'] ?? 0 }}</h4>
                <p>إجمالي الطلبات</p>
            </div>
        </div>
    </div> 

    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <h4>{{ $stats['pending_orders'] ?? 0 }}</h4>
                <p>طلبات في الانتظار</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <h4>{{ number_format($stats['total_revenue'] ?? 0) }} جنيه</h4>
                <p>الإيرادات</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <h4>{{ $stats['total_products'] ?? 0 }}</h4>
                <p>المنتجات</p>
            </div>
        </div>
    </div>
</div>
@endsection
