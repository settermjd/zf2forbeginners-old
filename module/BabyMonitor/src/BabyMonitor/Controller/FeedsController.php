<?php

namespace BabyMonitor\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Warning;

class FeedsController extends AbstractActionController
{

    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');

        $configData = array(
            'application_name' => $config['app']['name'],
            'webmaster_name' => $config['app']['webmaster']['name'],
            'webmaster_email' => $config['app']['webmaster']['email'],
        );

        $view = new ViewModel($configData);

        $view->setVariables($configData);

        return $view;
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

