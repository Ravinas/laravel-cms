<?php

namespace CMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EbulletinMail extends Mailable
{
    use Queueable, SerializesModels;
    private $ebulletin;
    private $config;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ebulletin, $type)
    {
        $this->ebulletin = $ebulletin;
        $this->config = [
            "activation" => [
                "subject" => trans('cms::ebulletin.activation_mail_subject',['name' => env('APP_NAME')]),
                "view" => "panel.ebulletin.mail_activation"
            ],

            "activated" => [
                "subject" => trans('cms::ebulletin.activated_mail_subject',['name' => env('APP_NAME')]),
                "view" => "panel.ebulletin.mail_activated"
            ],

            "cancelled" => [
                "subject" => trans('cms::ebulletin.cancelled_mail_subject',['name' => env('APP_NAME')]),
                "view" => "panel.ebulletin.mail_cancelled"
            ]
        ];

        $this->config = $this->config[$type];

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->ebulletin;
        return $this->from(env('EBULLETIN_FROM_ADDRESS'),env('EBULLETIN_FROM_NAME'))
            ->subject($this->config["subject"])
            ->view($this->config["view"],['data' => $data]);
    }
}
