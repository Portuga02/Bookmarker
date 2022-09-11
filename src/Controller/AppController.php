<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ],
                ],
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'unauthorizedRedirect' => $this->referer(),
        ]);

        $this->Auth->allow(['display']);
    }
    public function isAuthorized($user)
    {
        return false;
    }
}
