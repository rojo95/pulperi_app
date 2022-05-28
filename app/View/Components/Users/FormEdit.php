<?php

namespace App\View\Components\Users;

use Illuminate\View\Component;

class FormEdit extends Component
{

    /**
     * tipo de formulario a mostrar
     * @var string
     */
    public $type;

    /**
     * Nombre del usuario a actualizar
     * @var string
     */
    public $name;

    /**
     * Apellido del usuario a actualizar
     * @var string
     */
    public $lastname;

    /**
     * nombre de usuario de acceso al sistema a actualizar
     * @var string
     */
    public $username;

    /**
     * correo de acceso al sistema a actualizar
     * @var string
     */
    public $email;

    /**
     * correo de acceso al sistema a actualizar
     * @var string
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type,$name,$lastname,$username,$email,$id)
    {
        $this->type = $type;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.users.form-edit');
    }
}
