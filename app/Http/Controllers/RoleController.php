<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{


// function __construct()
// {

// $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
// $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
// $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
// $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);

// }




public function index()
{
    try {
        // ✅ جلب الأدوار بترتيب تنازلي مع التصفح (pagination)
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        // ✅ تجهيز البيانات بحيث تشمل الصلاحيات لكل دور
        $formattedRoles = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name') // جلب أسماء الصلاحيات فقط
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => __('messages.roles_list'),
            'data' => $formattedRoles,
            'local' => app()->getLocale(),
            'meta' => [
                'total' => $roles->total(),
                'per_page' => $roles->perPage(),
                'current_page' => $roles->currentPage(),
                'last_page' => $roles->lastPage(),
            ],
            'status_code' => 200
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.roles_list_failed'),
            'status_code' => 500
        ], 500);
    }
}

public function store(Request $request)
{
    try {
        // ✅ التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:50',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ]);

        // ✅ جلب أسماء الصلاحيات بناءً على المعرفات (IDs) بدلاً من pluck()
        $permissions = Permission::whereIn('id', $validated['permissions'])->get();

        // dd($permissions);
        // ✅ إنشاء الدور (Role)
        $role = Role::create(['name' => $validated['name']]);

        // ✅ إسناد الصلاحيات للدور باستخدام syncPermissions()
        $role->syncPermissions($permissions);

        // ✅ تجهيز استجابة API احترافية
        return response()->json([
            'status' => 'success',
            'message' => __('messages.role_created'),
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $permissions->pluck('name') // جلب أسماء الصلاحيات داخل JSON
            ],
            'status_code' => 201
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.role_creation_failed'),
            'error_details' => $e->getMessage(),
            'status_code' => 500
        ], 500);
    }
}
public function show($id)
{
    try {
        // ✅ البحث عن الدور أو إرسال خطأ تلقائيًا إذا لم يكن موجودًا
        $role = Role::findOrFail($id);

        // ✅ جلب جميع أسماء الصلاحيات الخاصة بالدور مباشرة عبر العلاقة
        $permissions = $role->permissions->pluck('name');

        return response()->json([
            'status' => 'success',
            'message' => __('messages.role_found'),
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $permissions
            ],
            'status_code' => 200
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.role_not_found'),
            'status_code' => 404
        ], 404);
    }
}

public function update(Request $request, $id)
{
$request->validate([
    'name' => 'required|string' ,
    'permissions' => 'nullable|array',
    'permissions.*' => 'exists:permissions,id'

]);
$role = Role::find($id);
$role->name = $request->input('name');
$role->save();


    // جلب أسماء الصلاحيات بناءً على المعرفات (id) المرسلة في الريكوست
    $permissionNames = Permission::whereIn('id', $request->input('permissions'))
    ->pluck('name') // استخراج الأسماء فقط
    ->toArray();    // تحويلها إلى مصفوفة


$role->syncPermissions($permissionNames);
return response()->json(['status' => 'sucseess' , 'role' => $role , 'permissions' => $permissionNames , 'status_code' => 200] , 200);
}

public function destroy(Request $request, $id)
{
    try {
        // ✅ البحث عن الدور أو إرسال خطأ تلقائيًا إذا لم يكن موجودًا
        $role = Role::findOrFail($id);

        // ✅ التحقق مما إذا كان الدور مرتبطًا بمستخدمين قبل الحذف
        if ($role->users()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.role_has_users'),
                'status_code' => 403
            ], 403);
        }

        // ✅ حذف الدور
        $role->delete();

        // ✅ تجهيز استجابة JSON احترافية
        return response()->json(['data' => [
            'status' => 'success',
            'message' => __('messages.role_deleted'),
            'deleted_role' => [
                'id' => $role->id,
                'name' => $role->name
            ],
            'status_code' => 200]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.role_not_found'),
            'status_code' => 404
        ], 404);
    }
}
}
