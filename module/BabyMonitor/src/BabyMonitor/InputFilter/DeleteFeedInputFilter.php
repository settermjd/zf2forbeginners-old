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

namespace BabyMonitor\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Filter\HtmlEntities;
use Zend\Filter\StringTrim;
use Zend\Filter\StripNewlines;
use Zend\Filter\StripTags;
use Zend\Filter\Int;
use Zend\Filter\FilterChain;
use Zend\Validator\Digits;

class DeleteFeedInputFilter extends InputFilter
{
    /**
     * Stores the names of the fields that are mandatory
     *
     * @var array
     */
    protected $_requiredFields = array(
        "feedId"
    );

    /**
     * Stores the names of the fields that are optional
     *
     * @var array
     */
    protected $_optionalFields = array();

    /**
     * Setup the filterchain and input fields
     */
    public function __construct()
    {
        // add the fields to the input filter
        $this->_addRequiredFields()
             ->_addOptionalFields();
    }

    /**
     * Add the required fields to the input filter.
     * It's a basic utility function to avoid writing loads of redundant duplicate code.
     *
     * @return \BabyMonitor\InputFilter\DeleteFeedInputFilter
     */
    protected function _addRequiredFields()
    {
        foreach ($this->_requiredFields as $fieldName) {
            $input = new Input($fieldName);
            $input->setRequired(true)
                ->setAllowEmpty(false)
                ->setBreakOnFailure(false)
                ->setFilterChain($this->_getStandardFilter());

            switch ($fieldName) {

                case ("feedId"):
                    $input->getValidatorChain()
                        ->attach(new Digits(array(
                                'messageTemplates' => array(
                                    Digits::NOT_DIGITS => 'The value supplied is not a valid number',
                                    Digits::STRING_EMPTY => 'A value must be supplied',
                                    Digits::INVALID => 'The value supplied is not a valid number',
                                )
                            )
                        ));
                    break;

            }

            $this->add($input);
        }

        return $this;
    }

    /**
     * Add the optional fields to the input filter.
     * It's a basic utility function to avoid writing loads of redundant duplicate code.
     *
     * @return \BabyMonitor\InputFilter\DeleteFeedInputFilter
     */
    protected function _addOptionalFields()
    {
        foreach ($this->_optionalFields as $fieldName) {
            $input = new Input($fieldName);
            $input->setRequired(true)
                ->setAllowEmpty(true)
                ->setFilterChain($this->_getStandardFilter());

            $this->add($input);
        }

        return $this;
    }


    protected function _getStandardFilter()
    {
        $baseInputFilterChain = new FilterChain();
        $baseInputFilterChain->attach(new Int());

        return $baseInputFilterChain;
    }
}
