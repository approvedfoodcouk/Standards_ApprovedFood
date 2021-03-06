<?php
/**
 * Function/CLass method length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ApprovedFood_Sniffs_Files_FunctionLengthSniff extends ApprovedFood_DataStructureLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public $maxLength = 100;
    /**
     * {@inheritdoc}
     */
    public $absoluteMaxLength = 125; 
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_FUNCTION);
    }    
}
