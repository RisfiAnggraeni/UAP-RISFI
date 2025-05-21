<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payments.index')->with('payments', $payments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enrollments = Enrollment::pluck('enroll_no', 'id');
        return view('payments.create', compact('enrollments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'paid_date' => 'required|date',
            'amount' => 'required|numeric',
            'enrollment_id' => 'required|exists:enrollments,id',
        ]);

        // Format tanggal ke format MySQL
        $paidDate = Carbon::parse($request->input('paid_date'))->format('Y-m-d H:i:s');

        // Simpan data
        Payment::create([
            'enrollment_id' => $request->input('enrollment_id'),
            'paid_date' => $paidDate,
            'amount' => $request->input('amount'),
        ]);

        return redirect('payments')->with('flash_message', 'Payment Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payments = Payment::find($id);
        return view('payments.show')->with('payments', $payments);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payments = Payment::find($id);
        $enrollments = Enrollment::pluck('enroll_no', 'id');
        return view('payments.edit', compact('payments', 'enrollments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'paid_date' => 'required|date',
            'amount' => 'required|numeric',
            'enrollment_id' => 'required|exists:enrollments,id',
        ]);

        $payments = Payment::find($id);

        // Format tanggal ke format MySQL
        $paidDate = Carbon::parse($request->input('paid_date'))->format('Y-m-d H:i:s');

        $payments->update([
            'enrollment_id' => $request->input('enrollment_id'),
            'paid_date' => $paidDate,
            'amount' => $request->input('amount'),
        ]);

        return redirect('payments')->with('flash_message', 'Payment Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Payment::destroy($id);
        return redirect('payments')->with('flash_message', 'Payment deleted!');
    }
}
