<?php

namespace App\Mail;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\ThrottlesExceptions;

class NewAssignmentNotification extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  public $tries = 3;
  public $backoff = 60;
  public $assignment;


  /**
   * Create a new message instance.
   */
  public function __construct(Assignment $assignment)
  {
    $this->assignment = $assignment;
    $this->assignment->load('course');
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Tugas Baru di Mata Kuliah: ' . $this->assignment->course->name,
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.new_assignment',
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
