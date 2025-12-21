<?php

namespace App\Mail;

use App\Models\CourseApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ForwardCourseApplicationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $emailSubject;
    public $emailMessage;
    public $applicantName;
    public $courseTitle;

    /**
     * Create a new message instance.
     *
     * @param CourseApplication $application
     * @param string $subject
     * @param string $message
     */
    public function __construct(CourseApplication $application, string $subject, string $message)
    {
        $this->application = $application;
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
        $this->applicantName = $application->name;
        $this->courseTitle = $application->course->title;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name')
            ),
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.forward-course-application',
            with: [
                'applicantName' => $this->applicantName,
                'messageContent' => $this->emailMessage,
                'courseTitle' => $this->courseTitle,
                'application' => $this->application,
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
