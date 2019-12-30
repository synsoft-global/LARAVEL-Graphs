<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerCSVMail extends Mailable
{
    use Queueable, SerializesModels;
     public $filename;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
         $this->filename = $filename;
        //
       // $this->path = public_path() . '\customer\customers.csv';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $file = storage_path($this->filename);
        return $this->view('email.customer_export')->attach(storage_path('app/'.$this->filename), [
                    'as' => 'customer.csv',
                    'mime' => 'application/csv',
                ]);
    } 
}
