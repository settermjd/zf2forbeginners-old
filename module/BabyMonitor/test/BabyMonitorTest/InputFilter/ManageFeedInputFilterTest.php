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
use BabyMonitor\InputFilter\ManageFeedInputFilter;

class ManageFeedInputFilterTest extends PHPUnit_Framework_TestCase
{
    public $inputFilter;

    public function setUp()
    {
        $this->inputFilter = new ManageFeedInputFilter();
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
                    'userId' => 1,
                    'feedId' => 1,
                    'feedDate' => '2014-01-01',
                    'feedTime' => '21:00:00',
                    'feedAmount' => 180,
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                true
            ),
            array(
                array(
                    'feedDate' => '2014-01-01',
                    'feedTime' => '08:00:01',
                    'feedAmount' => 180,
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                true
            ),
            array(
                array(
                    'feedId' => 1,
                    'feedDate' => '2014-01-01',
                    'feedTime' => '08:00:01',
                    'feedAmount' => 180,
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                true
            ),
            array(
                array(
                    'userId' => 1,
                    'feedId' => 1,
                    'feedDate' => '2014-01-01',
                    'feedTime' => '08:00:01',
                    'feedAmount' => 180,
                    'feedTemperature' => 21,
                    'feedNotes' => "lipsu text",
                ),
                true
            ),
            array(
                array(
                    'feedDate' => '2014-01-01',
                    'feedTime' => '',
                    'feedAmount' => 180,
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                false
            ),
            array(
                array(
                    'feedDate' => '',
                    'feedTime' => '08:00:01',
                    'feedAmount' => 0,
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                false
            ),
            array(
                array(
                    'feedDate' => '2014-01-01',
                    'feedTime' => '08',
                    'feedAmount' => "",
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                false
            ),
            array(
                array(
                    'feedDate' => '2014-',
                    'feedTime' => '08:00:01',
                    'feedAmount' => -1,
                    'feedTemperature' => 21.04,
                    'feedNotes' => "",
                ),
                false
            ),
        );
    }
}