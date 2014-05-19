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

namespace BabyMonitor\Forms;

use Zend\Form\Form;

class DeleteForm extends Form
{
    public function __construct()
    {
        parent::__construct('DeleteRecord');

        $this->setAttribute('method', 'post')
            ->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'feedId',
            'options' => array(),
            'attributes' => array()
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Delete'
            ),
            'attributes' => array(
                'class' => 'btn btn-danger'
            )
        ));

        $this->get('submit')->setValue('DELETE The Record');

    }
}