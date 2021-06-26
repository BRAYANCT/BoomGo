<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CRUD Language Lines
    |--------------------------------------------------------------------------
    |
    | La siguiente libreria guarda los mensajes del crud
    | Se guardan mensajes generales del crud y específicos de cada modelo
    |
    */

    'list_success' => 'Se obtuvieron los datos de forma exitosamente.',
    'store_success' => 'Se registraron los datos exitosamente.',
    'update_success' => 'Se actualizaron los datos exitosamente.',
    'show_success' => 'Se obtuvieron los datos exitosamente.',
    'edit_success' => 'Se cargaron los datos exitosamente.',
    'delete_success' => 'Se eliminó el registro de forma exitosa.',
    'destroy_success' => 'Se eliminaron los registros de forma exitosamente.',

    'list_error' => 'Problema al obtener los datos.',
    'store_error' => 'Problema al registrar los datos, inténtelo más tarde.',
    'update_error' =>  'Problema al actualizar los datos, inténtelo más tarde.',
    'edit_error' =>  'Problema al cargar los datos, inténtelo más tarde.',
    'show_error' =>  'Problema al obtener los datos, inténtelo más tarde.',
    'delete_error' => 'Problema al eliminar el registro, inténtelo más tarde.',
    'destroy_error' =>  'Problema al eliminar los registros, inténtelo más tarde.',

    'authorization_failed'=>'No tiene autorización para realizar esta acción.',

    'store_success_email_fail' => 'Se registró el usuario pero no se le pudo enviar el correo electrónico con sus credenciales.',


    'review' =>[
        'store_success' => 'Se registro su comentario de forma exitosa, gracias.',
        'store_error' => 'Problema al registrar su comentario, inténtelo más tarde.',
    ],

    'shopping_cart' =>[
        'increase_item_success' => 'Se agregó el producto a su carrito.',
        'increase_item_error' => 'Problema al agregar el producto a su carrito, inténtelo más tarde.',

        'decrease_item_success' => 'Se disminuyó el producto el producto de su carrito.',
        'decrease_item_error' => 'Problema al disminuir el producto a su carrito, inténtelo más tarde.',
    ],

    'item' =>[
        'increase_item_success' => 'Se agregó el producto a su carrito.',
        'increase_item_error' => 'Problema al agregar el producto a su carrito, inténtelo más tarde.',

        'decrease_item_success' => 'Se disminuyó el producto el producto de su carrito.',
        'decrease_item_error' => 'Problema al disminuir el producto a su carrito, inténtelo más tarde.',

        'delete_success' => 'Se eliminó el producto de su carrito.',
        'delete_error' => 'Problema al eliminar el producto de su carrito, inténtelo más tarde.',
    ],

    'order' =>[
        'store_success' => 'Se registró su pedido de forma exitosa.',
        'store_error' => 'Problema al registrar su pedido, inténtelo más tarde.',

        'change_to_cancelled_success' => 'Se cambió el estado a cancelado.',
        'change_to_cancelled_error' => 'Problema al cambiar el estado a cancelado, inténtelo más tarde.',

        'change_to_delivered_success' => 'Se cambió el estado a entregado.',
        'change_to_delivered_error' => 'Problema al cambiar el estado a entregado, inténtelo más tarde.',

        'change_to_paid_out_success' => 'Se cambió el estado a pagado.',
        'change_to_paid_out_error' => 'Problema al cambiar el estado a pagado, inténtelo más tarde.',

    ],

    'claim' =>[
        'store_success' => 'Se registró su reclamo en breve nos comunicaremos con usted.',
        'store_error' => 'Problema al registrar el reclamo, inténtelo más tarde.',
    ],

    'contact' =>[
        'store_success' => 'Recibimos sus datos de forma exitosa, en breve nos comunicaremos con usted.',
        'store_error' => 'Problema al registrar sus datos, inténtelo más tarde.',
    ]
];
