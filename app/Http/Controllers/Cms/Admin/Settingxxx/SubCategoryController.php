<?php

namespace App\Http\Controllers\Procurement\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Procurement\ItemCategory;
use App\Models\Procurement\ItemSubcategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = ItemCategory::all();
        return view('procurement.admin.setting.subcategory.index', compact('categories'));
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
        $op = ItemSubcategory::orderBy($sort, $order);

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
            '<a href="javascript:void(0)" class="btn btn-sm" id="edit_procurement_subcategory"  data-id=' .
            $op->id .
            ' data-table="procurement_subcategory_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
            '<i class="fa-solid fa-pen-to-square text-primary"></i></a>' .
            '<a href="javascript:void(0)" class="btn btn-sm" data-table="procurement_subcategory_table" data-id="' .
            $op->id .
            '" id="delete_procurement_subcategory" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
            '<i class="bx bx-trash text-danger"></i></a></div></div>';

            return [
                'id' => $op->id,
                'id1' => '<div class="ms-3">' . $op->id . '</div>',
                'name' => '<div class="align-middle white-space-wrap fw-bold fs-8 ms-3">' . $op->name . '</div>',
                'category_id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ms-1">' . $op->category?->name . '</div>',
                'active_flag' => '<span class="badge badge-phoenix badge-phoenix-' . $op->active_status->color . ' ms-1">' . $op->active_status->name . '</span>',
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
        $op = new ItemSubcategory();

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
            $message = 'Sub Category created.';

            $op->name = $request->name;
            $op->active_flag = $request->active_flag;
            $op->category_id = $request->category_id;
            $op->created_by = auth()->user()->id;
            $op->updated_by = auth()->user()->id;
            $op->save();
        }

        return response()->json(['error' => $error, 'message' => $message]);
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
            $subcategory = ItemSubcategory::findOrFail($id);
            return response()->json(['subcategory' => $subcategory]);
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
            $op = ItemSubcategory::findOrFail($request->id);

            $error = false;
            $message = 'Sub Category updated successfully. '.$request->name;

            $op->name = $request->name;
            $op->category_id = $request->category_id;
            $op->updated_by = auth()->user()->id;
            $op->active_flag = $request->active_flag;
            $op->save();
        }

        return response()->json(['error' => $error, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LOG::debug('Sub CategoryController:destroy');
        ItemSubcategory::where('id', '=', $id)->delete();

        return response()->json([
            'error' => false,
            'message' => 'Sub Category deleted successfully',
        ]);
    }
}
