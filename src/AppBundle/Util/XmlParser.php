<?php

namespace AppBundle\Util;

class XmlParser
{
    /**
     * Parse XML checking if it's valid and returning array element
     *
     * @param $xmlString
     * @return array|\SimpleXMLElement
     */
    public function parse($xmlString)
    {
        libxml_use_internal_errors(true);

        $doc = simplexml_load_string($xmlString);
        $xml = explode("\n", $xmlString);

        if (!$doc) {
            $errors = libxml_get_errors();

            foreach ($errors as $error) {
                dump($this->display_xml_error($error, $xml));
            }

            die;

            libxml_clear_errors();
        }

        return new \SimpleXMLElement($xmlString);
    }

    /**
     * Implementation from php.net docs
     *
     * @see https://secure.php.net/manual/en/function.libxml-get-errors.php
     *
     * @param $error
     * @param $xml
     * @return string
     */
    public function display_xml_error($error, $xml)
    {
        $return  = $xml[$error->line - 1] . "\n";
        $return .= str_repeat('-', $error->column) . "^\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "Warning $error->code: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "Error $error->code: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "Fatal Error $error->code: ";
                break;
        }

        $return .= trim($error->message) .
            "\n  Line: $error->line" .
            "\n  Column: $error->column";

        if ($error->file) {
            $return .= "\n  File: $error->file";
        }

        return "$return\n\n--------------------------------------------\n\n";
    }
}
