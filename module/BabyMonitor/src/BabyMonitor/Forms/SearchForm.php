<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Manages searching feeds in the application
 *
 * @category   BabyMonitor
 * @package    Forms
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @since      File available since Release/Tag: 1.0
 */

namespace BabyMonitor\Forms;

use Zend\Form\Form;

class SearchForm extends Form
{
    public function __construct()
    {
        parent::__construct('Search');

        $this->setAttribute('method', 'post')
             ->setAttribute('class', 'form-inline');

        // Add form elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'startDate',
            'options' => array(
                'label' => 'Start Date:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'search from'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'endDate',
            'options' => array(
                'label' => 'End Date:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'search to'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Search'
            ),
            'attributes' => array(
                'class' => 'btn btn-primary'
            )
        ));

        $this->get('submit')->setValue('Search');

    }
}