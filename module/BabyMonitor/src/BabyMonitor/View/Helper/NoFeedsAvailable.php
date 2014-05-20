<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 5.4
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Client/Author
 * @see        Enter if required
 * @since      File available since Release/Tag:
 */

namespace BabyMonitor\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Display a link to the manage action of the feeds
 *
 * @package BabyMonitor\View\Helper
 * @return string
 */
class NoFeedsAvailable extends AbstractHelper
{
    public function __invoke()
    {
        return sprintf(
            "%s <a href='%s' title='%s'>%s</a>",
            $this->view->translate("No available records."),
            $this->view->url('feeds', array('action' => 'manage')),
            $this->view->translate("add the first record"),
            $this->view->translate("Care to add one?")
        );
    }
}