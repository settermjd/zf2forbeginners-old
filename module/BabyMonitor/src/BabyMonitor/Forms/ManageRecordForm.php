<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Manages adding and updating feeds in the application
 *
 * @category   BabyMonitor
 * @package    Forms
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @since      File available since Release/Tag: 1.0
 */

namespace BabyMonitor\Forms;

use Zend\Form\Form;

class ManageRecordForm extends Form
{
    public function __construct()
    {
        parent::__construct('ManageRecordForm');

        $this->setAttribute('method', 'post')
             ->setAttribute('class', 'form-horizontal')
             ->setAttribute('action', '/feeds/manage');

        // Add form elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'feedId',
            'options' => array(),
            'attributes' => array()
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'userId',
            'options' => array(),
            'attributes' => array()
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'feedDate',
            'options' => array(
                'label' => 'Date:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'feed date'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'feedTime',
            'options' => array(
                'label' => 'Time:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'feed time'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'feedAmount',
            'options' => array(
                'label' => 'Amount:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'amount'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'feedNotes',
            'options' => array(
                'label' => 'Notes:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'notes'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'feedTemperature',
            'options' => array(
                'label' => 'Temperature:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'temperature'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Save'
            ),
            'attributes' => array(
                'class' => 'btn btn-default'
            )
        ));

        $this->get('submit')->setValue('Save');

    }
}