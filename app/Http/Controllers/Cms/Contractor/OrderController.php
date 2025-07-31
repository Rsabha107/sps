<?php

namespace App\Http\Controllers\Cms\Contractor;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewOrderEmailJob;
use App\Models\Cms\Contractor;
use App\Models\Cms\OrderHeader;
use App\Models\GeneralSettings\Company;
use App\Models\GeneralSettings\CompanyAddress;
use App\Models\Cms\Currency;
use App\Models\Cms\Event;
use App\Models\Cms\OrderLine;
use App\Models\Cms\Product;
use App\Models\Cms\ServiceLocation;
use App\Models\Cms\ServiceTime;
use App\Models\Cms\Venue;
use App\Models\GeneralSettings\GlobalAttachment;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderTokenService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Log::info($request->query());
        $view_type = $request->query('vw', 'list');
        $user = User::findOrFail(Auth::user()->id);
        $orders = OrderHeader::where('event_id', session()->get('EVENT_ID'))
            ->where('customer_id', Auth::user()->employee_id)
            ->orderBy('id', 'DESC')
            ->get();
        $contractors = Contractor::all();
        $products = Product::all();
        $currency = Currency::all();
        $addresses = CompanyAddress::all();
        $service_times = ServiceTime::all();
        $venues = Venue::all();
        $service_locations = ServiceLocation::all();

        return view(
            'cms.contractor.orders.list',
            compact(
                'orders',
                'contractors',
                'products',
                'currency',
                'addresses',
                'service_times',
                'venues',
                'service_locations',
                'user',
                'view_type'
            )
        );
    }  // End function index

    public function list($id = null)
    {
        $user = User::findOrFail(Auth::user()->id);
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";


        // dd(request()->all());

        $ops = OrderHeader::orderBy($sort, $order);
        $ops = $ops->where('event_id', session()->get('EVENT_ID'))
            ->where('customer_id', $user->employee_id);
        // ->where('created_by', $user->id);
        // Log::info(request()->all());

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $total = $ops->count();

        $ops = $ops->paginate(request("limit"))->through(function ($op) use ($user) {

            $total_orders = OrderLine::selectRaw('SUM(quantity * unit_price) as total_amount, sum(quantity) as total_quantity')
                ->join('order_headers', 'order_lines.order_header_id', '=', 'order_headers.id')
                // ->where('order_headers.event_id', session()->get('EVENT_ID'))
                ->where('order_lines.order_header_id', $op->id)
                ->first();

            // $duplicate_project = route('projects.admin.project.duplicate', $op->id);
            $pdf_route = route("cms.contractor.orders.po.pdf", $op->id);
            $pdf_download = route("cms.admin.orders.po.pdf.download", $op->id);

            $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            $profile_action =
                '<a href="javascript:void(0)" class="btn-table btn-sm me-3"  data-id="' .
                $op->id .
                '" data-table="order_table" id="show_order_lines" data-bs-toggle="tooltip" data-bs-placement="right" title="View Order">' .
                '<i class="fa-solid far fa-lightbulb text-warning"></i></a>';
            $actions_pdf =
                '<a href="' . $pdf_route . '" class="btn-table btn-sm me-3" id="bookingDetails" target="_blank" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Order Pdf">' .
                '<i class="fa-solid fa-file-invoice text-success"></i></a>';

            $actions_download_pdf =
                '<a href="' . $pdf_download . '" class="btn btn-sm me-3" id="bookingDetails" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Download Order Pdf">' .
                '<i class="fa-solid fa-download text-dark"></i></a>';

            $update_action =
                '<a href="javascript:void(0)" class="btn-table btn-sm me-3" id="edit_purchase_offcanv" data-id=' . $op->id .
                ' data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';

            $attach_payment_file_action =
                '<a href="javascript:void(0)" class="btn-table btn-sm me-3" id="attach_payment_file" data-id=' . $op->id .
                ' data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Upload Payment File">' .
                '<i class="fa-solid fa-file-arrow-up text-primary"></i></a>';

            $delete_action =
                '<a href="javascript:void(0)" class="btn-table btn-sm" data-table="order_table" data-id="' .
                $op->id .
                '" id="delete_purchase" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div>';

            $end_action = '</div>';

            $actions = $div_action;

            // $actions = $actions . $profile_action . $actions_pdf . $delete_action;
            if ($op->status->title == 'Payment Submitted' || $op->status->title == 'Payment Pending') {
                $actions = $actions .  $profile_action . $actions_pdf . $attach_payment_file_action . $delete_action;
            } else {
                $actions = $actions . $profile_action . $actions_pdf;
            }
            $actions = $actions . $end_action;

            $icon = (($op->attachments?->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2" id="attachment_list" data-model_id=' . $op->id . '><span class="fas fa-paperclip me-1"></span>' . $op->attachments?->count() . '</button>' : "");

            $order_status =  '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $op->status->color . ' "><span class="badge-label" style="cursor: default;">' . $op->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>';


            return [
                'id1' => '<div class="ms-3">' . $op->id . '</div>',
                'id' => $op->id,
                'icon' => $icon,
                'order_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ms-1"><a href="javascript:void(0)" id="show_order_lines" data-id="' . $op->id . '">' . $op->order_number . '</a></div>',
                'customer_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->contractor?->company_name . '</div>',
                'event_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->event?->name . '</div>',
                'venue_id' => '<span class="badge badge-pill bg-body-tertiary">' . $op->lines->pluck('venue.short_name')->unique()->implode(', ') . '</span>',
                'order_date' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . format_date($op->order_date) . '</div>',
                'payable_to_sc' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . ($total_orders->total_amount * 0.25) . '</div>',
                'total_quantity' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $total_orders->total_quantity . '</div>',
                'total_amount' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $total_orders->total_amount . '</div>',
                'status' => $order_status,
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

    public function lines($id = null)
    {
        $user = User::findOrFail(Auth::user()->id);
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";


        // dd(request()->all());

        $ops = OrderLine::orderBy($sort, $order);
        $ops = $ops->with(['order_header' => function ($query) {
            $query->where('event_id', session()->get('EVENT_ID'))
                ->where('customer_id', Auth::user()->employee_id);
        }]);

        // $ops = $ops->where('event_id', session()->get('EVENT_ID'))
        //     ->where('customer_id', $user->employee_id);
        // ->where('created_by', $user->id);
        // Log::info(request()->all());
        // $ops = $ops->get();
        // foreach ($ops as $op) {
        //     $opline = $op->lines;
        //     foreach ($opline as $line) {
        //         Log::info('Order Line: ' . $line->id . ' - Product: ' . $line->product_name);
        //     }
        // }

        // dd('ok');

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $total = $ops->count();

        $ops = $ops->paginate(request("limit"))->through(function ($op) use ($user) {

            Log::info('Processing Order ID: ' . $op->order_header->id);
                Log::info('Order Line: ' . $op->id );
            $total_orders = OrderLine::selectRaw('SUM(quantity * unit_price) as total_amount, sum(quantity) as total_quantity')
                ->join('order_headers', 'order_lines.order_header_id', '=', 'order_headers.id')
                // ->where('order_headers.event_id', session()->get('EVENT_ID'))
                ->where('order_lines.order_header_id', $op->id)
                ->first();

            // $duplicate_project = route('projects.admin.project.duplicate', $op->id);
            $pdf_route = route("cms.contractor.orders.po.pdf", $op->order_header->id);
            $pdf_download = route("cms.admin.orders.po.pdf.download", $op->order_header->id);

            $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            // $profile_action =
            //     '<a href="javascript:void(0)" class="btn-table btn-sm me-3"  data-id="' .
            //     $op->id .
            //     '" data-table="order_table" id="show_order_lines" data-bs-toggle="tooltip" data-bs-placement="right" title="View Order">' .
            //     '<i class="fa-solid far fa-lightbulb text-warning"></i></a>';
            $actions_pdf =
                '<a href="' . $pdf_route . '" class="btn-table btn-sm me-3" id="bookingDetails" target="_blank" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Order Pdf">' .
                '<i class="fa-solid fa-file-invoice text-success"></i></a>';

            $actions_download_pdf =
                '<a href="' . $pdf_download . '" class="btn btn-sm me-3" id="bookingDetails" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Download Order Pdf">' .
                '<i class="fa-solid fa-download text-dark"></i></a>';

            $update_action =
                '<a href="javascript:void(0)" class="btn-table btn-sm me-3" id="edit_purchase_offcanv" data-id=' . $op->id .
                ' data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';

            // $attach_payment_file_action =
            //     '<a href="javascript:void(0)" class="btn-table btn-sm me-3" id="attach_payment_file" data-id=' . $op->id .
            //     ' data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Upload Payment File">' .
            //     '<i class="fa-solid fa-file-arrow-up text-primary"></i></a>';

            // $delete_action =
            //     '<a href="javascript:void(0)" class="btn-table btn-sm" data-table="order_table" data-id="' .
            //     $op->id .
            //     '" id="delete_purchase" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
            //     '<i class="fa-solid fa-trash text-danger"></i></a></div>';

            $end_action = '</div>';

            $actions = $div_action;

            // $actions = $actions . $profile_action . $actions_pdf . $delete_action;
            if ($op->order_header->status->title == 'Payment Submitted' || $op->order_header->status->title == 'Payment Pending') {
                $actions = $actions . $actions_pdf;
            } else {
                $actions = $actions . $actions_pdf;
            }
            $actions = $actions . $end_action;

            $icon = (($op->attachments?->count()) ? '<button class="btn p-0 text-body-tertiary fs-10 me-2" id="attachment_list" data-model_id=' . $op->id . '><span class="fas fa-paperclip me-1"></span>' . $op->attachments?->count() . '</button>' : "");

            $order_status =  '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $op->order_header->status->color . ' "><span class="badge-label" style="cursor: default;">' . $op->order_header->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>';


            return [
                'id1' => '<div class="ms-3">' . $op->id . '</div>',
                'id' => $op->id,
                'icon' => $icon,
                'order_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ms-1">' . $op->order_header->order_number . '</div>',
                'line_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->id . '</div>',
                'customer_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->order_header->contractor?->company_name . '</div>',
                'event_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->event?->name . '</div>',
                'venue_id' => '<span class="badge badge-pill bg-body-tertiary">' . $op->venue->short_name . '</span>',
                'product_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->product->product_name . '</span>',
                'service_date' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . format_date($op->service_date) . '</div>',
                'service_time' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->service_time->title . '</div>',
                'quantity' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->quantity . '</div>',
                'unit_price' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->unit_price . '</div>',
                'payable_to_sc' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . ($total_orders->total_amount * 0.25) . '</div>',
                'total_quantity' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $total_orders->total_quantity . '</div>',
                'total_amount' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->unit_price * $op->quantity . '</div>',
                'status' => $order_status,
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
        $purchase = OrderHeader::findOrFail($id);
        $lines = OrderLine::where('po_header_id', $purchase->id)->get();
        $customers = Contractor::all();
        $Products = Product::all();
        $currency = Currency::all();
        $addresses = CompanyAddress::all();

        $view = view('/procurement/admin/purchase/mv/edit', [
            'purchase' => $purchase,
            'customers' => $customers,
            'Products' => $Products,
            'currency' => $currency,
            'addresses' => $addresses,
            'lines' => $lines,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function get


    public function getLines($id)
    {
        $order = OrderHeader::findOrFail($id);
        $lines = $order->lines;

        $total_orders = OrderLine::selectRaw('SUM(quantity * unit_price) as total_amount, sum(quantity) as total_quantity')
            ->join('order_headers', 'order_lines.order_header_id', '=', 'order_headers.id')
            // ->where('order_headers.event_id', session()->get('EVENT_ID'))
            ->where('order_lines.order_header_id', $id)
            ->first();
        // dd($lines);

        $view = view('/cms/contractor/orders/_order_details_modal', [
            'order' => $order,
            'lines' => $lines,
            'total_orders' => $total_orders,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function get

    public function getItem($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'itemData' => $product,
        ]);
    }  // End function getItem

    // show the purchase order 
    public function viewPo($id)
    {
        $header = OrderHeader::find($id);
        $lines = OrderLine::where('po_header_id', $header->id)->get();
        $company = Company::all()->first();

        return view('procurement.admin.purchase.purchase-order', [
            'header' => $header,
            'lines' => $lines,
            'company' => $company,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('$request');
        Log::info($request->all());
        Log::info(json_encode($request->all()));
        $user = Auth::user();

        $rules = [
            // 'order_number' => ['required'],
            // 'contact_name' => ['required'],
            // 'email' => ['required', 'unique:purchase_order_headers'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
            return response()->json(['error' => $error, 'message' => $message,]);
        } else {

            DB::beginTransaction();

            try {
                $order_status_id = gerOrderStatusId('Payment Pending');
                $head = OrderHeader::create([
                    'event_id' => session()->get('EVENT_ID'),
                    // 'order_number' => $request->order_number,
                    'customer_id' => $user->employee_id,
                    // 'customer_id' => intval($request->customer_id),
                    'order_date' => Carbon::now(),
                    // 'order_date' => Carbon::createFromFormat('d/m/Y', $request->order_date),
                    'note_to_vendor' => $request->note_to_vendor,
                    'order_status_id' => intval($order_status_id),
                    'currency_id' => intval($request->currency_id),
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]);

                $saved = $head->save();
                if ($saved) {
                    $order_header_id = $head->id;
                    foreach ($request->product_id as $key => $item) {
                        Log::info('Creating OrderLine key:  ' . $key . ' with product_id: ' . $request->product_id[$key]);
                        $data = new OrderLine([
                            'order_header_id' => $order_header_id,
                            'event_id' => $head->event_id,
                            'service_date' => Carbon::createFromFormat('d/m/Y', $request->service_date[$key]),
                            'product_id' => $request->product_id[$key],
                            'service_location_id' => $request->service_location_id[$key],
                            'service_time_id' => $request->service_time_id[$key],
                            'venue_id' => $request->venue_id[$key],
                            'quantity' => $request->quantity[$key],
                            'unit_price' => $request->unit_price[$key],
                            'line_total' => $request->quantity[$key] * $request->unit_price[$key],
                            'created_by' => $user->id,
                            'updated_by' => $user->id,
                        ]);


                        Log::info($data);
                        $data->save();
                    }

                    $saveOrderPdf = $this->saveOrderPDF($head->id);
                    $details = [
                        'email' => 'rsabha@gmail.com',
                        'order_ref_number' => $head->order_number,
                        'filename' => $head->order_number . '.pdf',
                    ];

                    Log::info('BookingController::admin_email: ' . config('settings.admin_email'));
                    Log::info('BookingController::store details: ' . json_encode($details));
                    Log::info('BookingController::store settings.send_notifications: ' . config('settings.send_notifications'));

                    // send email to contractor with order details as a pdf attachment
                    if (config('settings.send_notifications')) {
                        SendNewOrderEmailJob::dispatch($details);
                    }
                }

                DB::commit();

                $notification = array(
                    'message'       => 'Order created successfully',
                    'alert-type'    => 'success'
                );

                $error = false;
                $message = 'Order ' . $head->order_number . ' successfully created';
                return response()->json(['error' => $error, 'message' => $message,]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating order: ' . $e->getMessage());
                $error = true;
                $message = 'Failed to create order. Please try again.';
                return response()->json(['error' => $error, 'message' => $message,]);
            }
        }

        // return redirect()->route('projects.admin.project')->with($notification);
    } // store


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd('createEvent');
        $user_id = Auth::user()->id;
        $purchase = OrderHeader::find($request->id);

        $rules = [
            'name' => ['required'],
            'contact_name' => ['required'],
            'email' => 'required|unique:purchase_order_headers,email,' . $purchase->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Log::info($validator->errors());
            $error = true;
            // $message = 'Employee not create.' . $op->id;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {
            $purchase->name = $request->name;
            $purchase->contact_name = $request->contact_name;
            $purchase->email = $request->email;
            $purchase->phone_number = $request->phone_number;
            $purchase->website = $request->website;
            $purchase->billing_address = $request->billing_address;
            $purchase->shipping_address = $request->shipping_address;
            $purchase->opening_balance = intval($request->opening_balance);
            $purchase->currency = $request->currency;

            $purchase->updated_by = $user_id;

            $purchase->save();

            $notification = array(
                'message'       => 'Event updated successfully',
                'alert-type'    => 'success'
            );

            $error = false;
            $message = 'Purchase Order ' . $purchase->name . ' successfully updated';
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
        OrderHeader::where('id', '=', $id)->delete();
        return response()->json([
            'error' => false,
            'message' => 'Purchase Order deleted successfully',
        ]); // destroy
    } // destroy


    // generate a Order PDF
    public function orderPDF($id)
    {
        // Log::info('Generating PDF for Order ID: ' . $id);
        $po = OrderHeader::findOrFail($id);
        // $company = Company::all()->first();

        // $customer = new Buyer([
        //     'name'          => 'John Doe',
        //     'custom_fields' => [
        //         'email' => 'test@example.com',
        //     ],
        // ]);

        $customer = new Buyer([]);

        $client = new Party([
            'name'          => $po->contractor->name,
            'phone'         => $po->contractor->phone,
            'address'       => $po->contractor->address,
            'custom_fields' => [
                'company' => $po->contractor->company_name,
                'email' => $po->contractor->email,
            ],
            // 'custom_fields' => [
            //     'note'        => 'IDDQD',
            //     'business id' => '365#GG',
            // ],
        ]);

        $bill_to = new Party([
            'name'          => 'company name',
            // 'phone'         => $timesheet->employees->phone_number,
            'address'       => '36th Floor, Al Bidda Tower',
            'address2'       => 'Corniche Street, PO Box 5333',
            // 'custom_fields' => [
            //     'note'        => 'IDDQD',
            //     'business id' => '365#GG',
            // ],
        ]);

        $lines = array();
        // $note = InvoiceNote::first();
        $items = [];
        foreach ($po->lines as $key => $line) {
            // dd($line);
            $items[] =
                InvoiceItem::make($line->product->product_name)
                ->serviceDate(Carbon::createFromFormat('Y-m-d', $line->service_date)->format('d/m/Y'))
                ->serviceTime($line->service_time?->service_time_concat)
                ->serviceLocation($line->service_location?->title)
                ->venue($line->venue?->title)
                ->pricePerUnit($line->unit_price)
                ->quantity($line->quantity)
                ->subTotalPrice($line->line_total);

            // ->discount(3)
            // ->days_worked($line->days_worked)
            // ->leave_days_taken($line->leave_taken)
            // ->unpaid_leaves($line->unpaid_leave_taken)
            // ->total_days_eligible($line->total_days_eligible_for_payment)
            // ->daily_rate($line->daily_rate)
            // ->salary($line->salary)
            // ->payment($line->total_payment),]
        }


        $invoice = Invoice::make()->template('order-details')
            ->buyer($bill_to)
            ->seller($client)
            ->status('approved')
            ->sequence($po->id)
            ->currencyCode('QAR')
            ->currencySymbol('')
            ->orderNumber($po->order_number)
            ->orderStatus($po->status->title)
            ->event($po->event?->name)
            // ->notes($po->note_to_vendor)
            ->notes('Payment Link:	<href="https://www.qatartourism.com/en/qatartourism/qatartourism-payment-portal" target="_blank">Qatar Tourism Payment Portal</a> <br>
                    Bank Transfer: 	IBAN: QA58QNBA0000000000000000001 <br>
                    Bank Name: Qatar National Bank (QNB) <br>
                    ')
            // ->notes2($timesheet->note_2)
            ->approvedBy('myself')
            // ->paperoptions('A4', 'landscape')
            ->totalAmount($po->lines->sum('line_total'))
            // ->series(str_pad((string) $timesheet->month_selected_id, 2, 0, STR_PAD_LEFT) . '' . $timesheet->year_selected)
            ->dateFormat('d/m/Y')
            // ->sequence($timesheet->employees->id)
            ->currencyThousandsSeparator(',')
            ->filename($po->order_number)
            // ->discountByPercent(10)
            // ->taxRate(15)
            // ->shipping(1.99)
            ->addItems($items)
            ->save('private');

        return $invoice->stream();
        // return $invoice->stream();
    }

    // generate a Order PDF
    public function saveOrderPDF($id)
    {
        // Log::info('Generating PDF for Order ID: ' . $id);
        $po = OrderHeader::findOrFail($id);
        // $company = Company::all()->first();

        // $customer = new Buyer([
        //     'name'          => 'John Doe',
        //     'custom_fields' => [
        //         'email' => 'test@example.com',
        //     ],
        // ]);

        $customer = new Buyer([]);

        $client = new Party([
            'name'          => $po->contractor->name,
            'phone'         => $po->contractor->phone,
            'address'       => $po->contractor->address,
            'custom_fields' => [
                'company' => $po->contractor->company_name,
                'email' => $po->contractor->email,
            ],
            // 'custom_fields' => [
            //     'note'        => 'IDDQD',
            //     'business id' => '365#GG',
            // ],
        ]);

        $bill_to = new Party([
            'name'          => 'company name',
            // 'phone'         => $timesheet->employees->phone_number,
            'address'       => '36th Floor, Al Bidda Tower',
            'address2'       => 'Corniche Street, PO Box 5333',
            // 'custom_fields' => [
            //     'note'        => 'IDDQD',
            //     'business id' => '365#GG',
            // ],
        ]);

        $lines = array();
        // $note = InvoiceNote::first();
        $items = [];
        foreach ($po->lines as $key => $line) {
            // dd($line);
            $items[] =
                InvoiceItem::make($line->product->product_name)
                ->serviceDate(Carbon::createFromFormat('Y-m-d', $line->service_date)->format('d/m/Y'))
                ->serviceTime($line->service_time?->service_time_concat)
                ->serviceLocation($line->service_location?->title)
                ->venue($line->venue?->title)
                ->pricePerUnit($line->unit_price)
                ->quantity($line->quantity)
                ->subTotalPrice($line->line_total);

            // ->discount(3)
            // ->days_worked($line->days_worked)
            // ->leave_days_taken($line->leave_taken)
            // ->unpaid_leaves($line->unpaid_leave_taken)
            // ->total_days_eligible($line->total_days_eligible_for_payment)
            // ->daily_rate($line->daily_rate)
            // ->salary($line->salary)
            // ->payment($line->total_payment),]
        }


        $invoice = Invoice::make()->template('order-details')
            ->buyer($bill_to)
            ->seller($client)
            ->status('approved')
            ->sequence($po->id)
            ->currencyCode('QAR')
            ->currencySymbol('')
            ->orderNumber($po->order_number)
            ->orderStatus($po->status->title)
            ->event($po->event?->name)
            // ->notes($po->note_to_vendor)
            ->notes('Payment Link:	<href="https://www.qatartourism.com/en/qatartourism/qatartourism-payment-portal" target="_blank">Qatar Tourism Payment Portal</a> <br>
                    Bank Transfer: 	IBAN: QA58QNBA0000000000000000001 <br>
                    Bank Name: Qatar National Bank (QNB) <br>
                    ')
            // ->notes2($timesheet->note_2)
            ->approvedBy('myself')
            // ->paperoptions('A4', 'landscape')
            ->totalAmount($po->lines->sum('line_total'))
            // ->series(str_pad((string) $timesheet->month_selected_id, 2, 0, STR_PAD_LEFT) . '' . $timesheet->year_selected)
            ->dateFormat('d/m/Y')
            // ->sequence($timesheet->employees->id)
            ->currencyThousandsSeparator(',')
            ->filename($po->order_number)
            // ->discountByPercent(10)
            // ->taxRate(15)
            // ->shipping(1.99)
            ->addItems($items)
            ->save('private');
    }

    public function downloadQrPdf($id = null)
    {
        Log::info('OrderController::downloadQrPdf id: ' . $id);
        // $token = app(OrderTokenService::class)->encode($id, now()->addMinutes(30)); // Example: encode order ID with expiry
        // Log::info('OrderController::downloadQrPdf token: ' . $id);
        $id = app(OrderTokenService::class)->decode($id);
        Log::info('OrderController::downloadQrPdf id: ' . $id);
        $orderLine = OrderLine::findOrFail($id); // Example: get one order line
        if (!$orderLine->vouchers->count()) {
            for ($i = 0; $i < $orderLine->quantity; $i++) {
                $orderLine->vouchers()->create([
                    'order_line_id' => $orderLine->id,
                    'event_id' => $orderLine->event_id,
                    'venue_id' => $orderLine->venue_id,
                    'code' => strtoupper(Str::random(10)) . date('ymdHis') . $orderLine->id, // generate a unique code
                    'code' => Str::uuid()->toString(), // Example: "de305d54-75b4-431b-adb2-eb6b9e546014"

                ]);
            }
        }

        $orderLine->load('vouchers'); // Load the vouchers relationship

        // return view('cms.contractor.vouchers.vpdf', compact('orderLine'));
        $pdf = Pdf::loadView('cms.contractor.vouchers.vpdf', compact('orderLine'))->setPaper('a4');

        return $pdf->stream();

        // return $pdf->download('qr-codes.pdf');
    }

    public function switch($id)
    {
        if ($id) {
            if (Event::findOrFail($id)) {
                Log::info('Event ID: ' . $id);

                session()->put('EVENT_ID', $id);
                Log::info('Event ID: ' . session()->get('EVENT_ID'));
                return redirect()->route('cms.contractor.orders')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            } else {
                // return back()->with('error', 'Workspace not found.');
                return back()->with('error', 'Event not found.');
            }
        } else {
            session()->forget('EVENT_ID');
            return back()->withInput();
        }
    }

    public function pickEvent(Request $request)
    {
        if ($request->event_id) {
            Log::info('Event ID: ' . $request->event_id);
            if (Event::findOrFail($request->event_id) && !session()->has('EVENT_ID')) {
                Log::info('Inside if statement Event ID: ' . $request->event_id);

                session()->put('EVENT_ID', $request->event_id);
                Log::info('session EVENT_ID: ' . session()->get('EVENT_ID'));
                return redirect()->route('cms.contractor.orders')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            }
        }
        //  else {
        // return back()->with('error', 'Workspace not found.');
        Log::info('event_id is null');
        return redirect()->route('cms.contractor.orders')->with('error', 'Event not found.');
        // }
    }

    public function getAttachmentView($id)
    {
        // dd($id);
        $order_attachments = GlobalAttachment::where('model_id', '=', $id)
            ->where('model_name', 'ORDERS')->get();

        $view = view('cms.attachment.show', [
            'attachments' => $order_attachments,
        ])->render();


        return response()->json(['view' => $view]);
    }
}
