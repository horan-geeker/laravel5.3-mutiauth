<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $level;
    protected $intros;
    protected $outros;
    protected $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($level, $intros, $outros=['感谢您对我们的支持，此邮件请勿回复'], $subject='河马工作室通知您')
    {
        $this->level = $level;
        $this->intros = $intros;
        $this->outros = $outros;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.notify')->with([
            'level' => $this->level,
            'introLines' => $this->intros,
            'outroLines' => $this->outros,
        ])->subject($this->subject);
    }
}
