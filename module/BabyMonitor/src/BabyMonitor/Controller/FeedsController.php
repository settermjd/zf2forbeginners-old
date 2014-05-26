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
    /**
     * @var int default amount of feeds to display, max, per/page
     */
    const DEFAULT_FEED_COUNT = 20;

    /**
     * @var int
     */
    const DEFAULT_RECORDS_PER_PAGE = 20;

    /**
     * @var int
     */
    const DEFAULT_PAGE = 1;

    /**
     * default cache key for recent feeds
     */
    const KEY_ALL_RESULTS = "recent_feeds";

    /**
     * @var UserTable
     */
    protected $_userTable;

    /**
     * @var FeedTable
     */
    protected $_feedTable;

    /**
     * @var \Zend\Cache\Storage\Adapter\AbstractAdapter
     */
    protected $_cache;

    public function __construct(UserTable $userTable, FeedTable $feedTable, $cache = null)
    {
        $this->_userTable = $userTable;
        $this->_feedTable = $feedTable;

        if (!is_null($cache)) {
            $this->_cache = $cache;
        }
    }

    /**
     * Ensures that the actions in this controller can only be used if a user is authenticated.
     *
     * @param EventManagerInterface $events
     * @return $this|void|\Zend\Mvc\Controller\AbstractController
     */
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

    /**
     * Displays a list of the most recent feeds, reverse date order, to the user.
     *
     * It's intended as a starting off point to the rest of the application.
     *
     * @return array|ViewModel
     */
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

        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', self::DEFAULT_PAGE));
        $paginator->setItemCountPerPage($this->params()->fromRoute('perPage', self::DEFAULT_RECORDS_PER_PAGE));

        return new ViewModel(array(
            'paginator' => $paginator,
            'feedCount' => self::DEFAULT_FEED_COUNT,
            'messages' => array(
                'info' => $this->flashMessenger()->hasInfoMessages(),
                'error' => $this->flashMessenger()->hasErrorMessages()
            )
        ));
    }

    /**
     * All the user to search for feeds in the application based on a start and end date.
     *
     * @return ViewModel
     */
    public function searchAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('BabyMonitor\Forms\SearchForm');

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                return $this->redirect()->toRoute('feeds/search', array(
                    'startDate' => $form->getInputFilter()->getValue('startDate'),
                    'endDate' => $form->getInputFilter()->getValue('endDate'),
                ));
            }
        }

        if ($this->getRequest()->isGet()) {
            $form->setData($this->params()->fromRoute());
            if ($form->isValid()) {
                $resultset = $this->_feedTable->fetchByDateRange(
                    new \DateTime($form->getInputFilter()->getValue('startDate')),
                    new \DateTime($form->getInputFilter()->getValue('endDate', null))
                );

                if (is_array($resultset)) {
                    $paginator = new Paginator(new ArrayAdapter($resultset));
                } else {
                    $paginator = new Paginator(new Iterator($resultset));
                }

                $paginator->setCurrentPageNumber($this->params()->fromRoute('page', self::DEFAULT_PAGE));
                $paginator->setItemCountPerPage(
                    $this->params()->fromRoute('perPage', self::DEFAULT_RECORDS_PER_PAGE)
                );
            }

            return new ViewModel(array(
                'form' => $form,
                'paginator' => (isset($paginator)) ? $paginator : new Paginator(new ArrayAdapter(array())),
            ));
        }
    }

    /**
     * Allow the user to delete a feed, one at a time.
     *
     * @return ViewModel
     */
    public function deleteAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('BabyMonitor\Forms\DeleteForm');
        $form->setData(array(
            'feedId' => (int)$this->params()->fromRoute('id')
        ));

        if (!$this->_feedTable->fetchById((int)$this->params()->fromRoute('id'))) {
            $this->flashMessenger()->addErrorMessage("Unable to find that feed. Perhaps you meant a different one?");
            return $this->redirect()->toRoute('feeds', array());
        }

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                if ($this->_feedTable->delete($form->getInputFilter()->getValue('feedId'))) {
                    if (!is_null($this->_cache)) {
                        $this->_cache->removeItem(self::KEY_ALL_RESULTS);
                    }
                    $feed = new FeedModel();
                    $feed->exchangeArray($form->getData());
                    // trigger the deleted event
                    $this->getEventManager()->trigger('Feed.Delete', $this, array(
                        'feedData' => $feed
                    ));
                    $this->flashMessenger()->addInfoMessage("Feed Deleted.");
                    return $this->redirect()->toRoute('feeds', array());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * All a user to add and update a feed in the application
     *
     * @return ViewModel
     */
    public function manageAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('BabyMonitor\Forms\ManageRecordForm');

        $feedId = (int)$this->params()->fromRoute('id');

        if ($this->getRequest()->isGet()) {
            if (!empty($feedId)) {
                if ($feed = $this->_feedTable->fetchById($feedId)) {
                    $form->setData($feed->getArrayCopy());
                } else {
                    $this->flashMessenger()->addInfoMessage('Unable to find that feed. Perhaps a new one?');
                    return $this->redirect()->toRoute('feeds', array('action' => 'manage'));
                }
            }
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
            'cancelTitle' => ($feedId) ? "Don't update the record" : "Don't create the record",
            'messages' => array(
                'info' => $this->flashMessenger()->hasInfoMessages()
            )
        ));
    }

}

