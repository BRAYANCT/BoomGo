<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserRegisterNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this-> password = $data['password'];
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
        $line = "Se ha registrado un nuevo usuario en nuestra plataforma con su correo electrónico, sus credenciales son:<br>";
        $line .= '<b>Usuario</b>: '.$notifiable-> username.'<br>';
        $line .= '<b>Password</b>: '.$this-> password."<br><br>";
        $line .= 'Puede ingresar a nuestra plataforma presionando el siguiente botón:';

        $routeLogin = route('login');

        return (new MailMessage)
                ->level('secondary-custom')  //parametro para el color del boton
                ->subject('Registro de usuario en Boom Go')
                ->greeting('Hola '.$notifiable-> first_name.",")
                ->line(new HtmlString($line))
                ->action('Login', $routeLogin)
                ->line('Gracias por usar nuestra aplicación!');
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
