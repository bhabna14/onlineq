<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data['booking_details'] = BookingDetail::with('booking.bookingType','idProof')
                // ->whereHas('booking', fn ($query) =>
                //     $query->where('booking_date', now()->format('Y-m-d'))
                // )
                ->latest()
                ->get();
            return view('admin.bookings.index', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function view($id)
    {
        try {
            $data['history'] = BookingDetail::where([
                    'booking_id' => Crypt::decrypt($id),
                    'is_attendant' => 0
                ])
                ->with('booking.bookingType', 'idProof')
                ->first();
            $data['attendant'] = BookingDetail::where([
                    'booking_id' => Crypt::decrypt($id),
                    'is_attendant' => 1
                ])
                ->with('booking.bookingType', 'idProof')
                ->get();
            return view('admin.bookings.view', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function searchBooking(Request $request){
        try {
            $book_id = Booking::whereBetween('booking_date',[$request->fdate,$request->tdate])->pluck('booking_id')->toArray();
            $details = BookingDetail::with('booking','booking.bookingType','idProof')
            ->whereIn('booking_id',$book_id)
            ->get();
            foreach($details as $d){
                $data['details'][]=array(
                    'booking_date'=>date('d-m-Y',strtotime($d->created_at)),
                    'darshan_date'=>date('d-m-Y',strtotime($d->booking->booking_date)),
                    'full_name'=>$d->full_name,
                    'phone'=>$d->phone,
                    'age'=>$d->age,
                    'gender'=>$d->gender,
                    'id_proof'=>$d->idProof->id_proof,
                    'id_number'=>$d->id_number,
                    'disable_certificate'=>$d->disable_certificate,
                    'booking_id'=>Crypt::encrypt($d->booking_id),
                );
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
