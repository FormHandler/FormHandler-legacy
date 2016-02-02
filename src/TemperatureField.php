<?php

/**
 * Copyright (C) 2015 FormHandler
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

/**
 * @deprecated Use \FormHandler\Field\Temperature instead
 */
class TemperatureField extends \FormHandler\Field\Temperature
{
    private $checkbox;

    public function __construct(\FormHandler $form, $name)
    {
        parent::__construct($form, $name);

        $this->checkbox = new CheckBox($this->form_object, $this->name .'_empty');
        $this->checkbox->setOptions(array(1 => '<em>Not applicable</em>'));

        $form->_setJS("$('#". $name ."_empty_1').on('change',function()\n
            {\n
             var state = !!$(this).prop('checked');\n
             $('#". $name ."_temperature, #". $name ."_unit').prop('disabled',state);\n
            });"
        ,false,false);
    }

    public function _getViewValue()
    {
        return (is_null($this->getValue()))
            ? '<em>Not applicable</em>'
            : parent::_getViewValue();

    }

    public static function set(\FormHandler\FormHandler $form, $title, $name, $validator = null)
    {
        $field = parent::set($form, $title, $name);
        $field->setValidator(FormHandler::parseValidator($validator, $field));
        return $field;
    }

    public function setValidator($validator = null)
    {
        if(count($this->getValidators()) === 0
            && $validator instanceof FormHandler\Validator\FunctionCallable
            && is_array($validator->getCallable()))
        {
            $callable = $validator->getCallable();

            //detect if it is an optional validator
            if($callable[0] instanceof Validator
                && substr($callable[1], 0, 1) !== '_')
            {
                parent::setValidator(new \FormHandler\Validator\NotEmpty());
            }
        }

        return parent::setValidator(FormHandler::parseValidator($validator, $this));
    }

    public function setValue($value, $forced = false)
    {
        if(is_null($value))
        {
            $this->checkbox->setValue(true);
        }
        return parent::setValue($value, $forced);
    }

    /**
     * Return fields
     *
     * @return type
     */
    public function getField()
    {
        // view mode enabled ?
        if($this->getViewMode())
        {
            // get the view value..
            return $this->_getViewValue();
        }

        return parent::getField() .'<br>'. $this->checkbox->getField();
    }

    /**
     * Set disabled
     *
     * @param boolean $bool
     * @return Field
     */
    public function setDisabled($bool = true)
    {
        $this->checkbox->setDisabled($bool);
        return parent::setDisabled($bool);
    }

    public function getDisabled()
    {
        $empty_value = $this->checkbox->getValue();

        return (!empty($empty_value))
            ? true
            : parent::getDisabled();
    }

    /**
     * Get if the field is in error state
     *
     * @return boolean
     * @author Ruben de Vos
     */
    public function getErrorState()
    {
        $empty_value = $this->checkbox->getValue();

        return (!empty($empty_value))
            ? false
            : parent::getErrorState();
    }
}