<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
// use DB;
// use Hash;
class UserController extends Controller
{

    public function index()
    {
        // ✅ الحصول على بيانات المستخدمين بترتيب تنازلي مع التصفح (pagination)
        $users = User::orderBy('id', 'DESC')->paginate(5);

        // ✅ التأكد من وجود بيانات
        if ($users->isNotEmpty()) {
            // ✅ تعديل البيانات بحيث تشمل الأدوار لكل مستخدم
            $formattedUsers = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'roles' => $user->getRoleNames(), // جلب الأدوار لكل مستخدم
                ];
            });

            // ✅ تجهيز استجابة JSON محسنة
            return response()->json([
                'status' => 'success',
                'data' => $formattedUsers,
                'local' => app()->getLocale(),
                'meta' => [
                    'total' => $users->total(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                ],
                'status_code' => 200
            ], 200);
        }

        // ✅ استجابة إذا لم يكن هناك مستخدمون
        return response()->json([
            'status' => 'success',
            'message' => __('messages.users_empty'),
            'status_code' => 200
        ], 200);
    }



    public function store(Request $request)
    {
        try {
            // ✅ التحقق من صحة البيانات المدخلة
            $valid_data = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|string',
                'phone' => 'required|numeric|digits_between:8,15|unique:users,phone',
                'gender' => 'required|in:male,female',
                'roles' => 'required|array|min:1', // يجب أن تكون الأدوار في مصفوفة
                'roles.*' => 'exists:roles,name' // التحقق من صحة الأدوار
            ]);

            // ✅ تشفير كلمة المرور
            $valid_data['password'] = Hash::make($request->password);

            // ✅ إنشاء المستخدم
            $user = User::create($valid_data);

            // ✅ إسناد الأدوار باستخدام Spatie Permissions
            $user->syncRoles($request->roles);

            // ✅ استجابة ناجحة
            return response()->json([
                'status' => 'success',
                'message' => __('messages.user_created'),
                'user' => $user,
                'assigned_roles' => $user->getRoleNames(),
                'status_code' => 201
            ], 201);

        } catch (\Exception $e) {
            // ✅ معالجة الأخطاء
            return response()->json([
                'status' => 'error',
                'message' => __('messages.user_creation_failed'),
                'error_details' => $e->getMessage(),
                'status_code' => 500
            ], 500);
        }
    }


    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.users_empty'),
                'status_code' => 404
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'assigned_roles' => $user->getRoleNames(),
            'status_code' => 200
        ], 200);

    }


    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'nullable|string|max:50',
                'email' => 'nullable|email|unique:users,email,' . $user->id, // منع تكرار البريد الإلكتروني
                'password' => 'nullable|min:8|string',
                'phone' => 'nullable|numeric|digits_between:10,10|unique:users,phone,' . $user->id,
                'gender' => 'nullable|in:male,female',
                'roles' => 'nullable|array|min:1',
                'roles.*' => 'exists:roles,name' // التحقق من صحة الأدوار
            ]);

            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            }

            $user->update($validated);

            // ✅ تحديث الأدوار إذا تم إرسالها
            if ($request->filled('roles')) {
                $user->syncRoles($request->roles);
            }

            return response()->json([
                'status' => 'success',
                'message' => __('messages.user_updated'),
                'updated_user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'roles' => $user->getRoleNames()
                ],
                'status_code' => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.user_update_failed'),
                'error_details' => $e->getMessage(),
                'status_code' => 500
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // ✅ البحث عن المستخدم أو إرسال خطأ تلقائيًا إذا لم يكن موجودًا
            $user = User::findOrFail($id);

            // ✅ منع حذف المستخدم إذا كان يملك دور Admin رئيسي (مثلاً)
            if ($user->hasRole('admin')) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('messages.delete_admin_error'),
                    'status_code' => 403
                ], 403);
            }

            // ✅ حذف المستخدم
            $user->delete();
            // ✅ تجهيز استجابة JSON تفصيلية
            return response()->json([
                'status' => 'success',
                'message' => __('messages.user_deleted'),
                'status_code' => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.user_not_found'),
                'status_code' => 404
            ], 404);
        }
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $roles = Role::pluck('name', 'name')->all();
    //     // dd($roles);

    //     return view('users.Add_user', compact('roles'));
    // }
    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //                     'name' => 'required',
    //                     'email' => 'required|email|unique:users,email',
    //                     'password' => 'required|same:confirm-password',
    //                     'Status' => 'required' ,
    //                     'roles_name' => 'required'
    //     ]);

    //     $data['password'] = Hash::make($data['password']);



    //     $roles = $request->input('roles_name'); // ["admin","midd"]


    //     $user = User::create($data);
    //     $user->assignRole($roles);
    //     return redirect()->route('users.index')
    //         ->with('success', 'تم اضافة المستخدم بنجاح');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $user = User::find($id);
    //     return view('users.show', compact('user'));
    // }
    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $user = User::find($id);
    //     $roles = Role::pluck('name', 'name')->all();
    //     $userRole = $user->roles->pluck('name', 'name')->all();
    //     return view('users.edit', compact('user', 'roles', 'userRole'));
    // }
    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     // $this->validate($request, [
    //     //     'name' => 'required',
    //     //     'email' => 'required|email|unique:users,email,' . $id,
    //     //     'password' => 'same:confirm-password',
    //     //     'roles' => 'required'
    //     // ]);

    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         'password' => 'same:confirm-password',
    //         'roles' => 'required'
    //     ]);



    //     $input = $request->all();
    //     if (!empty($input['password'])) {
    //         $input['password'] = Hash::make($input['password']);
    //     } else {
    //         $input = array_except($input, array('password'));
    //     }
    //     $user = User::find($id);
    //     $user->update($input);
    //     DB::table('model_has_roles')->where('model_id', $id)->delete();
    //     $user->assignRole($request->input('roles'));
    //     return redirect()->route('users.index')
    //         ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    // }
    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Request $request)
    // {
    //     User::find($request->user_id)->delete();
    //     return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    // }
}
