<?php

namespace App\Http\Controllers\Cms\Setting;

use App\Http\Controllers\Controller;
use App\Models\GlobalStatus;
use App\Models\Mds\GlobalYN;
use App\Models\Cms\Contractor;
use App\Models\Cms\Currency;
use App\Models\Cms\Event;
use App\Models\Cms\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use App\Enums\CompanyType;

class ContractorController extends Controller
{
    //
    public function index()
    {
        $contractors = Contractor::all();
        $venues = Venue::all();
        $currencies = Currency::all();
        $events = Event::all();
        $company_types = CompanyType::cases();
        // dd($events);
        return view('cms.setting.contractor.list', compact('contractors', 'venues', 'currencies', 'events', 'company_types'));
    }

    public function get($id)
    {
        $op = Contractor::findOrFail($id);
        return response()->json(['op' => $op, 'venues' => $op->venues, 'events' => $op->events,]);
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $ops = Contractor::orderBy($sort, $order);

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $ops->count();
        $ops = $ops->paginate(request("limit"))->through(function ($op) {

            // if ($op->event_logo) {
            //     $route_image = route('mds.setting.contractor.file', $op->event_logo);
            //     $image = ' <div class="avatar avatar-m">
            //                     <a  href="#" role="button" id="editContractors" data-id=' . $op->id . ' data-table="event_table">
            //                         <img class="rounded-circle pull-up" src="' . $route_image . '" alt="" />
            //                     </a>
            //                 </div>';
            // } else {
            //     $image = '  <div class="avatar avatar-m  me-1" >
            //                     <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="#" role="button" id="editContractors" data-id=' . $op->id . ' data-table="event_table">
            //                         <div class="avatar avatar-m  rounded-circle pull-up">
            //                             <div class="avatar-name rounded-circle me-2"><span>' . generateInitials($op->name) . '</span></div>
            //                         </div>
            //                     </a>
            //                 </div>';
            // }

            $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            $update_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="editContractors" data-id=' . $op->id .
                ' data-table="contractor_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
            $delete_action =
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="contractor_table" data-id="' .
                $op->id .
                '" id="deleteContractor" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';


            // $actions = $div_action . $profile_action;
            $venues_display = '';
            foreach ($op->venues as $venue) {
                $venues_display .= '<div class="white-space-wrap"><span class="badge badge-pill bg-body-tertiary">' . $venue->short_name . '</span></div> ';
            }

            $events_display = '';
            foreach ($op->events as $event) {
                $events_display .= '<div class="white-space-wrap"><span class="badge badge-pill bg-body-tertiary">' . $event->name . '</span></div> ';
            }

            return  [
                'id' => $op->id,
                'image' => $op->image,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' .$op->id. '</div>',
                'name' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->name . '</div>',
                'email' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->email . '</div>',
                'address' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->address . '</div>',
                'phone' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->phone . '</div>',
                'company_name' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->company_name . '</div>',
                'company_type' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->company_type . '</div>',
                'currency_id' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->currency?->name . '</div>',
                'status' => '<span class="badge badge-phoenix fs--2 align-middle white-space-wrap ms-1 badge-phoenix-' . $op->status?->color . ' " style="cursor: pointer;" id="editDriverStatus" data-id="' . $op->id . '" data-table="drivers_table"><span class="badge-label">' . $op->status?->name . '</span><span class="ms-1 uil-edit-alt" style="height:12.8px;width:12.8px;cursor: pointer;"></span></span>',
                // 'event_id' => '<div class="align-middle white-space-wrap fs-9 ps-1">' . $op->event?->name . '</div>',
                'events' => $events_display,
                'venues' => $venues_display,
                'actions' => $update_action . $delete_action,
                'created_at' => format_date($op->created_at,  'H:i:s'),
                'updated_at' => format_date($op->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $ops->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = new Contractor();

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {

            Log::info($request->all());
            if ($request->hasFile('file_name')) {

                $file = $request->file('file_name');
                $fileNameWithExt = $request->file('file_name')->getClientOriginalName();
                // get file name
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // get extension
                $extension = $request->file('file_name')->getClientOriginalExtension();

                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $fileNameToStore = rand() . date('ymdHis') . $file->getClientOriginalName();  // use this

                // Log::info($fileNameWithExt);
                // Log::info($filename);
                // Log::info($extension);
                // Log::info($fileNameToStore);

                // Storage::disk('private')->putFileAs('mds/event/logo', $file, $fileNameToStore); // upload to a private disk
                $destinationPathThumbnail = public_path('storage/contractor/logo/');
                $image = Image::read($request->file('file_name'));
                $image->resize(150, 150);
                $image->save($destinationPathThumbnail . $fileNameToStore);
                // Storage::disk('public')->putFileAs('contractor/logo', $file, $fileNameToStore);
            } else {
                $fileNameToStore = 'noimage.jpg';
            }

            $op->image = $fileNameToStore;

            $error = false;
            $message = 'Contractor created succesfully.' . $op->id;

            $op->name = $request->name;
            $op->email = $request->email;
            $op->address = $request->address;
            $op->phone = $request->phone;
            // $op->event_id = $request->event_id;
            $op->company_name = $request->company_name;
            $op->company_type = $request->company_type;
            $op->currency_id = $request->currency_id;
            $op->active_flag = 1;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();

            if ($request->venue_id) {
                foreach ($request->venue_id as $key => $data) {
                    $op->venues()->attach($request->venue_id[$key]);
                }
            }
            if ($request->event_id) {
                foreach ($request->event_id as $key => $data) {
                    $op->events()->attach($request->event_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Contractor created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => ['required'],
            'name' => 'required',
            'active_flag' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Log::info($validator->errors());
            $error = true;
            // $message = 'Employee not create.' . $op->id;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {
            $op = Contractor::findOrFail($request->id);

            $error = false;
            $message = 'Contractor ' . $op->name . ' successfully updated';

            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $fileNameWithExt = $request->file('file_name')->getClientOriginalName();
                // get file name
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // get extension
                $extension = $request->file('file_name')->getClientOriginalExtension();

                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $fileNameToStore = rand() . date('ymdHis') . $file->getClientOriginalName();  // use this

                Storage::disk('public')->delete('contractor/logo/' . $op->image);
                // $path = $request->file('file_name')->storeAs('private/mds/event/logo', $fileNameToStore);
                $destinationPathThumbnail = public_path('storage/contractor/logo/');
                $image = Image::read($request->file('file_name'));
                $image->resize(150, 150);
                $image->save($destinationPathThumbnail . $fileNameToStore);

                // Storage::disk('public')->putFileAs('contractor/logo', $file, $fileNameToStore);

                // $path = $file->move('upload/profile_images/', $fileNameToStore);
                // Log::info($path);
                $op->image = $fileNameToStore;
            }

            $op->name = $request->name;
            $op->email = $request->email;
            $op->address = $request->address;
            $op->phone = $request->phone;
            // $op->event_id = $request->event_id;
            $op->company_name = $request->company_name;
            $op->company_type = $request->company_type;
            $op->currency_id = $request->currency_id;
            $op->active_flag = $request->active_flag;
            $op->updated_by = Auth::user()->id;

            $op->save();

            if ($op->venues) {
                $op->venues()->detach();
            }
            if ($request->venue_id) {
                foreach ($request->venue_id as $key => $data) {
                    $op->venues()->attach($request->venue_id[$key]);
                }
            }

            if ($op->events) {
                $op->events()->detach();
            }
            if ($request->event_id) {
                foreach ($request->event_id as $key => $data) {
                    $op->events()->attach($request->event_id[$key]);
                }
            }
        }

        return response()->json([
            'error' => $error,
            'message' => $message,
        ]);
    }

    public function delete($id)
    {
        $op = Contractor::findOrFail($id);

        if ($op->image && Storage::disk('public')->exists('storage/contractor/logo/' . $op->image)) {
            Storage::disk('public')->delete('storage/contractor/logo/' . $op->image);
        }
        if ($op->venues) {
            $op->venues()->detach();
        }
        if ($op->events) {
            $op->events()->detach();
        }

        $op->delete();

        $error = false;
        $message = 'Contractor deleted succesfully.';

        $notification = array(
            'message'       => 'Contractor deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    } // delete

    public function getAssicatedVenues($id)
    {
        $events = Event::with('venues')->find($id);
        // $functional_areas = $parkingMaster->functional_areas;

        return response()->json([
            'venues' => $events->venues,
        ]);
        // return response()->json(['associated_fa' => $functional_areas]);
    }  // End function getAssicatedFunctionalAreas
    // public function getPrivateFile($file)
    // {
    //     $file_path = 'app/private/mds/event/logo/' . $file;
    //     $path = storage_path($file_path);

    //     Log::info('path: ' . $path);

    //     return response()->file($path);
    // }

    // public function getContractorView($id)
    // {
    //     $event = Contractor::find($id);
    //     $global_yn = GlobalYN::all();
    //     $global_status = GlobalStatus::all();

    //     $file_path = 'app/private/mds/event/logo/';

    //     $file_path = $file_path . $event->event_logo;
    //     $path = storage_path($file_path);

    //     // $url = Storage::disk('private')->temporaryUrl($path, now()->addMinutes(10));

    //     // $file_path = 'mds/event/logo/' . $event->event_logo;

    //     if (Storage::disk('private')->exists($file_path)) {
    //         $event_logo = Storage::url($file_path);
    //     } else {
    //         $event_logo = Storage::url('/app/private/mds/event/logo/noimage.jpg');
    //     }

    //     // Log::info($url);
    //     Log::info('path: ' . $event_logo);
    //     Log::info('path: ' . $path);

    //     // return response()->file($path);
    //     // Log::info(response()->file('/app/private/mds/event/logo/'.$event->event_logo));

    //     $view = view('/cms/setting/event/mv/edit', [
    //         'event' => $event,
    //         'globalYn' => $global_yn,
    //         'globalStatus' => $global_status,
    //         'event_logo' => $path,
    //     ])->render();

    //     return response()->json(['view' => $view]);
    // }  // End function getProjectView

}
