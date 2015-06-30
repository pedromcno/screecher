<?php
namespace Screecher\Service\Interfaces;


/**
 * Interface TemplateBuilderInterface
 * @package Screecher\Service\Interfaces
 */
interface TemplateBuilderInterface
{

    /**
     * @param $templateData
     * @return mixed
     */
    public function buildTemplate($templateData);

}