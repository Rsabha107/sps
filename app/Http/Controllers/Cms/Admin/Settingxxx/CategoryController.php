<?php

namespace App\Http\Controllers\Procurement\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Procurement\ItemCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('procurement.admin.setting.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $op = ItemCategory::orderBy($sort, $order);

        // dd($op);
        if ($search) {
            $op = $op->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }
        $total = $op->count();

        $op = $op->paginate(request("limit"))->through(function ($op) {

            $actions =
            '<div class="font-sans-serif btn-reveal-trigger position-static">' .
            '<a href="javascript:void(0)" class="btn btn-sm" id="edit_procurement_category"  data-id=' .
            $op->id .
            ' data-table="procurement_category_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
            '<i class="fa-solid fa-pen-to-square text-primary"></i></a>' .
            '<a href="javascript:void(0)" class="btn btn-sm" data-table="procurement_category_table" data-id="' .
            $op->id .
            '" id="delete_procurement_category" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
            '<i class="bx bx-trash text-danger"></i></a></div></div>';

            return [
                'id' => $op->id,
                'id1' => '<div class="ms-3">' . $op->id . '</div>',
                'name' => '<div class="align-middle white-space-wrap fw-bold fs-8 ms-3">' . $op->name . '</div>',
                'active_flag' => '<span class="badge badge-phoenix badge-phoenix-' . $op->active_status->color . '">' . $op->active_status->name . '</span>',
                'actions' => $actions,
                'created_at' => format_date($op->created_at,  'H:i:s'),
                'updated_at' => format_date($op->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $op->items(),
            "total" => $total,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('mainEvent');
        $op = new ItemCategory();

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        // dd($validator);

        if ($validator->fails()) {
            // Log::info($validator->errors());
            $error = true;
            // $message = 'Element could not be created';
            $message = implode($validator->errors()->all());
        } else {

            $error = false;
            $message = 'Category created.';

            $op->name = $request->name;
            $op->active_flag = $request->active_flag;
            $op->created_by = auth()->user()->id;
            $op->updated_by = auth()->user()->id;
            $op->save();
        }

        return response()->json(['error' => $error, 
                                 'message' => $message, 
                                 'inserted_id' => $op->id,
                                 'inserted_name' => $op->name]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $category = ItemCategory::findOrFail($id);
            return response()->json(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $rules = [
            'id' => ['required'],
            'name' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all());
        } else {
            $op = ItemCategory::findOrFail($request->id);

            $error = false;
            $message = 'Category updated successfully. '.$request->name;

            $op->name = $request->name;
            $op->updated_by = auth()->user()->id;
            $op->active_flag = $request->active_flag;
            $op->save();
        }

        return response()->json([ 'error' => $error, 
                                  'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LOG::debug('CategoryController:destroy');
        ItemCategory::where('id', '=', $id)->delete();

        return response()->json([
            'error' => false,
            'message' => 'Category deleted successfully',
        ]);
    }
}
