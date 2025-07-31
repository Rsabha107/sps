<?php

namespace App\Http\Controllers\Cms\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cms\Customer;
use App\Models\Procurement\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $customers = Customer::all();

        return view('procurement.admin.vendor.list', compact(
            'customers',
        ));
    }  // End function index

    public function list($id = null)
    {
        $user = User::findOrFail(Auth::user()->id);

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";

        $project_id = (request()->project_id) ? request()->project_id : "";

        // dd(request()->all());

        $ops = Vendor::orderBy($sort, $order);

        Log::info(request()->all());

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $total = $ops->count();

        $ops = $ops->paginate(request("limit"))->through(function ($op) use ($user) {

            /* returns null if it does not exist */
            // $salary = EmployeeSalary::when($op->id, function ($query, $sal) {
            //     return $query->where('employee_salary.employee_id', $sal);
            // })->first();

            // dd($salary);

            $duplicate_project = route('projects.admin.project.duplicate', $op->id);

            $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            $update_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="edit_vendor_offcanv" data-id=' . $op->id .
                ' data-table="vendor_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';

            $delete_action =
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="vendor_table" data-id="' .
                $op->id .
                '" id="delete_vendor" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            $actions = $div_action;

            ($user->can('purchase.edit')) ? $actions = $actions . $update_action . $delete_action : $actions = $actions;


            return [
                'id1' => '<div class="ms-3">' . $op->id . '</div>',
                'id' => $op->id,
                'name' => '<div class="align-middle white-space-wrap fw-bold fs-9 ms-3">' . $op->name . '</a></div>',
                'contact_name' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->contact_name . '</div>',
                'email' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->email . '</div>',
                'phone_number' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->phone_number . '</div>',
                'website' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->website . '</div>',
                'currency' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->currency . '</div>',
                'billing_address' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->billing_address . '</div>',
                'shipping_address' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->shipping_address . '</div>',
                'opening_balance' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->opening_balance . '</div>',
                'actions' => $actions,
                'created_at' => format_date($op->created_at,  'H:i:s'),
                'updated_at' => format_date($op->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $ops->items(),
            "total" => $total,
        ]);
    }

    public function get($id)
    {
        $vendor = Vendor::findOrFail($id);
        $view = view('/procurement/admin/vendor/mv/edit', [
            'vendor' => $vendor,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function get


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $vendors = new Vendor();

        $rules = [
            'name' => ['required'],
            'contact_name' => ['required'],
            'email' => ['required', 'unique:po_vendors'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
            // $message = $validator->messages();
            // $notification = array(
            //     'message'       => $message,
            //     'alert-type'    => 'error'
            // );
            // // dd(Session::has('message'));
            // return redirect()->back()->withErrors($message)->withInput();
        }

        $vendors->name = $request->name;
        $vendors->contact_name = $request->contact_name;
        $vendors->email = $request->email;
        $vendors->phone_number = $request->phone_number;
        $vendors->website = $request->website;
        $vendors->billing_address = $request->billing_address;
        $vendors->shipping_address = $request->shipping_address;
        $vendors->opening_balance = intval($request->opening_balance);
        $vendors->currency = $request->currency;

        $vendors->created_by = $user_id;
        $vendors->updated_by = $user_id;

        $vendors->save();

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        $error = false;
        $message = 'Vendor ' . $vendors->name . ' successfully created';
        // return response()->json([
        //     'error' => false,
        //     'message' => 'Project ' . $project->name . ' created successfully ',
        // ]);
        // Toastr::success('Has been add successfully :)','Success');
        return response()->json([
            'error' => $error,
            'message' => $message,
        ]);

        // return redirect()->route('projects.admin.project')->with($notification);
    } // store


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $vendor = Vendor::find($request->id);

        $rules = [
            'name' => ['required'],
            'contact_name' => ['required'],
            'email' => 'required|unique:po_vendors,email,' . $vendor->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Log::info($validator->errors());
            $error = true;
            // $message = 'Employee not create.' . $op->id;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {
            $vendor->name = $request->name;
            $vendor->contact_name = $request->contact_name;
            $vendor->email = $request->email;
            $vendor->phone_number = $request->phone_number;
            $vendor->website = $request->website;
            $vendor->billing_address = $request->billing_address;
            $vendor->shipping_address = $request->shipping_address;
            $vendor->opening_balance = intval($request->opening_balance);
            $vendor->currency = $request->currency;

            $vendor->updated_by = $user_id;

            $vendor->save();

            $notification = array(
                'message'       => 'Event updated successfully',
                'alert-type'    => 'success'
            );

            $error = false;
            $message = 'Vendor ' . $vendor->name . ' successfully updated';
        }
        return response()->json([
            'error' => $error,
            'message' => $message,
        ]);

        // // Toastr::success('Has been add successfully :)','Success');
        // if ($request->source == 'plist') {
        //     return Redirect::route('tracki.task.list', $request->id)->with($notification);
        // } else {
        //     return Redirect::route('tracki.project.show.card')->with($notification);
        // }
    } // update

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Vendor::where('id', '=', $id)->delete();
        return response()->json([
            'error' => false,
            'message' => 'Vendor deleted successfully',
        ]); // destroy
    } // destroy
}
