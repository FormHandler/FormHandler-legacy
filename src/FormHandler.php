<?php

/**
 * FormHandler Legacy v1.0
 *
 * Look for more info at http://www.formhandler.net
 * @package FormHandler
 */

use FormHandler\FormHandler as fhNew;

/* * ***** BUILD IN VALIDATOR FUNCTIONS ****** */
// any string that doesn't have control characters (ASCII 0 - 31) but spaces are allowed
define('FH_STRING', 'IsString', true);
//not a 0 value
define('FH_NOT_ZERO', 'notZero', true);
// only letters a-z and A-Z
define('FH_ALPHA', 'IsAlpha', true);
// only numbers 0-9
define('FH_DIGIT', 'IsDigit', true);
// letters and numbers
define('FH_ALPHA_NUM', 'IsAlphaNum', true);
// only numbers 0-9 and an optional - (minus) sign (in the beginning only)
define('FH_INTEGER', 'IsInteger', true);
// like FH_INTEGER, only with , (comma)
define('FH_FLOAT', 'IsFloat', true);
// a valid file name (including dots but no slashes and other forbidden characters)
define('FH_FILENAME', 'IsFilename', true);
// a boolean (TRUE is either a case-insensitive "true" or "1". Everything else is FALSE)
define('FH_BOOL', 'IsBool', true);
// a valid variable name (letters, digits, underscore)
define('FH_VARIABLE', 'IsVariable', true);
// a valid password (alphanumberic + some other characters but no spaces. Only allow ASCII 33 - 126)
define('FH_PASSWORD', 'IsPassword', true);
// a valid URL
define('FH_URL', 'IsURL', true);
// a valid URL (http connection is used to check if url exists!)
define('FH_URL_HOST', 'IsURLHost', true);
// a valid email address (only checks for valid format: xxx@xxx.xxx)
define('FH_EMAIL', 'IsEmail', true);
// like FH_EMAIL only with host check
define('FH_EMAIL_HOST', 'IsEmailHost', true);
// like FH_STRING, but newline characters are allowed
define('FH_TEXT', 'IsText', true);
// check if the value is not empty
define('FH_NOT_EMPTY', 'notEmpty', true);
// check if the value does not contain html
define('FH_NO_HTML', 'NoHTML', true);
// check if the value is a valid ip adres (xxx.xxx.xxx.xxx:xxxx)
define('FH_IP', 'IsIp', true);

// for dutch people
// valid dutch postcode (eg. 9999 AA)
define('FH_POSTCODE', 'IsPostcode', true);
// valid dutch phone-number(eg. 058-2134778)
define('FH_PHONE', 'IsPhone', true);

// same as above, but with these the value is not required
define('_FH_STRING', '_IsString', true);
define('_FH_NOT_ZERO', '_notZero', true);
define('_FH_ALPHA', '_IsAlpha', true);
define('_FH_DIGIT', '_IsDigit', true);
define('_FH_ALPHA_NUM', '_IsAlphaNum', true);
define('_FH_INTEGER', '_IsInteger', true);
define('_FH_FLOAT', '_IsFloat', true);
define('_FH_FILENAME', '_IsFilename', true);
define('_FH_BOOL', '_IsBool', true);
define('_FH_VARIABLE', '_IsVariabele', true);
define('_FH_PASSWORD', '_IsPassword', true);
define('_FH_URL', '_IsURL', true);
define('_FH_URL_HOST', '_IsURLHost', true);
define('_FH_EMAIL', '_IsEmail', true);
define('_FH_EMAIL_HOST', '_IsEmailHost', true);
define('_FH_TEXT', '_IsText', true);
define('_FH_POSTCODE', '_IsPostcode', true);
define('_FH_PHONE', '_IsPhone', true);
define('_FH_NO_HTML', '_NoHTML', true);
define('_FH_IP', '_IsIp', true);

/**
 * class FormHandler
 *
 * @author Marien den Besten
 * @link http://www.formhandler.net
 * @deprecated Use \FormHandler\FormHandler() instead
 */
class FormHandler extends fhNew
{
    /**
     * Helper function to parse old style validators to new style
     *
     * @param mixed $validator
     * @param \FormHandler\Field\Field $field
     * @return \name
     */
    public static function parseValidator($validator, \FormHandler\Field\Field $field = null)
    {
        if($validator instanceof \FormHandler\Validator\ValidatorInterface)
        {
            return $validator;
        }

        //detect default validations
        if(is_string($validator))
        {
            $v = new Validator();
            if(method_exists($v, $validator))
            {
                //make required when validator is not optional
                if(!is_null($field)
                    && substr($validator, 0, 1) != '_')
                {
                    $field->setRequired(true);
                }

                //change validator to be callable
                $validator = array($v, $validator);
            }
        }

        if(is_callable($validator))
        {
            return new \FormHandler\Validator\FunctionCallable($validator);
        }
        return null;
    }

    /**
     * FormHandler::textField()
     *
     * Creates a textfield on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $size The size of the field
     * @param int $maxlength The allowed max input of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Text
     * @author Teye Heimans
     * @deprecated since version 4
     * @see \FormHandler\Field\Text::set()
     */
    public function textField($title, $name, $validator = null, $size = null, $maxlength = null, $extra = null)
    {
        $field = \FormHandler\Field\Text::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setSize($size)
            ->setMaxlength($maxlength)
            ->setExtra($extra);
    }

    /**
     * FormHandler::browserField()
     *
     * Creates a browserfield on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $path The path to browse
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $size The size of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Text
     * @author Johan Wiegel
     * @deprecated No alternative present
     */
    public function browserField($title,$name,$path,$validator = null,$size = null,$extra = null)
    {
        return $this->textField($title, $name, $validator, $size, $extra);
    }

    /**
     * FormHandler::textSelectField()
     *
     * Creates a textSelectfield on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param array $aOptions the options for the select part
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $size The size of the field
     * @param int $maxlength The allowed max input of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Select
     * @author Johan wiegel
     * @since 22-10-2008
     * @deprecated No alternative present
     */
    public function textSelectField($title, $name, $aOptions, $validator = null, $size = null, $maxlength = null, $extra = null)
    {
        return $this->selectField($title, $name, $aOptions, $validator, null, null, $size, $extra);
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
    public function passField($title, $name, $validator = null, $size = null, $maxlength = null, $extra = null)
    {
        $field = \FormHandler\Field\Password::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
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
        $fld = \FormHandler\Field\Hidden::set($this, $name);
        $fld->setValidator(self::parseValidator($validator, $fld))
            ->setExtra($extra);

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
        $field = \FormHandler\Field\TextArea::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
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
    public function selectField($title, $name, $options = null, $validator = null, $useArrayKeyAsValue = null, $multiple = null, $size = null, $extra = null)
    {
        $field = \FormHandler\Field\Select::set($this, $title, $name);
        return $field->setOptions(empty($options) ? null : $options)
            ->setValidator(self::parseValidator($validator, $field))
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
        $field = \FormHandler\Field\CheckBox::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
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
        $field = \FormHandler\Field\Radio::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setOptions($options)
            ->useArrayKeyAsValue($useArrayKeyAsValue)
            ->setExtra($extra)
            ->setMask($mask);
    }

	/**
     * FormHandler::uploadField()
     *
     * Create a uploadField on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param array $config The configuration used for the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param string $alertOverwrite Do we have to alert the user when he/she is going to overwrite a file?
     * @return FormHandler\Field\File
     * @author Teye Heimans
     * @deprecated Use FormHandler\Field\File::set() instead
     */
    public function uploadField($title, $name, $config = array(), $validator = null, $extra = null, $alertOverwrite = null)
    {
        $field = FormHandler\Field\File::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setExtra($extra);
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
        $field = \FormHandler\Field\SelectList::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setOptions($options)
            ->useArrayKeyAsValue($useArrayKeyAsValue)
            ->setSize($size)
            ->setExtra($extra)
            ->setOnTitle($onTitle)
            ->setOffTitle($offTitle)
            ->setVerticalMode($verticalMode);
    }

	/**
     * FormHandler::editor()
     *
     * Create a editor on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param string $path Path on the server where we have to upload the files
     * @param string $toolbar The toolbar we have to use
     * @param string $skin The skin to use
     * @param int $width The width of the field
     * @param int $height The height of the field
     * @param boolean $useArrayKeyAsValue If the array key's are the values for the options in the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\TextArea
     * @author Teye Heimans
     * @deprecated No alternative exist
     */
    public function editor($title, $name, $validator = null, $path = null, $toolbar = null, $skin = null, $width = null, $height = null, $config = null)
    {
        return \FormHandler\Field\TextArea::set($this, $title, $name, $validator);
    }

	/**
     * FormHandler::dateField()
     *
     * Create a dateField on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param boolean $required If the field is required to fill in or can the user leave it blank
     * @param string $mask How do we have to display the fields? These can be used: d, m and y.
     * @param string $interval The interval between the current year and the years to start/stop.Default the years are beginning at 90 yeas from the current. It is also possible to have years in the future. This is done like this: "90:10" (10 years in the future).
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Text
     * @author Teye Heimans
     * @deprecated No alternative exist yet
     */
    public function dateField($title, $name, $validator = null, $required = null, $mask = null, $interval = null, $extra = null)
    {
        $field = \FormHandler\Field\Text::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator))
            ->setExtra($extra);
    }

    /**
     * FormHandler::jsDateField()
     *
     * Create a dateField with a jscalendar popup on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param boolean $required If the field is required to fill in or can the user leave it blank
     * @param string $mask How do we have to display the fields? These can be used: d, m and y.
     * @param string $interval The interval between the current year and the years to start/stop.Default the years are beginning at 90 yeas from the current. It is also possible to have years in the future. This is done like this: "90:10" (10 years in the future).
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param boolean $bIncludeJS Should we include the js file (only needed once on a page)
     * @return \FormHandler\Field\Text
     * @author Teye Heimans
     * @deprecated No alternative exist yet
     */
    public function jsDateField($title, $name, $validator = null, $required = null, $mask = null, $interval = null, $extra = null, $bIncludeJS = true)
    {
        $field = \FormHandler\Field\Text::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setExtra($extra);
    }

    /**
     * FormHandler::timeField()
     *
     * Create a timeField on the form
     *
     * @param string $title The title of the field
     * @param string $name:The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $format 12 or 24. Which should we use?
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Text
     * @author Teye Heimans
     * @deprecated No alternative exist yet
     */
    public function timeField($title, $name, $validator = null, $required = null, $format = null, $extra = null)
    {
        $field = \FormHandler\Field\Text::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setExtra($extra);
    }

    /**
     * FormHandler::colorPicker()
     *
     * Creates a colorpicker on the form
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param int $size The size of the field
     * @param int $maxlength The allowed max input of the field
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\ColorPicker
     * @author Johan Wiegel
     * @since 23-10-2008
     * @deprecated Use \FormHandler\Field\ColorPicker::set() instead
     */
    public function colorPicker($title, $name, $validator = null, $size = null, $maxlength = null, $extra = null)
    {
        $field = \FormHandler\Field\ColorPicker::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setSize($size)
            ->setMaxlength($maxlength)
            ->setExtra($extra);
    }

    /**
     * FormHandler::dateTextField()
     *
     * Create a dateTextField on the form
     * Validator added by Johan Wiegel
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator The validator which should be used to validate the value of the field
     * @param string $mask How do we have to display the fields? These can be used: d, m and y. (Only for DB-Field with Type 'Date')
     * @param bool $bParseOtherPresentations try to parse other presentations of dateformat
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @return \FormHandler\Field\Text
     * @author Thomas Branius
     * @since 16-03-2010
     * @deprecated No alternative exist yet
     */
    public function dateTextField($title, $name, $validator = null, $mask = null, $bParseOtherPresentations = false, $extra = null)
    {
        $field = \FormHandler\Field\Text::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setExtra($extra);
    }

    /**
     * FormHandler::jsdateTextField()
     *
     * Create a dateTextField on the form
     * Validator added by Johan Wiegel
     *
     * @param string $title The title of the field
     * @param string $name The name of the field
     * @param string $validator
     * @param string $mask How do we have to display the fields? These can be used: d, m and y. (Only for DB-Field with Type 'Date')
     * @param bool $bParseOtherPresentations try to parse other presentations of dateformat
     * @param boolean $bIncludeJS Should we include the js file (only needed once on a page)
     * @param string $extra CSS, Javascript or other which are inserted into the HTML tag
     * @param boolean $bIncludeJS Should we include the js file (only needed once on a page)
     * @return \FormHandler\Field\Text
     * @author Thomas Branius
     * @since 16-03-2010
     * @deprecated No alternative exist yet
     */
    public function jsDateTextField($title, $name, $validator = null, $mask = null, $bParseOtherPresentations = false, $extra = null, $bIncludeJS = true)
    {
        $field = \FormHandler\Field\Text::set($this, $title, $name);
        return $field->setValidator(self::parseValidator($validator, $field))
            ->setExtra($extra);
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
     * FormHandler::backButton()
     *
     * Generate a back button to go one page back in a multi-paged form
     *
     * @param string $caption: The caption of the button
     * @param string $name: The name of the button
     * @param string $extra: CSS, Javascript or other which are inserted into the HTML tag
     * @return void
     * @author Teye Heimans
     * @deprecated Multi page is not supported anymore
     */
	public function backButton($caption = null, $name = null, $extra = null)
	{
        return;
    }

	/**
	 * FormHandler::enableAjaxValidator
	 *
	 * @param boolean $mode: The new state of the AjaxValidator
	 * @param boolean $bScript: Should the library (jQuery) be included by FH
	 * @return void
	 *
	 * @since 03-12-2008
	 * @author Johan Wiegel
     * @deprecated ajax validation will be solved in a different way
	 */
	public function enableAjaxValidator($mode = true, $bScript = true)
    {
        return;
    }

    /**
     * FormHandler::getAsArray()
     *
     * Return the value of a datefield as an array: array(y,m,d)
     *
     * @param string $datefield: return the value of the datefield as an array
     * @return array
     * @author Teye Heimans
     * @deprecated Field specific functions are moved to the field itself
     */
	public function getAsArray( $datefield )
	{
        return false;
    }

    /**
     * FormHandler::getAsMailBody()
     *
     * Returns the values of the form as mail body
     *
     * @param string $mask: The mask which should be used for creating the mail body
     * @return string
     * @author Teye Heimans
     * @since 25/11/2005
     * @deprecated Specific form implementations should be done in the onCorrect function
     */
	public function getAsMailBody( $mask = null )
	{
        return '';
    }

    /**
     * FormHandler::getFileInfo()
     *
     * Get the file info af an uploaded file
     *
     * @param string $uploadfield: the name of the uploadfield
     * @return array file info
     * @author Teye Heimans
     * @deprecated Field specific functions are moved to the field itself
     */
	public function getFileInfo($uploadfield)
	{
        return array();
    }
    /**
     * FormHandler::isUploaded()
     *
     * Check if the given uploadfield has a file which is uploaded
     *
     * @param string $uploadfield: the name of the uploadfield
     * @return boolean
     * @author Teye Heimans
     * @deprecated Field specific functions are moved to the field itself
     */
	public function isUploaded($uploadfield)
	{
        return false;
    }

    /**
     * FormHandler::linkSelectFields()
     *
     * Link de given selectfields (load the values dynamicly)
     *
     * @param string $filename: the name of the file which will load the new values for the select field
     * @param string $fields: the name of the first dynamic select field.
     * @param ...: More fields which are linked to eachother
     * @return null
     * @author Teye Heimans
     * @deprecated use $form->link() instead
     */
	public function linkSelectFields($filename, $fields)
	{
        return;
    }

    /**
     * FormHandler::mergeImage()
     *
     * Merge a image uploaded in the given field with another image
     *
     * @param string $field: The field where the image is uploaded
     * @param string $merge: The image which we should merge
     * @param int $align: The align of the merge image (eg: left, center, right)
     * @param int $valign: The vertical align of the merge image( eg: top, middle, bottom)
     * @return void
     * @author Teye Heimans
     * @deprecated implementation specific, needs to be done in onCorrect function
     */
	public function mergeImage($field, $merge, $align = 'center', $valign = 'bottom', $transparantColor = null)
	{
        return;
    }

    /**
     * FormHandler::resizeImage()
     *
     * Resize the image uploaded in the given field
     *
     * @param string $field: The field where the image is uploaded
     * @param string $saveAs: How the image has to be saved (if not given, the original wil be overwritten)
     * @param int $maxWidth: The maximum width of the resized image
     * @param int $maxHeight: the maximum height of the resized image
     * @param int $quality: the quality of the resized image
     * @param bool $constrainProportions: Keep the proportions when the image is resized?
     * @return void
     * @author Teye Heimans
     * @deprecated implementation specific, needs to be done in onCorrect function
     */
	public function resizeImage( $field, $saveAs = null, $maxWidth = null, $maxHeight = null, $quality = null, $constrainProportions = true )
	{
        return;
    }

    /**
     * FormHandler::setAutoComplete()
     *
     * Set a list of items for auto complete
     *
     * @param string $field: The field which should be auto complete
     * @param array $options: The list of options for the uto complete
     * @return void
     * @author Teye Heimans
     * @deprecated Field specific functions are moved to the field itself, however this one is not implemented
     */
	public function setAutoComplete($field, $options)
	{
        return;
    }

    /**
     * FormHandler::setAutoComplete()
     *
     * Set a list of items for auto complete after specified character
     *
     * @param string $field: The field which should be auto complete
	 * @param string $after: The character after wicht auto completion will start
     * @param array $options: The list of options for the uto complete
     * @return void
     * @author Rob Geerts
	 * @since 12-02-2008 ADDED BY Johan Wiegel
     * @deprecated Field specific functions are moved to the field itself, however this one is not implemented
     */
	public function setAutoCompleteAfter($field, $after, $options)
	{
        return;
    }

    /**
     * FormHandler::setDynamicOptions()
     *
     * Static: Make a javascript array of the given php array. This is
     * used for dynamic select fields
     *
     * @param array $options: the new options for the select field
     * @return null
     * @author Teye Heimans
     * @deprecated Use new functions surrounding the link capabilities
     */
	public function setDynamicOptions($options, $useArrayKeyAsValue = true)
	{
        return null;
    }

    /**
     * FormHandler::setHelpIcon()
     *
     * Set the help icon used for help messages
     *
     * @param string $helpIcon: The path to the help icon
     * @return void
     * @author Teye Heimans
     * @deprecated Use setHelp on the field itself
     */
	public function setHelpIcon( $helpIcon )
	{
        return;
	}

    /**
     * FormHandler::setHelpText()
     *
     * Set the help text for a specific field
     *
     * @param string $field: The name of the field to set the help text for
     * @param string $helpText: The help text for the field
     * @param string $helpTitle: The help title
     * @return void
     * @author Teye Heimans
     * @deprecated Use setHelp on the field itself
     */
	public function setHelpText( $field, $helpText, $helpTitle = null )
	{
        return;
    }

    /**
	 * FormHandler::setTableSettings()
	 *
	 * @param int width
	 * @author Teye Heimans
     * @deprecated FormHandler does not use tables anymore by default
	 */
	function setTableSettings($width = null, $cellspacing = null, $cellpadding = null, $border = null, $extra = '')
    {
        return;
    }

    /**
     * FormHandler::useTable()
     *
     * Do we have to set the <table> tag arround the fields ?
     *
     * @param bool $setTable
     * @return void
     * @author Teye Heimans
     * @deprecate FormHandler does not use tables anymore by default
     */
	public function useTable($setTable)
	{
        return;
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
            ->setHeight(is_null($height) ? $length : $height)
            ->setSize($size)
            ->setMaxlength($maxlength)
            ->setExtra($extra);
        return $this;
    }

    /**
     * FormHandler::setMaxLength()
     *
     * Set the maximum length of a TextArea
     *
     * @param string $field: The field for which the maximum length will be set
     * @param int $maxlength: The allowed max input length of the field
     * @param boolean $displaymessage: determines if a message is displayed with characters left
     * @return void
     * @author Teye Heimans
     * @deprecated Use setMaxLenght on the field object
     */
	public function setMaxLength($field, $maxlength, $displaymessage = true)
    {
        $f = $this->getField($field);

        if(!is_null($f)
            && method_exists($f, 'setMaxLength'))
        {
            $f->setMaxLength($maxlength);
        }
    }

    /**
     * FormHandler::addValue()
     *
     * Add a value to the data array which is going
     * to be saved/used in the oncorrect & onsaved functions
     *
     * @param string $field: The field which value we have to set
     * @param string $value: The value we have to set
     * @param boolean $sqlFunction: Is the value an SQL function ?
     * @return void
     * @author Teye Heimans
     * @deprecated No use anymore
     */
    public function addValue()
    {
        return;
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

    /**
     * FormHandler::_text()
     *
     * Return the given text in the correct language
     *
     * @param integer $index the index of the text in the textfile
     * @return string the text in the correct language
     * @author Teye Heimans
     * @deprecated since version 4
     * @see \FormHandler\Language::get()
     */
    public function _text($index)
    {
        return \FormHandler\Language::get($index);
    }

    /**
     * FormHandler::setLanguage()
     *
     * Set the language we should use for error messages etc.
     * If no language is given, try to get the language defined by the visitors browser.
     *
     * @param string $language The language we should use
     * @return FormHandler
     * @author Teye Heimans
     * @deprecated since version 4
     * @see \FormHandler\Language::load()
     */
    public function setLanguage($language = null)
    {
        if(!is_null($language))
        {
            \FormHandler\Language::load($language);
            return $this;
        }
    }

    /**
     * FormHandler::getLanguage()
     *
     * Return the language used for the form
     *
     * @return string: the language
     * @author Teye Heimans
     * @deprecated since version 4
     * @see \FormHandler\Language::active()
     */
    public function getLanguage()
    {
        return \FormHandler\Language::active();
    }

    /**
     * Add an exclusion to the language array
     *
     * @param integer $index
     * @param string $string
     * @deprecated since version 4
     * @see \FormHandler\Language::set()
     */
    public static function languageExclusionSet($index, $string)
    {
        \FormHandler\Language::set($index, $string);
    }

    /**
     * Extend or update the FormHandler language list
     *
     * @param integer $index
     * @param string $string
     * @deprecated since version 4
     * @see \FormHandler\Language::remove()
     */
    public static function languageExclusionUnset($index)
    {
        return \FormHandler\Language::remove($index);
    }

    /**
     * FormHandler::setErrorMessage()
     *
     * @return FormHandler
     * @deprecated since version 4
     * @see Field\Field->setErrorMessage
     */
    public function setErrorMessage($field,$message)
    {
        $fld = $this->getField($field);
        if(!is_null($fld))
        {
            $fld->setErrorMessage($message);
        }
        return $this;
    }
}

/**
 * @deprecated Use \FormHandler\Configuration::set($name, $value) instead
 */
function fh_conf()
{
    if(func_num_args() == 2)
    {
        $name = str_replace('fh_', '', strtolower(func_get_arg(0)));
        FormHandler\Configuration::set($name, func_get_arg(1));
    }
}