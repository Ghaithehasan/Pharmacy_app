<?php

namespace App\Http\Controllers;

use App\Models\DamagedMedicine;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DamagedMedicineController extends Controller
{
    /**
     * عرض قائمة الأدوية التالفة مع إمكانيات متقدمة للفلترة
     */
    public function index(Request $request)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string|max:255',
                'reason' => 'nullable|in:expired,damaged,storage_issue',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
                'sort_by' => 'nullable|in:damaged_at,quantity_talif,created_at',
                'sort_direction' => 'nullable|in:asc,desc',
                'per_page' => 'nullable|integer|min:1|max:100',
                'medicine_id' => 'nullable|exists:medicines,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'خطأ في البيانات المدخلة',
                    'errors' => $validator->errors(),
                    'status_code' => 422
                ], 422);
            }

            // بناء الاستعلام
            $query = DamagedMedicine::with(['medicine' => function($q) {
                $q->select('id', 'medicine_name', 'scientific_name', 'arabic_name', 'bar_code');
            }]);

            // تطبيق الفلاتر
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('medicine', function($q) use ($search) {
                    $q->where('medicine_name', 'like', "%{$search}%")
                      ->orWhere('scientific_name', 'like', "%{$search}%")
                      ->orWhere('arabic_name', 'like', "%{$search}%")
                      ->orWhere('bar_code', 'like', "%{$search}%");
                });
            }

            if ($request->filled('reason')) {
                $query->where('reason', $request->reason);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('damaged_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('damaged_at', '<=', $request->date_to);
            }

            if ($request->filled('medicine_id')) {
                $query->where('medicine_id', $request->medicine_id);
            }

            // تطبيق الترتيب
            $sortBy = $request->sort_by ?? 'damaged_at';
            $sortDirection = $request->sort_direction ?? 'desc';
            $query->orderBy($sortBy, $sortDirection);

            // الحصول على النتائج مع التقسيم
            $perPage = $request->per_page ?? 15;
            $damagedMedicines = $query->paginate($perPage);

            // إضافة إحصائيات إضافية
            $statistics = [
                'total_damaged' => $query->sum('quantity_talif'),
                'total_records' => $query->count(),
                'by_reason' => $query->select('reason', DB::raw('count(*) as count'))
                                   ->groupBy('reason')
                                   ->get()
            ];

            return response()->json([
                'status' => 'success',
                'data' => [
                    'damaged_medicines' => $damagedMedicines,
                    'statistics' => $statistics,
                    'filters' => [
                        'applied' => $request->only([
                            'search', 'reason', 'date_from', 'date_to',
                            'sort_by', 'sort_direction', 'per_page', 'medicine_id'
                        ]),
                        'available' => [
                            'reasons' => ['expired', 'damaged', 'storage_issue'],
                            'sort_columns' => ['damaged_at', 'quantity_talif', 'created_at'],
                            'sort_directions' => ['asc', 'desc']
                        ]
                    ]
                ],
                'status_code' => 200
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب البيانات',
                'error' => $e->getMessage(),
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * البحث عن الدواء باستخدام الباركود
     */
    public function searchByBarcode(Request $request)
    {
        $request->validate([
            'bar_code' => 'required|string'
        ]);

        $medicine = Medicine::where('bar_code', $request->query('bar_code'))
                          ->where('quantity', '>', 0)
                          ->first();

        if (!$medicine) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على الدواء أو أنه غير متوفر في المخزون',
                'status_code' => 404
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'medicine' => $medicine,
            'status_code' => 200,
            'message' => 'تم العثور على الدواء بنجاح'
        ]);
    }

    /**
     * حفظ دواء تالف جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity_talif' => 'required|integer|min:1',
            'reason' => 'required|in:expired,damaged,storage_issue',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $medicine = Medicine::findOrFail($request->medicine_id);
            
            // التحقق من أن الكمية المتوفرة كافية
            if ($medicine->quantity < $request->quantity_talif) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'الكمية المطلوبة غير متوفرة في المخزون',
                    'status_code' => 400
                ], 400);
            }

            // إنشاء سجل الدواء التالف
            $damagedMedicine = DamagedMedicine::create([
                'medicine_id' => $request->medicine_id,
                'quantity_talif' => $request->quantity_talif,
                'reason' => $request->reason,
                'notes' => $request->notes
            ]);

            // تحديث كمية الدواء في المخزون
            $medicine->decrement('quantity', $request->quantity_talif);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'تم تسجيل الدواء التالف بنجاح',
                'data' => $damagedMedicine->load('medicine'),
                'status_code' => 201
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء تسجيل الدواء التالف',
                'error' => $e->getMessage(),
                'status_code' => 500
            ], 500);
        }
    }
} 