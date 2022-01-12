<?php
namespace Core\Validations;

use Core\Messenger;

use Core\Database\Model;

trait Validate
{
    /**
     * Regex Pattern
     * @return string
     */
    private $_regexPatterns = [
        'num'           => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int'           => '/^[0-9]+$/',
        'float'         => '/^[0-9]+\.[0-9]+$/',
        'alpha'         => '/^[a-zA-ZÜüÄäÖöß\p{Arabic} ]+$/u',
        'alphadash'     => '/^[a-zA-ZÜüÄäÖöß1-9.]+$/u',
        'alphanum'      => '/^[a-zA-ZÜüÄäÖöß.!,-:?€+$@^\/\p{Arabic}0-9 ]+$/u',
        'vdate'         => '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:(?:1|2)[0-9])|(?:3[0-1]))$/',
        'email'         => '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
        'url'           => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
    ];

    /**
     * Document Teype Array
     * [word], [excel], [pdf], [txt]
     * @return string
     */
    private $_acceptedDocument = [
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'application/pdf',
      'text/plain'
    ];

    public function req($value)
    {
        return '' != $value || !empty($value);
    }

    public function num($value)
    {
        return (bool) preg_match($this->_regexPatterns['num'], $value);
    }

    public function int($value)
    {
        return (bool) preg_match($this->_regexPatterns['int'], $value);
    }

    public function float($value)
    {
        return (bool) preg_match($this->_regexPatterns['float'], $value);
    }

    public function alpha($value)
    {
        return (bool) preg_match($this->_regexPatterns['alpha'], $value);
    }

    public function alphanum($value)
    {
        return (bool) preg_match($this->_regexPatterns['alphanum'], $value);
    }

    public function alphadash($value)
    {
        return (bool) preg_match($this->_regexPatterns['alphadash'], $value);
    }

    public function eq($value, $matchAgainst)
    {
        return $value == $matchAgainst;
    }

    public function eq_field($value, $otherFieldValue)
    {
        return $value == $otherFieldValue;
    }

    public function lt($value, $matchAgainst)
    {
        if (is_string($value)) {
            return mb_strlen($value) < $matchAgainst;
        } elseif (is_numeric($value)) {
            return $value < $matchAgainst;
        }
    }

    public function gt($value, $matchAgainst)
    {
        if (is_string($value)) {
            return mb_strlen($value) > $matchAgainst;
        } elseif (is_numeric($value)) {
            return $value > $matchAgainst;
        }
    }

    public function min($value, $min)
    {
        if (is_string($value)) {
            return mb_strlen($value) >= $min;
        } elseif (is_numeric($value)) {
            return $value >= $min;
        }
    }

    public function max($value, $max)
    {
        if (is_string($value)) {
            return mb_strlen($value) <= $max;
        } elseif (is_numeric($value)) {
            return $value <= $max;
        }
    }

    public function between($value, $min, $max)
    {
        if (is_string($value)) {
            return mb_strlen($value) >= $min && mb_strlen($value) <= $max;
        } elseif (is_numeric($value)) {
            return $value >= $min && $value <= $max;
        }
    }

    public function floatlike($value, $beforeDP, $afterDP)
    {
        if (!$this->float($value)) {
            return false;
        }
        $pattern = '/^[0-9]{' . $beforeDP . '}\.[0-9]{' . $afterDP . '}$/';
        return (bool) preg_match($pattern, $value);
    }

    public function vdate($value)
    {
        return (bool) preg_match($this->_regexPatterns['vdate'], $value);
    }

    public function vdate_after($value, $after)
    {
        return (bool) $value > $after;
    }

    public function vdate_before($value, $before)
    {
        return (bool) $value < $before;
    }

    public function email($value)
    {
        return (bool) preg_match($this->_regexPatterns['email'], $value);
    }

    public function url($value)
    {
        return (bool) preg_match($this->_regexPatterns['url'], $value);
    }

    public function selectbox($value)
    {
        return '' != $value || !empty($value);
    }


    public function accepted($value)
    {
        return '' != $value || !empty($value);
    }


    public function isValid($roles, $inputType = null)
    {
        $inputType = ($inputType == null) ? $_POST : $_GET ;
        $errors = [];
        if (!empty($roles)) {
            foreach ($roles as $fieldName => $validationRoles) {
                $niceName     = $validationRoles[0];
                if ($niceName == 'file') {
                    $inputType = $_FILES;
                }
                $validateRole = $validationRoles[1];
                //assign input value to ariable
                $value = $inputType[$fieldName];
                $validateRole = explode('|', $validateRole);
                $firstReg = $validateRole[0];
                // This Foreach will be check Jsut if the first validatekay Is req or not
                if ($firstReg == 'req') {
                    foreach ($validateRole as $validateKay) {
                        if (array_key_exists($fieldName, $errors)) {
                            continue;
                        }
                        if ($niceName == 'file') {
                            if ($this->req($inputType[$fieldName]['name']) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_req', [$this->language->get('lang_labels_'.$fieldName)]),
                                );
                                $errors[$fieldName] = true;
                            }
                            // validation for image type
                            elseif (preg_match_all('/(image)/', $validateKay)) {
                                $type = explode('/', $inputType[$fieldName]['type']);
                                if ($type[0] !== 'image') {
                                    $this->errors->add(
                                        $fieldName,
                                        'file must be a image'
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                            // validation for video type
                            elseif (preg_match_all('/(video)/', $validateKay)) {
                                $type = explode('/', $inputType[$fieldName]['type']);
                                if ($type[0] !== 'video') {
                                    $this->errors->add(
                                        $fieldName,
                                        'The Files must be a video only'
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                            // validation for application type
                            elseif (preg_match_all('/(document)/', $validateKay)) {
                                $type = $inputType[$fieldName]['type'];
                                if (!(in_array($type, $this->_acceptedDocument))) {
                                    $this->errors->add(
                                        $fieldName,
                                        'The Files must be a [word], [excel], [PDF], [txt] only',
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                        }
                        //Perg Match For min Kay
                        if (preg_match_all('/(min)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->min($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For max Kay
                        elseif (preg_match_all('/(max)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->max($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For lt Kay
                        elseif (preg_match_all('/(lt)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->lt($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For gt Kay
                        elseif (preg_match_all('/(gt)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->gt($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For between Kay
                        elseif (preg_match_all('/(between)\((\d+),(\d+)\)/', $validateKay, $m)) {
                            if ($this->between($value, $m[2][0], $m[3][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0], $m[3][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For floatlike Kay
                        elseif (preg_match_all('/(floatlike)\((\d+),(\d+)\)/', $validateKay, $m)) {
                            if ($this->floatlike($value, $m[2][0], $m[3][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0], $m[3][0]])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For eq Kay
                        elseif (preg_match_all('/(eq)\((\w+)\)/', $validateKay, $m)) {
                            if ($this->eq($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0]])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For eq_field Kay
                        elseif (preg_match_all('/(eq_field)\((\w+)\)/', $validateKay, $m)) {
                            $otherFieldValue = $inputType[$m[2][0]];
                            if ($this->eq_field($value, $otherFieldValue) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $this->language->get('lang_labels_'.$m[2][0])])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For vdate_after Kay
                        elseif (preg_match_all('/(vdate_after)\((\d+-\d+-\d+)\)/', $validateKay, $m)) {
                            if ($this->vdate_after($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0]])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For vdate_before Kay
                        elseif (preg_match_all('/(vdate_before)\((\d+-\d+-\d+)\)/', $validateKay, $m)) {
                            if ($this->vdate_before($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0]])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For unique Kay
                        elseif (preg_match_all('/(unique)\(([a-zA-Z_-]+),([a-zA-Z_-]+),([a-z0-9]+)\)$/', $validateKay, $m)) {
                            if ($m[4][0] == 'null') {
                                $exists = Model::ValidateExists($m[2][0], $m[3][0], $value);
                                if ($exists) {
                                    $this->errors->add(
                                        $fieldName,
                                        $this->language->feedKey('validate_exists', [$this->language->get('lang_labels_username'), $value])
                                    );
                                    $errors[$fieldName] = true;
                                }
                            } else {
                                $exists = Model::ValidateExists($m[2][0], $m[3][0], $value, $m[4][0]);
                                if ($exists) {
                                    $this->errors->add(
                                        $fieldName,
                                        $this->language->feedKey('validate_exists', [$this->language->get('lang_labels_username'), $value])
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                        }
                        //Perg Match For All Kay
                        else {
                            if ($niceName !== 'file') {
                                if ($this->$validateKay($value) === false) {
                                    $this->errors->add(
                                        $fieldName,
                                        $this->language->feedKey('validate_'.$validateKay, [$this->language->get('lang_labels_'.$fieldName)])
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                        }
                    }
                    // This Foreach Will Be Check Jsut If The First Validatekay Is Not Req And There Ara Another Roles Given
                } elseif ($firstReg !== 'req' && !empty($value)) {
                    foreach ($validateRole as $validateKay) {
                        if (array_key_exists($fieldName, $errors)) {
                            continue;
                        }
                        if ($niceName == 'file') {
                            if ($this->req($inputType[$fieldName]['name']) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_req', [$this->language->get('lang_labels_'.$fieldName)]),
                                );
                                $errors[$fieldName] = true;
                            }
                            // validation for image type
                            elseif (preg_match_all('/(image)/', $validateKay)) {
                                $type = explode('/', $inputType[$fieldName]['type']);
                                if ($type[0] !== 'image') {
                                    $this->errors->add(
                                        $fieldName,
                                        'file must be a image'
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                            // validation for video type
                            elseif (preg_match_all('/(video)/', $validateKay)) {
                                $type = explode('/', $inputType[$fieldName]['type']);
                                if ($type[0] !== 'video') {
                                    $this->errors->add(
                                        $fieldName,
                                        'The Files must be a video only'
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                            // validation for application type
                            elseif (preg_match_all('/(document)/', $validateKay)) {
                                $type = $inputType[$fieldName]['type'];
                                if (!(in_array($type, $this->_acceptedDocument))) {
                                    $this->errors->add(
                                        $fieldName,
                                        'The Files must be a [word], [excel], [PDF], [txt] only',
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                        }
                        //Perg Match For min Kay
                        if (preg_match_all('/(min)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->min($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For max Kay
                        elseif (preg_match_all('/(max)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->max($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For lt Kay
                        elseif (preg_match_all('/(lt)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->lt($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For gt Kay
                        elseif (preg_match_all('/(gt)\((\d+)\)/', $validateKay, $m)) {
                            if ($this->gt($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For between Kay
                        elseif (preg_match_all('/(between)\((\d+),(\d+)\)/', $validateKay, $m)) {
                            if ($this->between($value, $m[2][0], $m[3][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0], $m[3][0],$this->language->get('validate_datatype_'. $niceName)])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For floatlike Kay
                        elseif (preg_match_all('/(floatlike)\((\d+),(\d+)\)/', $validateKay, $m)) {
                            if ($this->floatlike($value, $m[2][0], $m[3][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0], $m[3][0]])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For eq Kay
                        elseif (preg_match_all('/(eq)\((\w+)\)/', $validateKay, $m)) {
                            if ($this->eq($value, $m[2][0]) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $m[2][0]])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For eq_field Kay
                        elseif (preg_match_all('/(eq_field)\((\w+)\)/', $validateKay, $m)) {
                            $otherFieldValue = $inputType[$m[2][0]];
                            if ($this->eq_field($value, $otherFieldValue) === false) {
                                $this->errors->add(
                                    $fieldName,
                                    $this->language->feedKey('validate_'.$m[1][0], [$this->language->get('lang_labels_'.$fieldName), $this->language->get('lang_labels_'.$m[2][0])])
                                );
                                $errors[$fieldName] = true;
                            }
                        }
                        //Perg Match For unique Kay
                        elseif (preg_match_all('/(unique)\(([a-zA-Z_-]+),([a-zA-Z_-]+),([a-z0-9]+)\)$/', $validateKay, $m)) {
                            if ($m[4][0] == 'null') {
                                $exists = Model::ValidateExists($m[2][0], $m[3][0], $value);
                                if ($exists) {
                                    $this->errors->add(
                                        $fieldName,
                                        $this->language->feedKey('validate_exists', [$this->language->get('lang_labels_username'), $value])
                                    );
                                    $errors[$fieldName] = true;
                                }
                            } else {
                                $exists = Model::ValidateExists($m[2][0], $m[3][0], $value, $m[4][0]);
                                if ($exists) {
                                    $this->errors->add(
                                        $fieldName,
                                        $this->language->feedKey('validate_exists', [$this->language->get('lang_labels_username'), $value])
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                        }
                        //Perg Match For All Kay
                        else {
                            if ($niceName !== 'file') {
                                if ($this->$validateKay($value) === false) {
                                    $this->errors->add(
                                        $fieldName,
                                        $this->language->feedKey('validate_'.$validateKay, [$this->language->get('lang_labels_'.$fieldName)])
                                    );
                                    $errors[$fieldName] = true;
                                }
                            }
                        }
                    }
                }
            }
        }
        return empty($errors) ? true : false;
    }
}
