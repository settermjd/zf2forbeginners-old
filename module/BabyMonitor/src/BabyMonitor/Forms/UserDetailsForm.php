<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Manages user details in the application
 *
 * @category   BabyMonitor
 * @package    Forms
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @since      File available since Release/Tag: 1.0
 */

namespace BabyMonitor\Forms;

use Zend\Form\Form;

class UserDetailsForm extends Form
{
    public function __construct()
    {
        parent::__construct('ManageUser');

        $this->setAttribute('method', 'post')
             ->setAttribute('class', 'form-horizontal');

        // Add form elements

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'userId',
            'options' => array(),
            'attributes' => array()
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'username',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
                'placeholder' => 'username'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'firstName',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
                'placeholder' => 'first name'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'lastName',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
                'placeholder' => 'last name'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'addressId',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusId',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'notes',
            'options' => array(),
            'attributes' => array(
                'class' => 'input-block-level',
                'placeholder' => 'notes'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Save'
            ),
            'attributes' => array(
                'class' => 'btn btn-primary'
            )
        ));

        $this->get('submit')->setValue('Save');

    }
}