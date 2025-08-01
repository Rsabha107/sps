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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        // Log::info('ProfileController index called @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@');
        // $id = request()->get('id');
        // $id = 8;
        $data = ['e' => 8, 'v' => 8, 'l' => 12];
        // $url = URL::signedRoute('spectator', $data);
        // Log::info('Generated URL: ' . $url);

        // Log::info('ProfileController index called');

        // Log::info(request()->all());
        // Log::info('Decrypted data: ' . decryptUrlSafe(request()->all()));
        // $request = request();
        // $request->merge($data);

        // $encrypted = encryptUrlSafe($data);
        // Log::info('Encrypted data: ' . $encrypted);

        $shortEnc = superShortEncrypt($data);
        // Log::info('Short encrypted data: ' . $shortEnc);

        // $prohibited_items = ProhibitedItem::all();
        $signedUrl = URL::temporarySignedRoute(
            'spectator',
            now()->addMinutes(5),
            ['data' => $shortEnc]
        );
        // dd($prohibited_items);
        return redirect($signedUrl);
        // return redirect()->route('spectator', ['prohibitedItems' => $prohibited_items, 'data' => $data]);
        // return view('sps.customer.visitor', ['prohibitedItems' => $prohibited_items, 'data' => $data]);
    }

    public function spectator()
    {
        $all_data = request()->all();
        // Log::info('ProfileController spectator called ****************************************');
        // Log::info('Request data: ' . json_encode($all_data));
        if (!request()->has('data')) {
            // Log::error('No data provided in request');
            return redirect()->route('index')->with('error', 'No data provided');
        }

        // Decrypt the data
        try {
            $decrypted = superShortDecrypt(request('data'));
            // Log::info('Decrypted data: ' . json_encode($decrypted));
        } catch (\Exception $e) {
            // Log::error('Decryption failed: ' . $e->getMessage());
            return redirect()->route('index')->with('error', 'Invalid data provided');
        }
        // $data = request('data');

        // Log::info('ProfileController spectator called');
        // Log::info('Encrypted data: ' . json_encode($data));
        // $decrypted = superShortDecrypt($data);
        $prohibited_items = ProhibitedItem::all();
        return view('sps.customer.visitor', ['prohibitedItems' => $prohibited_items, 'data' => $decrypted]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'venue_id' => 'required|exists:venues,id',
            'location_id' => 'required|exists:locations,id',
            'event_id' => 'required|exists:events,id',
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
            $visitor->event_id = $request->event_id;

            $visitor->save();

            // Log::info('Created visitor: ' . $visitor->id);

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

            $payload = Crypt::encrypt($visitor->id);
            // $profile = base64_encode($payload);
            return redirect()->route('sps.customer.confirmation', ['token' => $payload])
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

    public function confirmation($token)
    {

        Log::info('ProfileController confirmation called');
        $id = Crypt::decrypt($token);
        // Log::info('Decrypted profile: ' . json_encode($id));

        $profile = Profile::find($id);
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
