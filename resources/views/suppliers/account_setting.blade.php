@extends('layouts.master')
@section('title')
لوحة التحكم - اعدادات الحساب
@stop
@section('css')
<style>
    /* Modern Design System */
    :root {
        --primary-gradient: linear-gradient(135deg, #3498db, #2c3e50);
        --success-gradient: linear-gradient(135deg, #2ecc71, #27ae60);
        --warning-gradient: linear-gradient(135deg, #f1c40f, #f39c12);
        --danger-gradient: linear-gradient(135deg, #e74c3c, #c0392b);
        --card-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* Enhanced Alert Design */
    .custom-alert {
        background: var(--success-gradient);
        color: white;
        border-radius: 16px;
        padding: 20px;
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 1050;
        width: 360px;
        box-shadow: var(--card-shadow);
        display: flex;
        align-items: center;
        transform: translateX(120%);
        animation: slideIn 0.5s forwards;
    }

    .error-alert {
        background: var(--danger-gradient);
    }

    @keyframes slideIn {
        to { transform: translateX(0); }
    }

    .icon-alert {
        font-size: 28px;
        margin-right: 16px;
        background: rgba(255, 255, 255, 0.2);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-close {
        color: white;
        font-size: 20px;
        cursor: pointer;
        margin-left: auto;
        opacity: 0.8;
        transition: var(--transition);
    }

    .custom-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    /* Enhanced Card Design */
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        font-weight: 600;
        font-size: 1.2rem;
        padding: 20px 24px;
        border-bottom: none;
        background: var(--primary-gradient);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .card-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
    }

    .card-body {
        padding: 24px;
    }

    /* Enhanced Form Elements */
    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    }

    /* Enhanced Buttons */
    .btn-custom {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-custom::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
        transition: var(--transition);
    }

    .btn-custom:hover::after {
        transform: translateX(100%);
    }

    .btn-primary {
        background: var(--primary-gradient);
    }

    .btn-warning {
        background: var(--warning-gradient);
    }

    .btn-danger {
        background: var(--danger-gradient);
    }

    .btn-dark {
        background: linear-gradient(135deg, #34495e, #2c3e50);
    }

    /* Enhanced Checkbox Design */
    input[type="checkbox"] {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #e9ecef;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        position: relative;
        transition: var(--transition);
    }

    input[type="checkbox"]:checked {
        background: var(--primary-gradient);
        border-color: transparent;
    }

    input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 14px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Enhanced Badge Design */
    .badge {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
    }

    .badge-success {
        background: var(--success-gradient);
    }

    /* Breadcrumb Enhancement */
    .breadcrumb-header {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        margin-bottom: 24px;
    }

    .content-title {
        color: #2c3e50;
        font-weight: 600;
    }

    /* Divider Enhancement */
    hr {
        border: none;
        height: 1px;
        background: linear-gradient(to right, transparent, #e9ecef, transparent);
        margin: 32px 0;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card {
            margin-bottom: 16px;
        }
        
        .custom-alert {
            width: calc(100% - 32px);
            right: 16px;
        }
    }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">إعدادات الحساب</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الحساب</span>
        </div>
    </div>
</div>
@endsection

@section('content')
@if(session('success'))
    <div id="success-alert" class="custom-alert" role="alert">
        <div class="icon-alert">
            <i class="bx bx-check-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>🎉 نجاح!</strong> 
            <p class="mt-2 mb-0">{{ session('success') }}</p>
        </div>
        <button type="button" class="custom-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div id="error-alert" class="custom-alert error-alert" role="alert">
        <div class="icon-alert">
            <i class="bx bx-error"></i>
        </div>
        <div class="flex-grow-1">
            <strong>⚠️ خطأ!</strong> 
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="custom-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bx bx-bell mr-2"></i>
                إعدادات الإشعارات
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label>تلقي إشعارات البريد الإلكتروني</label>
                        <input type="checkbox" name="email_notifications" checked>
                    </div>
                    <div class="form-group">
                        <label>تلقي إشعارات الرسائل القصيرة</label>
                        <input type="checkbox" name="sms_notifications">
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bx bx-save mr-2"></i>
                        حفظ الإعدادات
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="background: var(--warning-gradient);">
                <i class="bx bx-receipt mr-2"></i>
                إدارة الفواتير
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-1">الفاتورة الحالية</h6>
                        <h4 class="mb-0">#INV-2025-001</h4>
                    </div>
                    <div class="text-right">
                        <h6 class="mb-1">المبلغ الإجمالي</h6>
                        <h4 class="mb-0">$1,250.00</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge badge-success">مدفوعة</span>
                    <a href="'view.invoices') }}" class="btn btn-warning btn-custom">
                        <i class="bx bx-history mr-2"></i>
                        عرض الفواتير السابقة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header" style="background: var(--danger-gradient);">
                <i class="bx bx-cog mr-2"></i>
                إدارة الحساب
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('supplier.update.profile') }}">
                    @csrf
                    <div class="form-group">
                        <label>تغيير كلمة المرور</label>
                        <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور الجديدة">
                    </div>
                    <button type="submit" class="btn btn-danger btn-custom">
                        <i class="bx bx-lock-alt mr-2"></i>
                        حفظ التغييرات
                    </button>
                </form>
                <hr>
                <form method="POST" action="{{ route('supplier.delete.account') }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-dark btn-custom">
                        <i class="bx bx-trash mr-2"></i>
                        حذف الحساب نهائيًا
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let successAlert = document.getElementById("success-alert");
        let errorAlert = document.getElementById("error-alert");

        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = "0";
                setTimeout(() => successAlert.remove(), 500);
            }, 4000);
        }

        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = "0";
                setTimeout(() => errorAlert.remove(), 500);
            }, 6000);
        }

        // Add hover effect to cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection
