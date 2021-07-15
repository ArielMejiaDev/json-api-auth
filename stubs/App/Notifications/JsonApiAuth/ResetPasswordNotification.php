<?php

namespace App\Notifications\JsonApiAuth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Validation\ValidationException;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->getNotificationEndpoint($notifiable);
        return $this->buildMailMessage($url);
    }

    /**
     * Here the method guess your frontend endpoint to show a form to update the user password.
     * @param $notifiable
     * @return string
     * @throws ValidationException
     */
    public function getNotificationEndpoint($notifiable)
    {
        if(! $endpoint = config('json-api-auth.new_password_form_url')) {
            throw ValidationException::withMessages([
                'message' => 'There is no domain set in config/json-api-sanctum.php as new_password_form_url, please add a frontend endpoint to send email with the link.'
            ]);
        }
        return $endpoint . "?token={$this->token}&email={$notifiable->getEmailForPasswordReset()}";
    }
}
