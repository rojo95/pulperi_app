<?php

namespace App\View\Components\Users;

use Illuminate\View\Component;

class FichaUsuario extends Component
{
    /**
     * Tipo de ficha a mostrar
     *
     * @var string
     */

    public $type;

    /**
     * Nombre del usuario
     *
     * @var string
     */

    public $name;

    /**
     * Nombre de usuario
     */
    public $username;

    /**
     * Email del usuario
     */
    public $email;

    /**
     * fecha de creación del usuario
     */
    public $created_at;

    /**
     *
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name, $username, $email, $created_at="Siempre estuvo aquí...", $id=null )
    {
        $this->type = $type;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.users.ficha-usuario');
    }
}
