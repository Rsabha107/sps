<?php

namespace App\Http\Controllers\Sps\Customer;

use App\Http\Controllers\Controller;
use App\Mail\QrCodeMail;
use App\Models\Sps\Profile;
use App\Models\Sps\ProhibitedItem;
use App\Models\Sps\StoredItem;
use App\Services\tokenService;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $id = request()->get('id');
        $id = 8;
        $data = ['e' => 8, 'l' => 2];
        Log::info('ProfileController index called');

        $encrypted = encryptUrlSafe($data);
        Log::info('Encrypted data: ' . $encrypted);

        Log::info(request()->all());
        $prohibited_items = ProhibitedItem::all();
        // dd($prohibited_items);
        return view('sps.customer.visitor', ['prohibitedItems' => $prohibited_items, 'encrypted' => $encrypted]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'      => 'required|string|max:20',
            'email_address' => 'required|email|max:100',
            'prohibited_item_id' => 'required|array',
            'prohibited_item_id.*' => 'exists:prohibited_items,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sps.customer.visitor')->with('errors', $validator->errors());
        }

        DB::beginTransaction();

        try {
            // Create Profile
            $visitor = new Profile();
            $visitor->first_name = $request->first_name;
            $visitor->last_name = $request->last_name;
            $visitor->phone = $request->phone;
            $visitor->email_address = $request->email_address;
            $visitor->venue_id = $request->venue_id;
            $visitor->location_id = $request->location_id;
            $visitor->save();

            Log::info('Created visitor: ' . $visitor->id);

            // Handle items
            foreach ($request->prohibited_item_id as $key => $itemId) {
                $fileNameToStore = 'noimage.jpg';

                if ($request->hasFile('file_name') && isset($request->file_name[$key])) {
                    try {
                        $file = $request->file_name[$key];
                        $fileNameToStore = rand() . date('ymdHis') . $file->getClientOriginalName();

                        $destinationPath = public_path('storage/items/img/');
                        $image = Image::read($file);
                        // $image->resize(150, 150);
                        $image->resize(1024, 1024, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        // $image->save($destinationPath . $fileNameToStore);
                        $image->toJpeg(75)->save($destinationPath . $fileNameToStore);

                        if (filesize($destinationPath . $fileNameToStore) > 1024 * 1024) {
                            Log::warning('Image still larger than 1MB after compression: ' . $fileNameToStore);
                        }
                    } catch (\Throwable $fileError) {
                        Log::error('Image processing failed: ' . $fileError->getMessage());
                        // Optionally skip the item or fail the whole request
                        // continue;
                        throw $fileError;
                    }
                }

                $storedItem = new StoredItem();
                $storedItem->item_image = $fileNameToStore;
                $storedItem->item_image_path = 'restricted/img/' . $fileNameToStore;
                $storedItem->profile_id = $visitor->id;
                $storedItem->item_id = $itemId;
                $storedItem->item_description = $request->item_description[$key] ?? null;
                $storedItem->save();

                Log::info('Stored item: ' . json_encode($storedItem));
            }

            DB::commit();

            return redirect()->route('sps.customer.confirmation', ['profile' => $visitor])
                ->with('message', 'Visitor Information created!')
                ->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Visitor creation failed: ' . $e->getMessage());
            Log::debug($e);

            return redirect()->route('home')
                ->with('error', 'An error occurred while saving the visitor. Please try again.');
        }
    }

    public function storex(Request $request)
    {
        // 1. Validate incoming request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'      => 'required|string|max:20',
            'email_address' => 'required|email|max:100',
            'prohibited_item_id' => 'required|array',
            'prohibited_item_id.*' => 'exists:prohibited_items,id',
            // 'file_name' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 422);
            return redirect()->route('sps.customer.visitor')->with('errors', $validator->errors());
        }

        // 3. Create profile
        $visitor = new Profile();
        $visitor->first_name = $request->first_name;
        $visitor->last_name = $request->last_name;
        $visitor->phone = $request->phone;
        $visitor->email_address = $request->email_address;
        $visitor->venue_id = $request->venue_id;
        $visitor->location_id = $request->location_id;
        // $visitor->event_id = $request->event_id;

        $visitor->save();

        // 4. Handle items
        // $items = new StoredItem();

        Log::info('Prohibited Item IDs: ' . json_encode($request->prohibited_item_id));
        Log::info('Count Prohibited Item IDs: ' . count($request->prohibited_item_id));

        foreach ($request->prohibited_item_id as $key => $item) {
            Log::info('Processing Prohibited Item ID: ' . $item);

            if ($request->hasFile('file_name')) {

                $file = $request->file_name[$key];
                $fileNameWithExt = $file->getClientOriginalName();
                // get file name
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // get extension
                $extension = $file->getClientOriginalExtension();

                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $fileNameToStore = rand() . date('ymdHis') . $file->getClientOriginalName();  // use this

                // Log::info($fileNameWithExt);
                // Log::info($filename);
                // Log::info($extension);
                // Log::info($fileNameToStore);

                // Storage::disk('private')->putFileAs('mds/event/logo', $file, $fileNameToStore); // upload to a private disk
                $destinationPathThumbnail = public_path('storage/items/img/');
                $image = Image::read($file);
                $image->resize(150, 150);
                $image->save($destinationPathThumbnail . $fileNameToStore);
                // Storage::disk('public')->putFileAs('contractor/logo', $file, $fileNameToStore);
            } else {
                $fileNameToStore = 'noimage.jpg';
            }

            $items = new StoredItem();
            $items->item_image = $fileNameToStore;
            $items->item_image_path = 'restricted/img/' . $fileNameToStore; // store the path to the file
            $items->profile_id = $visitor->id;
            $items->item_id = $request->prohibited_item_id[$key];
            $items->item_description = $request->item_description[$key] ?? null;

            $items->save();
            Log::info('Stored Item: ' . json_encode($items));
        }

        // $items->item_quantity = $request->item_quantity;
        $notification = array(
            'message'       => 'Visitor Information created!',
            'alert-type'    => 'success'
        );

        return redirect()->route('sps.customer.confirmation', ['profile' => $visitor])->with($notification);
        // return redirect()->route('sps.customer.profile')->with($notification);

        // return response()->json(['message' => 'Profile created successfully', 'profile' => $profile], 201);
    }

    public function confirmationkk(Profile $profile)
    {
        $qrCode = QrCode::format('svg')->size(200)->margin(1)->backgroundColor(255, 255, 255)->generate($profile->ref_number);
        $qrBase64 = base64_encode($qrCode);


        //Generate QR code and store it
        $filename = 'qrcodes/profile-' . $profile->id . '-' . Str::random(6) . '.png';
        Storage::put('public/' . $filename, $qrCode);
        // Get the full path
        $filePath = storage_path('app/public/' . $filename);

        Mail::to($profile->email_address)->send(new QrCodeMail($profile, $filePath));
        return view('sps.customer.confirmation', compact('profile', 'qrBase64'));
    }

    public function confirmation(Profile $profile)
    {
        $result = Builder::create()
            ->writer(new PngWriter())           // Ensure PNG format
            ->data($profile->ref_number)                       // QR code content
            ->size(300)                         // Image size (px)
            ->margin(10)                        // Margin (quiet zone)
            ->backgroundColor(new Color(255, 255, 255)) // Background color
            ->build();

        $filename = 'qrcodes/profile-' . $profile->id . '-' . Str::random(6) . '.png';

        Storage::put('public/' . $filename, $result->getString());
        // Get the full path
        $filePath = storage_path('app/public/' . $filename);

        // $filePath = public_path('qrcodes/sps-visitor-' . $profile->id . '-' . Str::random(6) . '.png');
        // $result->saveToFile($filePath);

        Mail::to($profile->email_address)->send(new QrCodeMail($profile, $filePath));

        return view('sps.customer.confirmation', ['profile' => $profile, 'qrBase64' => base64_encode($result->getString())]);

        return response($result->getString(), 200)
            ->header('Content-Type', 'image/png');
    }

    public function save($text = 'https://example.com')
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($text)
            ->size(300)
            ->margin(10)
            ->build();

        $filePath = public_path('qrcodes/qr.png');
        $result->saveToFile($filePath);

        return "QR code saved to: /qrcodes/qr.png";
    }
}
