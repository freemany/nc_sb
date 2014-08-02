<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/2/14
 * Time: 12:29 PM
 */

namespace Application\Validator\File;

use Zend\Validator\File\Extension as ZExtension;

class Extension extends ZExtension
{
    /**
     * Returns true if and only if the file extension of $value is included in the
     * set extension list
     *
     * @param  string|array $value Real file to check for extension
     * @param  array        $file  File data from \Zend\File\Transfer\Transfer (optional)
     * @return bool
     */
    public function isValid($value, $file = null)
    {
        if (is_string($value) && is_array($file)) {
            // Legacy Zend\Transfer API support
            $filename = $file['name'];
            $file     = $file['tmp_name'];
        } elseif (is_array($value)) {
            if (!isset($value['tmp_name']) || !isset($value['name'])) {
                throw new Exception\InvalidArgumentException(
                    'Value array must be in $_FILES format'
                );
            }
            $file     = $value['tmp_name'];
            $filename = $value['name'];
        } else {
            $file     = $value;
            $filename = basename($file);
        }
        $this->setValue($filename);

        // Is file readable ?
        if (empty($file) || false === stream_resolve_include_path($file)) {
            //$this->error(self::NOT_FOUND);
           return false;
        }


        $extension  = substr($filename, strrpos($filename, '.') + 1);
        $extensions = $this->getExtension();

        if ($this->getCase() && (in_array($extension, $extensions))) {
            return true;
        } elseif (!$this->getCase()) {
            foreach ($extensions as $ext) {
                if (strtolower($ext) == strtolower($extension)) {
                    return true;
                }
            }
        }

        $this->error(self::FALSE_EXTENSION);
        return false;
    }
} 