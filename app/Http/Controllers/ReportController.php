<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    public function report1($pid)
    {
        $payment = Payment::with('enrollment.student', 'enrollment.batch')->find($pid);
    
        if (!$payment) {
            abort(404, 'Payment not found');
        }
    
      
        $enrollment = $payment->enrollment;
        $student = $enrollment?->student;
        $batch = $enrollment?->batch;
    
        $pdf = App::make('dompdf.wrapper');
    
        $print = "<div style='margin:20px; padding: 20px;'>";
        $print .= "<h1 align='center'>Payment Receipt</h1>";
        $print .= "<hr/>";
        $print .= "<p>Receipt No: <b>" . $pid . "</b></p>";
        $print .= "<p>Date: <b>" . ($payment->paid_date ?? 'N/A') . "</b></p>";
        $print .= "<p>Enrollment No: <b>" . ($enrollment?->enroll_no ?? 'N/A') . "</b></p>";
        $print .= "<p>Student Name: <b>" . ($student?->name ?? 'N/A') . "</b></p>";
        $print .= "<hr/>";
        $print .= "<table style='width: 100%;'>";
        $print .= "<tr><td>Batch</td><td>Amount</td></tr>";
        $print .= "<tr>";
        $print .= "<td><h3>" . ($batch?->name ?? 'N/A') . "</h3></td>";
        $print .= "<td><h3>" . ($payment->amount ?? '0') . "</h3></td>";
        $print .= "</tr>";
        $print .= "</table>";
        $print .= "<hr/>";
        $print .= "<span>Printed Date: <b>" . date('Y-m-d') . "</b></span>";
        $print .= "</div>";
    
        $pdf->loadHTML($print);
        return $pdf->stream();
    }    
}
