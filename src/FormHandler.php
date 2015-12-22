<?php

/**
 * FormHandler Legacy v1.0
 *
 * Look for more info at http://www.formhandler.net
 * @package FormHandler
 */

use FormHandler\FormHandler as fhNew;

/**
 * class FormHandler
 *
 * @author Marien den Besten
 * @link http://www.formhandler.net
 */
class FormHandler extends fhNew
{

    /**
     * FormHandler::textField()
     *
     * Creates a textfield on the form
     *
     * @param string $title: The title of the field
     * @param string $name: The name of the field
     * @param string $validator: The validator which should be used to validate the value of the field
     * @param int $size: The size of the field
     * @param int $maxlength: The allowed max input of the field
     * @param string $extra: CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Text
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\Text::set() instead
     */
    public function textField($title, $name, $validator = null, $size = null, $maxlength = null, $extra = null)
    {
        return \FormHandler\Field\Text::set($this, $title, $name, $validator)
                ->setSize($size)
                ->setMaxlength($maxlength)
                ->setExtra($extra);
    }

    /**
     * FormHandler::passField()
     *
     * Create a password field
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $size The size of the field
     * @param int $maxlength allowed max input of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Password
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\Password::set() instead
     */
    public function passField(
    $title, $name, $validator = null, $size = null, $maxlength = null, $extra = null)
    {
        return \FormHandler\Field\Password::set($this, $title, $name, $validator)
                ->setSize($size)
                ->setMaxlength($maxlength)
                ->setExtra($extra);
    }

    /**
     * FormHandler::hiddenField()
     *
     * Create a hidden field
     *
     * @param string $name The name of the field
     * @param string $value The value of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Hidden
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\Hidden::set() instead
     */
    public function hiddenField($name, $value = null, $validator = null, $extra = null)
    {
        $fld = \FormHandler\Field\Hidden::set($this, $name, $validator)->setExtra($extra);

        // only set the hidden field value if there is not a value in the $_POST array
        if(!is_null($value))
        {
            $fld->setValue($value);
        }
        return $fld;
    }

    /**
     * FormHandler::textArea()
     *
     * Create a textarea on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $cols How many cols (the width of the field)
     * @param int $rows How many rows (the height of the field)
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\TextArea
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\TextArea::set() instead
     */
    public function textArea($title, $name, $validator = null, $cols = null, $rows = null, $extra = null)
    {
        return \FormHandler\Field\TextArea::set($this, $title, $name, $validator)
                ->setValidator($validator)
                ->setCols($cols)
                ->setRows($rows)
                ->setExtra($extra);
    }

    /**
     * FormHandler::selectField()
     *
     * Create a selectField on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param array $options The options used for the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param boolean $useArrayKeyAsValue If the array key's are the values for the options in the field
     * @param boolean $multiple Should it be possible to select multiple options ? (Default: false)
     * @param int $size The size of the field (how many options are displayed)
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Select
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\Select::set() instead
     */
    public function selectField($title, $name, $options = array(), $validator = null, $useArrayKeyAsValue = null, $multiple = null, $size = null, $extra = null)
    {
        return \FormHandler\Field\Select::set($this, $title, $name, $validator)
                ->setOptions($options)
                ->setValidator($validator)
                ->useArrayKeyAsValue($useArrayKeyAsValue)
                ->setExtra($extra)
                ->setMultiple($multiple)
                ->setSize($size);
    }

    /**
     * FormHandler::checkBox()
     *
     * Create a checkBox on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param array|string $value The option(s) used for the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param boolean $useArrayKeyAsValue If the array key's are the values for the options in the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param string $mask if more the 1 options are given, glue the fields together with this mask
     * @return \FormHandler\Field\CheckBox
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\CheckBox::set() instead
     */
    public function checkBox($title, $name, $value = 'on', $validator = null, $useArrayKeyAsValue = null, $extra = null, $mask = null)
    {
        return \FormHandler\Field\CheckBox::set($this, $title, $name, $validator)
                ->setOptions($value)
                ->useArrayKeyAsValue($useArrayKeyAsValue)
                ->setExtra($extra)
                ->setMask($mask);
    }

    /**
     * FormHandler::radioButton()
     *
     * Create a radioButton on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param array $options The options used for the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param boolean $useArrayKeyAsValue If the array key's are the values for the options in the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param string $mask if more the 1 options are given, glue the fields together with this mask
     * @return \FormHandler\Field\Radio
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\Radio::set() instead
     */
    public function radioButton($title, $name, $options, $validator = null, $useArrayKeyAsValue = null, $extra = null, $mask = null)
    {
        return \FormHandler\Field\Radio::set($this, $title, $name, $validator)
                ->setOptions($options)
                ->useArrayKeyAsValue($useArrayKeyAsValue)
                ->setExtra($extra)
                ->setMask($mask);
    }

    /**
     * FormHandler::listField()
     *
     * Create a listField on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param array $options The options used for the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param string $useArrayKeyAsValue The title used above the ON section of the field
     * @param string $onTitle The title used above the OFF section of the field
     * @param boolean $offTitle If the array key's are the values for the options in the field
     * @param int $size The size of the field (how many options are displayed)
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param string $verticalMode Verticalmode
     * @return \FormHandler\Field\SelectList
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Field\SelectList::set() instead
     */
    public function listField($title, $name, $options, $validator = null, $useArrayKeyAsValue = null, $onTitle = null, $offTitle = null, $size = null, $extra = null, $verticalMode = null)
    {
        return \FormHandler\Field\SelectList::set($this, $title, $name, $validator)
                ->setOptions($options)
                ->useArrayKeyAsValue($useArrayKeyAsValue)
                ->setSize($size)
                ->setExtra($extra)
                ->setOnTitle($onTitle)
                ->setOffTitle($offTitle)
                ->setVerticalMode($verticalMode);
    }

    /*     * ************** */
    /*     * ** BUTTONS *** */
    /*     * ************** */

    /**
     * FormHandler::button()
     *
     * Create a button on the form
     *
     * @param string $caption The caption of the button
     * @param string $name The name of the button
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Button\Button
     * @author Teye Heimans
     * @author Marien den Besten
     * @deprecated Use \FormHandler\Button\Button::set() instead
     */
    public function button($caption, $name = null, $extra = null, $disableOnClick = true)
    {
        $btn = \FormHandler\Button\Button::set($this, $caption, $name)
            ->setExtra($extra);

        if(!is_null($disableOnClick))
        {
            $btn->disableOnSubmit($disableOnClick);
        }
        return $btn;
    }

    /**
     * FormHandler::submitButton()
     *
     * Create a submitButton on the form
     *
     * @param string $caption The caption of the button
     * @param string $name The name of the button
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param boolean $disableOnSubmit Disable the button when it is pressed
     * @return \FormHandler\Button\Submit
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Button\Submit::set() instead
     */
    public function submitButton($caption = null, $name = null, $extra = null, $disableOnSubmit = null)
    {
        $btn = \FormHandler\Button\Submit::set($this, $caption, $name)
            ->setExtra($extra);

        if(!is_null($disableOnSubmit))
        {
            $btn->disableOnSubmit($disableOnSubmit);
        }
        return $btn;
    }

    /**
     * FormHandler::imageButton()
     *
     * Create a imageButton on the form
     *
     * @param string $image: The image URL which should be a button
     * @param string $name: The name of the button
     * @param string $extra: CSS, Javascript or other which are inserted into the HTML tag
     * @param boolean $disableOnSubmit: Disable the button when it is pressed
     * @return \FormHandler\Button\Image
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Button\Image::set() instead
     */
    public function imageButton($image, $name = null, $extra = null)
    {
        return \FormHandler\Button\Image::set($this, null, $name)
                ->setImage($image)
                ->setExtra($extra);
    }

    /**
     * FormHandler::resetButton()
     *
     * Create a resetButton on the form
     *
     * @param string $caption The caption of the button
     * @param string $name The name of the button
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Button\Reset
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Button\Reset::set() instead
     */
    public function resetButton($caption = null, $name = null, $extra = null)
    {
        return \FormHandler\Button\Reset::set($this, $caption, $name)
                ->setExtra($extra);
    }

    /**
     * FormHandler::cancelButton()
     *
     * Create a cancelButton on the form
     *
     * @param string $caption The caption of the button
     * @param string $url The URL to go to when the button is clicked
     * @param string $name The name of the button
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Button\Cancel
     * @author Teye Heimans
     * @deprecated Use \FormHandler\Button\Cancel::set() instead
     */
    public function cancelButton($caption = null, $url = null, $name = null, $extra = null)
    {
        return \FormHandler\Button\Cancel::set($this, $caption, $name)
                ->setUrl($url)
                ->setExtra($extra);
    }

    /**
     * FormHandler::captchaField()
     *
     * Creates a captchafield on the form using Securimage - A PHP class for creating and managing form CAPTCHA images
     *
     * @param string $title: The title of the field
     * @param string $name: The name of the field
     * @param int $size: The size of the field
     * @param int $maxlength: The allowed max input of the field
     * @param string $extra: CSS, Javascript or other which are inserted into the HTML tag
     * @return void
     * @author Johan Wiegel
     * @since 27-11-2007
     * @deprecated Use \FormHandler\Field\Captcha::set() instead
     */
    public function CaptchaField($title, $name, $width = null, $height = null, $length = null, $size = null, $maxlength = null, $extra = null, $url = null)
    {
        \FormHandler\Field\Captcha::set($this, $title, $name)
            ->setWidth($width)
            ->setHeight($height)
            ->setSize($size)
            ->setMaxlength($max_length)
            ->setExtra($extra);
        return $this;
    }

    /**
     * Get the form
     * 
     * @param boolean $return
     * @return string|null
     */
    public function flush($return = false)
    {
        $form = parent::flush();

        // return or print the form
        if($return)
        {
            return $form;
        }
        else
        {
            echo $form;
            return null;
        }
    }
}

function fh_conf()
{
    if(func_num_args() == 2)
    {
        FormHandler\Configuration::set(func_get_arg(0), func_get_arg(1));
    }
}
