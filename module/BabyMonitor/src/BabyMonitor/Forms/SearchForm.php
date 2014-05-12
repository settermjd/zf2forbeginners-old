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

class SearchForm extends Form
{
    public function __construct()
    {
        parent::__construct('Search');

        $this->setAttribute('method', 'post')
             ->setAttribute('class', 'form-horizontal');

        // Add form elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'startDate',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
                'placeholder' => 'search from'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'endDate',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
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