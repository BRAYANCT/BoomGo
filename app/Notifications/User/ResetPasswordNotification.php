<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

   /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $routePasswordReset = route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]);

        return (new MailMessage)
            ->level('secondary-custom')
            ->subject(Lang::getFromJson('Notificación de restablecimiento de contraseña'))
            ->greeting('Hola '.$notifiable-> first_name.",")
            ->line(Lang::getFromJson('Le enviamos este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.'))
            ->action(Lang::getFromJson('Restablecer la contraseña'), $routePasswordReset )
            ->line(Lang::getFromJson('Este enlace de restablecimiento de contraseña caducará en :count minutos.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::getFromJson('Si no solicitó un restablecimiento de contraseña, no necesita realizar acción alguna.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
