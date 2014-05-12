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

use PHPUnit_Framework_TestCase;
use Zend\Form\Form as ZendForm;

class BasicFormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $_form;

    /**
     * @var array
     */
    protected $_formFields;

    /**
     * @var array
     */
    protected $_formProperties;

    public function setUp()
    {
        $this->_form = $this->_getForm();
        $this->_formFields = array();
        $this->_formProperties = array();
    }

    /**
     * This provides a reusable test for the availability of the Search PAC form
     *
     * @return Form
     */
    protected function _getForm()
    {
        return new ZendForm();
    }

    public function testFormInitialState()
    {
        // check the form properties
        foreach($this->_formProperties as $propertyName => $propertyValue) {
            $this->assertEquals(true,
                $this->_form->hasAttribute($propertyName),
                "Form has no property {$propertyName} element"
            );
            $this->assertEquals(
                $propertyValue,
                $this->_form->getAttribute($propertyName),
                "Form property {$propertyName} doesn't match {$propertyValue}"
            );
        }

        foreach($this->_formFields as $fieldName => $properties) {
            $this->assertEquals(true, $this->_form->has($fieldName), "Form missing element '{$fieldName}'");
            foreach($properties as $propertyName => $propertyValue) {
                switch ($propertyName) {
                    case ('type') :
                        $this->assertEquals(
                            $propertyValue,
                            $this->_form->get($fieldName)->getAttribute('type'),
                            "field {$fieldName} should have been of type: ". $this->_form->get($fieldName)->getAttribute('type')
                        );
                        break;

                    case ('value'):
                        $this->assertEquals(
                            $propertyValue,
                            $this->_form->get($fieldName)->getValue(),
                            "field {$fieldName} should have value: ". $this->_form->get($fieldName)->getValue()
                        );
                        break;

                    case ('label'):
                        $this->assertEquals(
                            $propertyValue,
                            $this->_form->get($fieldName)->getLabel(),
                            "field {$fieldName} should have label matching: ". $this->_form->get($fieldName)->getLabel()
                        );
                        break;

                    case ('placeholder') :
                        $this->assertEquals(
                            $propertyValue,
                            $this->_form->get($fieldName)->getAttribute('placeholder'),
                            "field {$fieldName} should placeholder matching: {$propertyValue}"
                        );
                        break;
                }
            }
        }
    }
}