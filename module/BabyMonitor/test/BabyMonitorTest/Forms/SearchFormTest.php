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

use BabyMonitor\Forms\SearchForm;

class SearchFormTest extends BasicFormTest
{
    /**
     * @var SearchForm
     */
    protected $_form;

    public function setUp()
    {
        $this->_form = $this->_getForm();

        $this->_formFields = array(
            'startDate' => array(
                'type' => 'text',
                'placeholder' => 'search from'
            ),
            'endDate' => array(
                'type' => 'text',
                'placeholder' => 'search to'
            ),
        );

        $this->_formProperties = array(
            'method' => 'post',
            'name' => 'Search',
            'action' => '/feeds/search'
        );
    }

    /**
     * This provides a reusable test for the availability of the Search PAC form
     *
     * @return SearchForm
     */
    protected function _getForm()
    {
        return new SearchForm();
    }

    public function testFormInitialState()
    {
        parent::testFormInitialState();

        $this->assertEquals("Search",
            $this->_form->get('submit')->getLabel(),
            "Submit button's label is not correctly set"
        );

    }
}