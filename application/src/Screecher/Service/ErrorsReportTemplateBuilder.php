<?php
namespace Screecher\Service;

use Screecher\Service\Interfaces\TemplateBuilderInterface;

class ErrorsReportTemplateBuilder implements TemplateBuilderInterface
{
    protected $twigService;

    public function __construct($twigService) {
        $this->twigService = $twigService;
    }

    public function buildTemplate($messages)
    {
        return $this->twigService->render('emailErrorsReportTemplate.html.twig', ['messages' => $messages]);
    }

    public function buildSubject($name)
    {
        return sprintf("Errors for %s: Please fix!", $name);
    }
}