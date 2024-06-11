<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockedDate\CreateBlockedDateRequest;
use App\Http\Requests\Admin\BlockedDate\UpdateBlockedDateRequest;
use App\Models\BlockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BlockedDateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data['blocked_dates'] = BlockedDate::whereIsDeleted(0)->latest()->get();
            return view('admin.bookings.blocked', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create(CreateBlockedDateRequest $request)
    {
        try {
            BlockedDate::create(array_merge($request->validated(),['created_by' => auth()->id()]));
            return 'success';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(UpdateBlockedDateRequest $request)
    {
        try {
            BlockedDate::where('id',Crypt::decrypt($request->id))->update(array_merge($request->validated(),['updated_by' => auth()->id()]));
            return 'success';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function status(Request $request)
    {
        try {
            $status = BlockedDate::findorFail(Crypt::decrypt($request->id));
            $status->update(['updated_by' => auth()->id(), 'is_active' => $status->is_active ? 0 : 1]);
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete = BlockedDate::findorFail(Crypt::decrypt($request->id));
            $delete->update(['updated_by' => auth()->id(), 'is_deleted' => $delete->is_deleted ? 0 : 1]);
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
