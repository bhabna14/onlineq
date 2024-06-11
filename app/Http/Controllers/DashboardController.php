<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $book_id = Booking::where('user_id', auth()->id())->pluck('booking_id')->toArray();
            $data['details'] = BookingDetail::with('booking','booking.bookingType','idProof')
            ->where(['booking_id'=>$book_id,'is_attendant'=>0])
            ->get();
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die();
            return view('dashboard',$data);
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
    public function store(Request $request)
    {
        //
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


    public function viewHistory($id){
        try {
            $data['history'] = BookingDetail::with('idProof','booking','booking.bookingType',)
            ->where('booking_id', Crypt::decrypt($id))
            ->first();
            $data['attendant'] = BookingDetail::with('booking','booking.bookingType','idProof')
            ->where(['booking_id'=> Crypt::decrypt($id),'is_attendant'=>1])
            ->get();
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die();
            return view('booking-status-new',$data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
