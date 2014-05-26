<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Displays a link to the manage action of the feeds
 *
 * @category   BabyMonitor
 * @package    View\Helper
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
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
            $this->view->url('feeds/manage', array()),
            $this->view->translate("add the first record"),
            $this->view->translate("Care to add one?")
        );
    }
}