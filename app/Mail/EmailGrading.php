<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailGrading extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        Carbon::setLocale('id');
        $today = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        $yesterday = strtoupper(Carbon::now()->subDay()->isoFormat('dddd, D MMMM YYYY'));
        $pdfUrl1 = 'https://srs-ssms.com/grading_ai/rekap_pdf_grading_total/Rekap Grading Total AI SKM ' . $yesterday . '.pdf';
        $pdfUrl2 = 'https://srs-ssms.com/grading_ai/rekap_pdf_grading_total/Rekap Grading Total AI SCM ' . $yesterday . '.pdf';


        $subject = 'Laporan Hasil Grading TBS Secara Total menggunakan AI - ' . $yesterday;
        return $this->view('emailLayout', ['yesterday' => $yesterday])->subject($subject)->attach($pdfUrl1)->attach($pdfUrl2);
    }
}
