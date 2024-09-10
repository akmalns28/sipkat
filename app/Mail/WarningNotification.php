<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarningNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $idSpantau;
    public $mukaAirTanah;
    public $totalDissolveSolid;
    public $dayaHantarListrik;
    public $kondisi;
    public $createdAt;

    /**
     * Create a new message instance.
     */
    public function __construct($idSpantau, $mukaAirTanah, $totalDissolveSolid, $dayaHantarListrik, $kondisi, $createdAt)
    {
        $this->idSpantau = $idSpantau;
        $this->mukaAirTanah = $mukaAirTanah;
        $this->totalDissolveSolid = $totalDissolveSolid;
        $this->dayaHantarListrik = $dayaHantarListrik;
        $this->kondisi = $kondisi;
        $this->createdAt = $createdAt;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Warning Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.warning-notification',
            with: [
                'idSpantau' => $this->idSpantau,
                'mukaAirTanah' => $this->mukaAirTanah,
                'totalDissolveSolid' => $this->totalDissolveSolid,
                'dayaHantarListrik' => $this->dayaHantarListrik,
                'kondisi' => $this->kondisi,
                'createdAt' => $this->createdAt,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
