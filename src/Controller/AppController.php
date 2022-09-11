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
            'unauthorizedRedirect' => $this->referer()
        ]);

        // Permite a ação display, assim nosso pages controller
        // continua a funcionar.
        $this->Auth->allow(['display']);
    }
    public function isAuthorized($user)
    {
        $action = $this->request->params['actions'];
        if (in_array($action, ['index', 'add', 'tags'])) {
            return true;
        }
        if (!$this->request->getParam('pass.0')) {
            return false;
        }

        $id = $this->request->getParam('pass.0');
        $bookmark = $this->Bookmarks->get($id);

        if ($bookmark->user_id == $user['id']) {
            return true;
        }

        return parent::isAuthorized($user);
    }
}
