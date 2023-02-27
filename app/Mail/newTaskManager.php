<?php

namespace App\Mail;

use App\Models\Tasks;
use Faker\Provider\pt_BR\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use stdClass;

class newTaskManager extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    private $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(stdClass $user, stdClass $task)
    {
        $this->user = $user;
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
            to: [$this->user->email],
            from: 'marcos.marrize@gmail.com',
            subject: 'Nova Tarefa',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'Mail.newTaskManager',
            with: [
                'user' => $this->user,
                'task' => $this->task,
            ] 
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
