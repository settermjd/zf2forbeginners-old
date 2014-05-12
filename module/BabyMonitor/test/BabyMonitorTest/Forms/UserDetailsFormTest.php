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

use BabyMonitor\Forms\UserDetailsForm;

class UserDetailsFormTest extends BasicFormTest
{
    /**
     * @var UserDetailsForm
     */
    protected $_form;

    public function setUp()
    {
        $this->_form = $this->_getForm();

        $this->_formFields = array(
            'userId' => array(
                'type' => 'hidden',
            ),
            'username' => array(
                'type' => 'text',
                'placeholder' => 'username'
            ),
            'password' => array(
                'type' => 'password',
            ),
            'firstName' => array(
                'type' => 'text',
                'placeholder' => 'first name'
            ),
            'lastName' => array(
                'type' => 'text',
                'placeholder' => 'last name'
            ),
            'addressId' => array(
                'type' => 'select',
            ),
            'statusId' => array(
                'type' => 'select',
            ),
            'notes' => array(
                'type' => 'textarea',
                'placeholder' => 'notes'
            ),
        );

        $this->_formProperties = array(
            'method' => 'post',
            'name' => 'ManageUser'
        );
    }

    /**
     * This provides a reusable test for the availability of the Search PAC form
     *
     * @return UserDetailsForm
     */
    protected function _getForm()
    {
        return new UserDetailsForm();
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