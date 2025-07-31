<?php

namespace App\Http\Controllers\Cms\Caterer;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewOrderEmailJob;
use App\Models\Cms\Contractor;
use App\Models\Cms\OrderHeader;
use App\Models\GeneralSettings\Company;
use App\Models\GeneralSettings\CompanyAddress;
use App\Models\Cms\Currency;
use App\Models\Cms\Event;
use App\Models\Cms\OrderLine;
use App\Models\Cms\OrderNumGen;
use App\Models\Cms\OrderStatus;
use App\Models\Cms\Product;
use App\Models\Cms\ServiceLocation;
use App\Models\Cms\ServiceTime;
use App\Models\Cms\Venue;
use App\Models\Order;
use App\Models\Procurement\PurchaseOrderLine;
use App\Models\User;
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
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderHeader::all();
        $customers = Contractor::all();
        $products = Product::all();
        $currency = Currency::all();
        $addresses = CompanyAddress::all();
        $service_times = ServiceTime::all();
        $venues = Venue::all();
        $events = Event::all();
        $order_statuses = OrderStatus::all();
        $service_locations = ServiceLocation::all();
        $user = User::findOrFail(Auth::user()->id);

        // dd($service_times);
        return view('cms.admin.orders.list', compact(
            'orders',
            'customers',
            'products',
            'currency',
            'addresses',
            'service_times',
            'venues',
            'service_locations',
            'order_statuses',
            'events',
        ));
    }  // End function index

    public function list($id = null)
    {
        $user = User::findOrFail(Auth::user()->id);
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        // dd(request()->all());

        $ops = OrderHeader::orderBy($sort, $order);

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
            $pdf_route = route("cms.admin.orders.po.pdf", $op->id);
            $pdf_download = route("cms.admin.orders.po.pdf.download", $op->id);

            $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            $profile_action =
                '<a href="' . route("cms.admin.orders.order", $op->id) . '" class="btn-table btn-sm"  data-id="' .
                $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="View Purchase Order">' .
                '<i class="fa-solid far fa-lightbulb text-warning"></i></a>';
            $actions_pdf =
                '<a href="' . $pdf_route . '" class="btn btn-sm" id="bookingDetails" target="_blank" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Purchase Order Pdf">' .
                '<i class="fa-solid fa-file-invoice text-success"></i></a>';

            $actions_download_pdf =
                '<a href="' . $pdf_download . '" class="btn btn-sm" id="bookingDetails" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Download Purchase Order Pdf">' .
                '<i class="fa-solid fa-download text-dark"></i></a>';

            $update_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="edit_purchase_offcanv" data-id=' . $op->id .
                ' data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';

            $delete_action =
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="order_table" data-id="' .
                $op->id .
                '" id="delete_purchase" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            $actions = $div_action;

            $actions = $actions . $profile_action . $actions_pdf . $actions_download_pdf . $update_action . $delete_action;

            $actions =  '<div class="btn-reveal-trigger position-static">
                          <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path></svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com --></button>
                          <div class="dropdown-menu dropdown-menu-end py-2">
                            <a class="dropdown-item" href="javascript:void(0)" id="show_order_lines" data-id="' . $op->id . '">View</a>
                            <a class="dropdown-item" href="' . $pdf_route . '" id="orderDetails" data-id="' . $op->id . '" target="_blank" data-table="order_table">Order PDF</a>
                            <a href="' . $pdf_route . '" class="btn btn-sm" id="bookingDetails" target="_blank" data-id="' . $op->id .
                '" data-table="order_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Order Pdf">' .
                '<i class="fa-solid fa-file-invoice text-success"></i> Order PDF</a>
                            <a class="dropdown-item" href="#!">Export</a>
                            <div class="dropdown-divider">
                                </div><a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>';

            $order_status =  '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $op->status->color . ' "><span class="badge-label" id="editprojectStatus" data-id="' . $op->id . '" data-table="project_table">' . $op->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>';
            $actions = $actions_pdf;
            $order_status =  '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $op->status->color . ' "><span class="badge-label" style="cursor: pointer;" id="editOrderStatus" data-id="' . $op->id . '" data-table="order_table">' . $op->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>';


            return [
                'id1' => '<div class="ms-3">' . $op->id . '</div>',
                'id' => $op->id,
                'order_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ms-3"><a href="javascript:void(0)" id="show_order_lines" data-id="' . $op->id . '">' . $op->order_number . '</a></div>',
                // 'order_number' => '<div class="align-middle white-space-wrap fw-bold fs-9 ms-3">' . $op->order_number . '</a></div>',
                'customer_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->customer?->name . '</div>',
                'event_id' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->event?->name . '</div>',
                'order_date' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . format_date($op->order_date) . '</div>',
                'total_quantity' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $total_orders->total_quantity . '</div>',
                'total_amount' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $total_orders->total_amount . '</div>',
                'status' => '<div class="align-middle white-space-wrap fw-bold fs-9">' . $op->delivery_status?->title . '</div>',
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

        $view = view('/cms/admin/orders/_order_details_modal', [
            'order' => $order,
            'lines' => $lines,
            'total_orders' => $total_orders,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function get

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
        $lines = PurchaseOrderLine::where('po_header_id', $header->id)->get();
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
        $user_id = Auth::user()->id;

        $rules = [
            // 'order_number' => ['required'],
            // 'contact_name' => ['required'],
            // 'email' => ['required', 'unique:purchase_order_headers'],
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
            return response()->json(['error' => $error, 'message' => $message,]);
        } else {

            DB::beginTransaction();

            try {
                // $head = new OrderHeader();

                $order_status_id = gerOrderStatusId('Payment Pending');

                $head = OrderHeader::create([
                    'event_id' => session()->get('EVENT_ID'),
                    // 'order_number' => $request->order_number,
                    'customer_id' => intval($request->customer_id),
                    'order_date' => Carbon::createFromFormat('d/m/Y', $request->order_date),
                    'note_to_vendor' => $request->note_to_vendor,
                    'order_status_id' => intval($order_status_id),
                    'currency_id' => intval($request->currency_id),
                    'created_by' => $user_id,
                    'updated_by' => $user_id,

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
                            'created_by' => $user_id,
                            'updated_by' => $user_id,
                        ]);

                        Log::info($data);
                        $data->save();
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
        Log::info('Generating PDF for Order ID: ' . $id);
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
            'phone'         => $po->contractor->phone_number,
            'address'       => $po->contractor->billing_address,
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


        $invoice = Invoice::make()->template('order-confirmation')
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
                        ->notes('Catering Venue Manager : Mustapha Berrebbah / Contact no.:5574 3753 <br>													
CAT Meal Order Focal Point : Hebatallah El-Sayed / Contact no. : 5519 9847	<br>												
Caterer Focal Point : Pawel Mrozek  / Contact no. :  59978152	<br>												
Payment Link:	https://www.qatartourism.com/en/qatartourism/qatartourism-payment-portal" <br>
Bank Transfer: 	IBAN: QA58QNBA0000000000000000001 <br>
Bank Name: Qatar National Bank (QNB) <br>
')
            // ->notes2($timesheet->note_2)
            ->approvedBy('myself')
            ->totalAmount($po->lines->sum('line_total'))
            // ->series(str_pad((string) $timesheet->month_selected_id, 2, 0, STR_PAD_LEFT) . '' . $timesheet->year_selected)
            ->dateFormat('d/m/Y')
            // ->sequence($timesheet->employees->id)
            ->currencyThousandsSeparator(',')
            ->filename($po->order_number)
            // ->paperOptions('A4', 'landscape')
            // ->discountByPercent(10)
            // ->taxRate(15)
            // ->shipping(1.99)
            ->addItems($items);

        return $invoice->stream();
        // return $invoice->stream();
    }

    // generate a PO
    public function downloadPurchasePDF($id)
    {
        $po = OrderHeader::findOrFail($id);
        $company = Company::all()->first();

        // $customer = new Buyer([
        //     'name'          => 'John Doe',
        //     'custom_fields' => [
        //         'email' => 'test@example.com',
        //     ],
        // ]);

        $customer = new Buyer([]);

        $client = new Party([
            'name'          => $po->vendor->name,
            'phone'         => $po->vendor->phone_number,
            'address'       => $po->vendor->billing_address,
            // 'custom_fields' => [
            //     'note'        => 'IDDQD',
            //     'business id' => '365#GG',
            // ],
        ]);

        $bill_to = new Party([
            'name'          => $company->name,
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
        foreach ($po->lines as $key => $line) {
            // dd($line);
            $items = [
                InvoiceItem::make($line->line_description)
                    ->pricePerUnit($line->unit_price)
                    ->quantity($line->quantity)
                    ->subTotalPrice($line->line_total)
            ];
            // ->discount(3)
            // ->days_worked($line->days_worked)
            // ->leave_days_taken($line->leave_taken)
            // ->unpaid_leaves($line->unpaid_leave_taken)
            // ->total_days_eligible($line->total_days_eligible_for_payment)
            // ->daily_rate($line->daily_rate)
            // ->salary($line->salary)
            // ->payment($line->total_payment),]
        }


        $invoice = Invoice::make()->template('po')
            ->buyer($bill_to)
            ->seller($client)
            ->status('approved')
            ->currencyCode('QAR')
            ->currencySymbol('')
            ->notes($po->note_to_vendor)
            // ->notes2($timesheet->note_2)
            ->approvedBy('myself')
            ->totalAmount($po->lines->sum('line_total'))
            // ->series(str_pad((string) $timesheet->month_selected_id, 2, 0, STR_PAD_LEFT) . '' . $timesheet->year_selected)
            ->dateFormat('d/m/Y')
            // ->sequence($timesheet->employees->id)
            ->currencyThousandsSeparator(',')
            ->filename($po->po_number)
            // ->discountByPercent(10)
            // ->taxRate(15)
            // ->shipping(1.99)
            ->addItems($items);

        return $invoice->download();
        // return $invoice->stream();
    }

    public function switch($id)
    {
        if ($id) {
            if (Event::findOrFail($id)) {
                Log::info('Event ID: ' . $id);

                session()->put('EVENT_ID', $id);
                Log::info('Event ID: ' . session()->get('EVENT_ID'));
                return redirect()->route('cms.admin.orders')->with('message', 'Event Switched.');
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
        // $events = MdsEvent::all();
        // $this->switch($request->event_id);
        // return view('mds.admin.booking.pick', compact('events'));
        if ($request->event_id) {
            Log::info('Event ID: ' . $request->event_id);
            if (Event::findOrFail($request->event_id) && !session()->has('EVENT_ID')) {
                Log::info('Inside if statement Event ID: ' . $request->event_id);

                session()->put('EVENT_ID', $request->event_id);
                Log::info('session EVENT_ID: ' . session()->get('EVENT_ID'));
                Log::info('before redirect');
                return redirect()->route('cms.admin.booking')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            }
        }
        //  else {
        // return back()->with('error', 'Workspace not found.');
        Log::info('event_id is null');
        return redirect()->route('cms.admin.booking')->with('error', 'Event not found.');
        // }
    }

    public function editStatus($id)
    {
        //  dd('editTaskProgress');
        $data = OrderHeader::find($id);
        //dd($data);
        $data_arr = [];

        $data_arr[] = [
            "id"        => $data->id,
            "status_id"  => $data->order_status_id,
        ];

        $response = ["retData"  => $data_arr];
        return response()->json($response);
    } // editStatus

    // update the order status and send notification
    /**
     * Update the status of the order.
     */
    public function updateStatus(Request $request)
    {

        $head = OrderHeader::findOrFail($request->id);
        $status_title = OrderStatus::findOrFail($request->status_id);

        Log::info($status_title->title);
        $head->update([
            'order_status_id' => $request->status_id,
        ]);

        $notification = array(
            'message'       => 'Order status updated successfully',
            'alert-type'    => 'success'
        );

        if ($status_title->title == 'Payment Pending') {
            $saveOrderPdf = $this->saveOrderPDF($head->id);

            $details = [
                'email' => 'rsabha@gmail.com',
                'order_ref_number' => $head->order_number,
                'filename' => $head->order_number . '.pdf',
            ];

            Log::info('BookingController::admin_email: ' . config('settings.admin_email'));
            Log::info('BookingController::store details: ' . json_encode($details));
            Log::info('BookingController::store settings.send_notifications: ' . config('settings.send_notifications'));

            if (config('settings.send_notifications')) {
                SendNewOrderEmailJob::dispatch($details);
            }
        }

        return response()->json(['error' => false, 'message' => 'Order Status updated successfully.', 'id' => $head->id]);
    } //updateStatus

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


        $invoice = Invoice::make()->template('order-confirmation')
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
                        ->notes('Catering Venue Manager : Mustapha Berrebbah / Contact no.:5574 3753 <br>													
CAT Meal Order Focal Point : Hebatallah El-Sayed / Contact no. : 5519 9847	<br>												
Caterer Focal Point : Pawel Mrozek  / Contact no. :  59978152	<br>												
Payment Link:	https://www.qatartourism.com/en/qatartourism/qatartourism-payment-portal" <br>
Bank Transfer: 	IBAN: QA58QNBA0000000000000000001 <br>
Bank Name: Qatar National Bank (QNB) <br>
')
            // ->notes2($timesheet->note_2)
            ->approvedBy('myself')
            ->totalAmount($po->lines->sum('line_total'))
            // ->series(str_pad((string) $timesheet->month_selected_id, 2, 0, STR_PAD_LEFT) . '' . $timesheet->year_selected)
            ->dateFormat('d/m/Y')
            // ->sequence($timesheet->employees->id)
            ->currencyThousandsSeparator(',')
            ->filename($po->order_number)
            // ->paperOptions('A4', 'landscape')
            // ->discountByPercent(10)
            // ->taxRate(15)
            // ->shipping(1.99)
            ->addItems($items)
            ->save('private');
        // return $invoice->stream();
    }
}
