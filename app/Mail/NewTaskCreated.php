<?php

namespace App\Mail;

use App\Models\Tasks\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use DateTime;

class NewTaskCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Добавлена новая задача',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {

        //перевод в локальный часовой пояс
        $utcTime = new DateTime($this->task->deadline_at);
        $this->task->deadline_at = $utcTime->setTimezone(timezone_open('Europe/Moscow'))->format('Y-m-d H:i'); // перевод МСК часовой пояс
        $utcTime = new DateTime($this->task->created_at);
        $this->task->created_at = $utcTime->setTimezone(timezone_open('Europe/Moscow'))->format('Y-m-d H:i'); // перевод МСК часовой пояс

        return new Content(
            view: 'emails.tasks.created',
            with: [
                'id' => $this->task->id,
                'name' => $this->task->responsible->name,
                'email' => $this->task->responsible->email,
                'created_at' => $this->task->created_at,
                'description' => $this->task->description,
                'priority' => $this->task->priority->name,
                'deadline_at' => $this->task->deadline_at,
                'author' => $this->task->author->name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            // Attachment::fromStorageDisk('public', $this->task->documents[0]->path)
            //  ->as($this->task->documents[0]->short_description.'.pdf')
            // ->withMime('application/pdf'),
        ];
    }
}
