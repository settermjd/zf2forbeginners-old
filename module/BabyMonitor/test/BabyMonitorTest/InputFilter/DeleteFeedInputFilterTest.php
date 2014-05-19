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
use BabyMonitor\InputFilter\DeleteFeedInputFilter;

class DeleteFeedInputFilterTest extends PHPUnit_Framework_TestCase
{
    public $inputFilter;

    public function setUp()
    {
        $this->inputFilter = new DeleteFeedInputFilter();
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
                    'feedId' => 1
                ),
                true
            ),
            array(
                array(
                    'feedId' => ""
                ),
                false
            ),
            array(
                array(
                    'feedId' => "Mike"
                ),
                false
            ),
            array(
                array(
                    'feedId' => -1
                ),
                false
            ),
        );
    }
}