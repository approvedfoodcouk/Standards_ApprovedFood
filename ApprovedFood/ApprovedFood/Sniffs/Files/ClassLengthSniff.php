<?php
/**
 * Class length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ApprovedFood_Sniffs_Files_ClassLengthSniff extends ApprovedFood_DataStructureLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public $maxLength = 200;
    /**
     * {@inheritdoc}
     */
    public $absoluteMaxLength = 200; 
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_CLASS);
    }    
}
