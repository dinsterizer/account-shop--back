<?php

namespace App\Http\Controllers;

use App\Models\AccountInfo;
use App\Models\AccountType;
use App\Models\Rule;
use App\Models\Role;
use DB;
use Str;
use App\Http\Resources\AccountInfoResource;
use App\Http\Requests\StoreAccountInfoRequest;
use App\Http\Requests\UpdateAccountInfoRequest;

class AccountInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AccountInfoResource::collection(AccountInfo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountInfoRequest $request)
    {
        // Get accountType
        $accountType = AccountType::find($request->accountTypeId);
        if (is_null($accountType)) {
            return response()->json([
                'message' => 'ID kiểu tài khoản không tồn tại trong hệ thống.',
            ], 404);
        }

        // Initialize data
        $accountInfoData = [];
        foreach ([
            'order', 'name', 'description'
        ] as $key) {
            if ($request->filled($key)) {
                $accountInfoData[$key] = $request->$key;
            }
        }
        $accountInfoData['slug'] = Str::slug($accountInfoData['name']);
        $accountInfoData['account_type_id'] = $accountType->id;
        $accountInfoData['last_updated_editor_id'] = auth()->user()->id;
        $accountInfoData['creator_id'] = auth()->user()->id;

        // DB transaction
        try {
            DB::beginTransaction();
            $accountInfoData['rule_id'] = Rule::create($request->rule ?? [])->id; // Save rule in database
            $accountInfo = AccountInfo::create($accountInfoData); // Save account info to database

            // Relationship many-many with Models\Role
            $role = Role::all();
            foreach ($request->roleKeys ?? [] as $roleKey) {
                if ($role->contains($roleKey)) {
                    $accountInfo->rolesNeedFillingAccountInfo()->attach($roleKey);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Thêm mới thông tin tài khoản cần thiết thất bại, vui lòng thừ lại sau.',
            ], 500);
        }

        return new AccountInfoResource($accountInfo->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountInfo  $accountInfo
     * @return \Illuminate\Http\Response
     */
    public function show(AccountInfo $accountInfo)
    {
        return new AccountInfoResource($accountInfo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountInfo  $accountInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountInfoRequest $request, AccountInfo $accountInfo)
    {
        // Initialize data
        $accountInfoData = [];
        foreach ([
            'order', 'name', 'description'
        ] as $key) {
            if ($request->filled($key)) {
                $accountInfoData[$key] = $request->$key;
            }
        }
        if (array_key_exists('name', $accountInfoData)) {
            $accountInfoData['slug'] = Str::slug($accountInfoData['name']);
        }
        $accountInfoData['last_updated_editor_id'] = auth()->user()->id;

        // DB transaction
        try {
            DB::beginTransaction();
            $accountInfo->update($accountInfoData); // Save rule to database
            $accountInfo->rule->update($request->rule ?? []);

            // Relationship many-many with Models\Role
            $role = Role::all();
            $syncRoleKeys = [];
            foreach ($request->roleKeys ?? [] as $roleKey) {
                if ($role->contains($roleKey)) {
                    $syncRoleKeys[] = $roleKey;
                }
            }
            $accountInfo->rolesNeedFillingAccountInfo()->sync($syncRoleKeys);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Cập nhật thông tin tài khoản cần thiết thất bại, vui lòng thừ lại sau.',
            ], 500);
        }

        return new AccountInfoResource($accountInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountInfo  $accountInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountInfo $accountInfo)
    {
        // DB transaction
        try {
            DB::beginTransaction();
            $accountInfo->rolesNeedFillingAccountInfo()->sync([]); // Delete relationship with Models\Role
            $accountInfo->delete();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Xoá thông tin tài khoản cần thiết thất bại, vui lòng thừ lại sau.',
            ], 500);
        }

        return response()->json([
            'message' => 'Xoá thông tin tài khoản cần thiết thành công.',
        ], 200);
    }
}
