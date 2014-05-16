<?php

namespace BabyMonitor\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BabyMonitor\Tables\UserTable;

class FeedsController extends AbstractActionController
{
    protected $_userTable;

    public function __construct(UserTable $userTable)
    {
        $this->_userTable = $userTable;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            $sm = $e->getApplication()->getServiceManager();
            $auth = $sm->get('zfcuser_auth_service');
            if (!$auth->hasIdentity()) {
                return $controller->redirect()->toRoute('zfcuser/login');
            }
        }, 100); // execute before executing action logic
    }

    public function indexAction()
    {
        $this->getServiceLocator()->get('BabyMonitor\Cache\Application');

        return new ViewModel();
    }

    public function searchAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function manageAction()
    {
        return new ViewModel();
    }

}

