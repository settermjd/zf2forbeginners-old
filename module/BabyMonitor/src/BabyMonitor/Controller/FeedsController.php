<?php

namespace BabyMonitor\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BabyMonitor\Tables\UserTable;
use BabyMonitor\Tables\FeedTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator;
use BabyMonitor\Models\FeedModel;
use Zend\Paginator\Adapter\ArrayAdapter;

class FeedsController extends AbstractActionController
{
    const DEFAULT_FEED_COUNT = 20;
    const DEFAULT_RECORDS_PER_PAGE = 20;
    const KEY_ALL_RESULTS = "recent_feeds";

    protected $_userTable;
    protected $_feedTable;
    protected $_cache;

    public function __construct(UserTable $userTable, FeedTable $feedTable, $cache = null)
    {
        $this->_userTable = $userTable;
        $this->_feedTable = $feedTable;

        if (!is_null($cache)) {
            $this->_cache = $cache;
        }
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
        if (!is_null($this->_cache)) {
            if (!$this->_cache->hasItem(self::KEY_ALL_RESULTS)) {
                $resultset = $this->_feedTable->fetchMostRecentFeeds(self::DEFAULT_FEED_COUNT);
                $this->_cache->setItem(self::KEY_ALL_RESULTS, $resultset->toArray());
            } else {
                $resultset = $this->_cache->getItem(self::KEY_ALL_RESULTS);
            }
        } else {
            $resultset = $this->_feedTable->fetchMostRecentFeeds(self::DEFAULT_FEED_COUNT);
        }

        if (is_array($resultset)) {
            $paginator = new Paginator(new ArrayAdapter($resultset));
        } else {
            $paginator = new Paginator(new Iterator($resultset));
        }

        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage($this->params()->fromRoute('perPage', self::DEFAULT_RECORDS_PER_PAGE));

        return new ViewModel(array(
            'paginator' => $paginator,
            'feedCount' => self::DEFAULT_FEED_COUNT
        ));
    }

    public function searchAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('BabyMonitor\Forms\SearchForm');

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function deleteAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('BabyMonitor\Forms\DeleteForm');
        $form->setData(array(
            'feedId' => (int)$this->params()->fromRoute('id')
        ));

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                if ($this->_feedTable->delete($form->getInputFilter()->getValue('feedId'))) {
                    if (!is_null($this->_cache)) {
                        $this->_cache->removeItem(self::KEY_ALL_RESULTS);
                    }
                    // trigger the deleted event
                    $this->getEventManager()->trigger('Feed.Delete', $this, array(
                        'feedData' => $form->getInputFilter()->getValues()
                    ));
                }
                return $this->redirect()->toRoute('feeds', array());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function manageAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('BabyMonitor\Forms\ManageRecordForm');

        $feedId = (int)$this->params()->fromRoute('id');

        if (!empty($feedId)) {
            $feed = $this->_feedTable->fetchById($feedId);
            $form->setData($feed->getArrayCopy());
        }

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $feed = new FeedModel();
                $feed->exchangeArray($form->getData());
                $this->_feedTable->save($feed);

                if (!is_null($this->_cache)) {
                    $this->_cache->removeItem(self::KEY_ALL_RESULTS);
                }

                $this->getEventManager()->trigger('Feed.Modify', $this, array(
                    'feedData' => $feed
                ));

                return $this->redirect()->toRoute('feeds', array());
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'cancelTitle' => ($feedId) ? "Don't update the record" : "Don't create the record"
        ));
    }

}

