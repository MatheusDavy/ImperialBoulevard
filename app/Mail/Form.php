<?php

namespace App\Mail;

use App\Models\Adm\CompaniesModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class Form extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    private $fromName;

    private $fromEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data, $subject, $from)
    {
        $empresa = CompaniesModel::first();
        Config::set(['MAIL_MAILER' => 'smtp']);
        Config::set(['MAIL_HOST' => $empresa->mail_host]);
        Config::set(['MAIL_PORT' => $empresa->mail_port]);
        Config::set(['MAIL_USERNAME' => $empresa->mail_user]);
        Config::set(['MAIL_PASSWORD' => $empresa->mail_pass]);
        Config::set(['MAIL_ENCRYPTION' => 'tls']);
        Config::set(['MAIL_FROM_ADDRESS' => $empresa->mail_from]);
        Config::set(['MAIL_FROM_NAME' => $from]);

        array_unshift($data, 'Seus dados:');
        array_unshift($data, 'Obrigado por entrar em contato conosco!');
        $this->fromEmail = $empresa->mail_from;
        $this->fromName = $from;
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
    * Get the message envelope.
    *
    * @return \Illuminate\Mail\Mailables\Envelope
    */
    public function envelope()
    {
        return new Envelope(
            from: new Address($this->fromEmail, $this->fromName),
            subject: $this->subject,
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.mail.html.message', ['body' => $this->data, 'level' => ''])
        ->markdown('vendor.mail.text.message');
    }
}
