<?php
namespace Utility;

class AsciiTable
{
    private $data;
    private $asciiLine;
    private $headers;
    private $columnMaxLength = array();

    private $rowSeparator  = "-";
    private $columnSeparator = "|";
    private $cellSeparator = "+";
    private $additionalSpace = 6;

    /**
     * @param array $data
     */
    public function __construct($data) {
        if (!is_array($data)) {
            throw new \InvalidArgumentException("The data just accepted array.");
        }
        $this->data = $data;
        $this->generateHeader();
    }

    private function generateHeader() {
        $headers = array();
        foreach($this->data as $key => $value) {
            if (is_array($value)) {
                $headers = array_merge($headers, $value);
            }
        }
        $this->headers = array_keys($headers);

        //calculate max length for each column
        foreach ($this->headers as $header) {
            foreach($this->data as $value) {
                if (is_array($value)) {
                    $maxLength = !empty($this->columnMaxLength[$header])? $this->columnMaxLength[$header] : $this->additionalSpace;
                    if (!empty($value[$header])) {
                        $dataLength = strlen($value[$header]) + $this->additionalSpace;
                        $this->columnMaxLength[$header] = ($maxLength > $dataLength)? $maxLength : $dataLength;
                    }
                }
            }
        }

        //generate line separator
        $this->asciiLine = $this->cellSeparator;
        foreach ($this->headers as $header) {
            $this->asciiLine .= str_pad("", $this->columnMaxLength[$header], $this->rowSeparator) . $this->cellSeparator;
        }
        $this->asciiLine .= "\n";
    }

    /**
     * @return string
     */
    public function render() {
        if (count($this->data) == 0) {
            return "";
        }

        $result = $this->asciiLine;
        $result .= $this->cellSeparator;
        foreach ($this->headers as $header) {
            $result .= str_pad($header, $this->columnMaxLength[$header], " ", STR_PAD_BOTH) . $this->columnSeparator;
        }
        $result .= "\n";

        foreach($this->data as $value) {
            if (is_array($value)) {
                $result .= $this->asciiLine;
                $result .= $this->cellSeparator;
                foreach ($this->headers as $header) {
                    if (!empty($value[$header])) {
                        $result .= str_pad(" " . $value[$header], $this->columnMaxLength[$header], " ", STR_PAD_RIGHT) . $this->columnSeparator;
                    } else {
                        $result .= str_pad("", $this->columnMaxLength[$header], " ", STR_PAD_RIGHT) . $this->columnSeparator;
                    }
                }
                $result .= "\n";
            }
        }

        $result .= $this->asciiLine;

        return $result;
    }
}