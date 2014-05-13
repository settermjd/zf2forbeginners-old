<?php

namespace BabyMonitor\Controller;

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

    public function indexAction()
    {
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

