<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\BookingRequest;
use App\Http\Requests\Booking\CancelBookingRequest;
use App\Http\Requests\Booking\GetBookingSlotRequest;
use App\Http\Requests\Booking\SpecialBookingRequest;
use App\Models\BlockedDate;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingType;
use App\Models\IdProofType;
use App\Models\Relation;
use App\Models\UserMeta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('booking.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function specialBooking()
    {
        try {

            $booking_type = BookingType::where('booking_type_id', 1)->firstOrFail();

            $blocked_dates = BlockedDate::where(['is_active' => 1, 'is_deleted' => 0])->get();

            $data['blocked_dates'] = [];

            foreach ($blocked_dates as $blocked_date) {
                $data['blocked_dates'][] = Carbon::parse($blocked_date->blocked_date)->format('d-m-Y');
            }

            $dates = CarbonPeriod::create(now()->addDays(5), now()->addDays(11));

            $data['available_dates'] = [];

            foreach ($dates as $date) {
                $dt = Carbon::parse($date->format('Y-m-d'));

                if (!in_array(date('d-m-Y', strtotime($dt)), $data['blocked_dates'])) {
                    $count = Booking::where('booking_date', $dt)
                        ->where('booking_type_id', 1)->count();

                    $dt->shiftTimezone('utc');
                    if ($booking_type && ($booking_type->booking_number - $count > 0)) {
                        $data['available_dates'][] = [
                            'timestamp' => $dt->getTimestampMs(),
                            'available' => true
                        ];
                    } else {
                        $data['available_dates'][] = [
                            'timestamp' => $dt->getTimestampMs(),
                            'available' => false
                        ];
                    }
                }
            }

            $data['blocked_dates'] = json_encode($data['blocked_dates']);
            $data['available_dates'] = json_encode($data['available_dates']);
            $data['user_details'] = UserMeta::with('user')->where('user_id', auth()->id())->first();
            $data['id_proof'] = IdProofType::where(['is_active' => 1, 'is_deleted' => 0])->get();
            $data['proof'] = IdProofType::where(['is_active' => 1, 'is_deleted' => 0])->get();
            $data['relation'] = Relation::where(['is_active' => 1, 'is_deleted' => 0])->get();
            $data['age'] = Carbon::parse($data['user_details']->user_dob)->age;
            return view('booking.special', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialBookingRequest $request)
    {
        try {

            $booking_detail = BookingDetail::whereIsAttendant(0)
                ->where('phone', $request->phone[0])
                ->orWhere('id_number', $request->id_number[0])
                ->with('booking')
                ->whereHas('booking', function ($query) use ($request) {
                    $query->where($request->safe(['booking_type_id']))
                        ->whereBetween('booking_date', [
                            now()->subMonth(2)->format('Y-m-d'),
                            now()->format('Y-m-d')
                        ]);
                })
                ->get()
                ->pluck('booking')
                ->sortByDesc('booking_date')
                ->first();

            if ($booking_detail) {
                session()->flash('ErrorToastr', __('You have made a booking within the last two months. Please try again after two months from your previous booking date. Thank you.'));
                return 'success';
            }

            DB::beginTransaction();
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'booking_date' => date('Y-m-d', strtotime($request->booking_date)),
                'booking_type_id' => $request->booking_type_id,
                'created_by' => auth()->id(),
            ]);

            /** disable certificate */
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $name = 'disable_certificate_' . time() . '_' . rand(0000, 9999) . '.' . $file->extension();

                $path = public_path(config('app.name'));
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }
                $file->move($path, $name);
                $request['disable_certificate'] = $name;
            }

            /** Full Photograph */
            if ($request->hasfile('image')) {
                $image_file = $request->file('image');
                $image_name = 'full_image' . time() . '_' . rand(0000, 9999) . '.' . $image_file->extension();

                $image_path = public_path(config('app.name'));
                if (!File::exists($image_path)) {
                    File::makeDirectory($image_path, 0755, true);
                }
                $image_file->move($image_path, $image_name);
                $request['full_image'] = $image_name;
            }

            foreach ($request->full_name as $key => $val) {
                $data = [
                    'booking_id' => $booking->booking_id,
                    'full_name' => $request->full_name[$key],
                    'age' => $request->age[$key],
                    'gender' => $request->gender[$key],
                    'id_proof_type_id' => $request->id_proof_type_id[$key],
                    'id_number' => $request->id_number[$key],
                    'phone' => $request->phone[$key],
                    'created_by' => auth()->id(),
                ];

                if ($key == 0) {
                    $data['disable_certificate'] = $request->disable_certificate;
                    $data['full_image'] = $request->full_image;
                }

                if ($key > 0) {
                    $data['relation_id'] = $request->relation_id[$key - 1];
                    $data['is_attendant'] = 1;
                }

                BookingDetail::create($data);
            }
            DB::commit();
            session()->flash('SuccessToastr', 'Booking Successfull.');

            return response()->json([
                'status' => 'success',
                'message' => 'Booking Successfull.',
                'url' => route('dashboard'),
            ], 200);
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function storeBooking(BookingRequest $request)
    {
        try {

            DB::beginTransaction();
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'booking_date' => date('Y-m-d', strtotime($request->booking_date)),
                'booking_type_id' => $request->booking_type_id,
                'created_by' => auth()->id(),
            ]);

            $count = count($request->full_name);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $data = [
                        'booking_id' => $booking->booking_id,
                        'full_name' => $request->full_name[$i],
                        'age' => $request->age[$i],
                        'gender' => $request->gender[$i],
                        'id_proof' => $request->id_proof[$i],
                        'id_number' => $request->id_number[$i],
                        'phone' => $request->phone[$i],
                        'created_by' => auth()->id(),
                    ];
                    BookingDetail::insert($data);
                }
            }
            DB::commit();
            return response()->json('success');
            // session()->flash('SuccessToastr', 'Booking Successfull.');
            // return redirect()->route('dashboard');
            // return 'success';

            // session()->flash('SuccessToastr', 'Booking Successfull.');
            // return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAvailableSlot(GetBookingSlotRequest $request)
    {
        try {

            $booking_type = BookingType::where('booking_type_slug', $request->slug)->firstOrFail();

            $count = Booking::where(
                    'booking_date',
                    date('Y-m-d', strtotime($request->date))
                )
                ->where('booking_type_id', $booking_type->booking_type_id)
                ->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Available slots fetched successfully',
                'data' => [
                    'available_slots' => $booking_type ? $booking_type->booking_number - $count : 0
                ]
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function payment()
    {
        return view('booking.payment');
    }

    public function pdf(Request $request)
    {
        try {
            $pdf = Pdf::loadView('pdf.booking');
            return $pdf->stream('booking.pdf');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cancelBooking(CancelBookingRequest $request){
        try {
            $book_id = Crypt::decrypt($request->booking_id);

            Booking::where('booking_id', $book_id)->update(array_merge(
                    $request->validated(),
                    ['updated_by'=>auth()->id(),'is_cancelled'=>1]
                )
            );
            session()->flash('SuccessToastr', 'Booking cancelled successfully');
            return "success";
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
