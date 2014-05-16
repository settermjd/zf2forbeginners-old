<?php

namespace BabyMonitor\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function LoginAction()
    {
        $layout = $this->layout();
        $layout->setTemplate('layout/login');

        return new ViewModel();
    }


}

