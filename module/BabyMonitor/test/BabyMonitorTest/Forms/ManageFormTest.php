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

namespace BabyMonitor\test\BabyMonitorTest\Forms;

use BabyMonitor\Forms\ManageRecordForm;

class ManageFormTest extends BasicFormTest
{
    /**
     * @var ManageRecordForm
     */
    protected $_form;

    public function setUp()
    {
        $this->_form = $this->_getForm();

        $this->_formFields = array(
            'feedId' => array(
                'type' => 'hidden',
            ),
            'userId' => array(
                'type' => 'hidden',
            ),
            'feedDate' => array(
                'type' => 'text',
                'placeholder' => 'feed date'
            ),
            'feedTime' => array(
                'type' => 'text',
                'placeholder' => 'feed time'
            ),
            'feedAmount' => array(
                'type' => 'text',
                'placeholder' => 'amount'
            ),
            'feedNotes' => array(
                'type' => 'textarea',
                'placeholder' => 'notes'
            ),
            'feedTemperature' => array(
                'type' => 'text',
                'placeholder' => 'temperature'
            ),
        );

        $this->_formProperties = array(
            'method' => 'post',
            'name' => 'ManageRecordForm',
            'action' => '/feeds/manage'
        );
    }

    /**
     * This provides a reusable test for the availability of the Search PAC form
     *
     * @return ManageRecordForm
     */
    protected function _getForm()
    {
        return new ManageRecordForm();
    }

    public function testFormInitialState()
    {
        parent::testFormInitialState();

        $this->assertEquals("Save",
            $this->_form->get('submit')->getLabel(),
            "Submit button's label is not correctly set"
        );

    }
}