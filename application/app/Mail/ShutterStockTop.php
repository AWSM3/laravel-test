<?php
declare(strict_types=1);

/** @namespace */
namespace App\Mail;

/** @uses */
use App\Mail\DTO\RecipientsList;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ShutterStockTop
 * @package App\Mail
 */
class ShutterStockTop extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    private $email;
    /** @var array */
    private $images;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param array  $images
     */
    public function __construct(string $email, array $images)
    {
        $this->images = $images;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->email)
            ->markdown('emails.shutterstock-top-md')
            ->with('images', $this->images);
    }
}
