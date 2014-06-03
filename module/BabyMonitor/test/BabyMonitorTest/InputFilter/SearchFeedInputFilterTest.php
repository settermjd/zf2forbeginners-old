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

namespace BabyMonitor\test\BabyMonitorTest\InputFilter;

use PHPUnit_Framework_TestCase;
use BabyMonitor\InputFilter\SearchFeedInputFilter;

class SearchFeedInputFilterTest extends PHPUnit_Framework_TestCase
{
    public $inputFilter;

    public function setUp()
    {
        $this->inputFilter = new SearchFeedInputFilter();
    }

    /** @dataProvider validatedDataProvider */
    public function testValidation($data, $valid)
    {
        $this->inputFilter->setData($data);
        $this->assertSame(
            $valid,
            $this->inputFilter->isValid(),
            sprintf(
                "feed did not validate properly. These values are invalid: %s",
                var_export($this->inputFilter->getMessages(), TRUE)
            )
        );
    }

    /**
     * @return array
     */
    public function validatedDataProvider()
    {
        return array(
            array(
                array(
                    'startDate' => '2014-01-01',
                    'endDate' => '2014-01-02'
                ),
                true
            ),
            array(
                array(
                    'startDate' => '2014-01-01'
                ),
                true
            ),
            array(
                array(
                    'endDate' => '2014-01-02'
                ),
                true
            ),
            array(
                array(
                    'startDate' => 1
                ),
                false
            ),
        );
    }
}