<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30/06/15
 * Time: 14:07
 */

namespace Screecher\Service;

use Screecher\Service\Interfaces\EmailProviderInterface;
use Screecher\Repository\ApiRepository;
use Screecher\Service\Interfaces\TemplateBuilderInterface;


class ErrorsProcessor
{

    protected $emailProvider;

    protected $apiRepository;

    protected $templateBuilder;

    public function __construct(
        EmailProviderInterface $emailProvider,
        ApiRepository $apiRepository,
        TemplateBuilderInterface $templateBuilder
    )
    {
        $this->emailProvider = $emailProvider;

        $this->apiRepository = $apiRepository;

        $this->templateBuilder = $templateBuilder;
    }


    public function processErrors($errorMessages)
    {
        $apiMaintainers = $this->apiRepository->findAllByNames(array_keys($errorMessages));

        $responseData = [];

        foreach ($errorMessages as $apiName => $errors) {
            $template = $this->templateBuilder->buildTemplate($errors);
            $subject = $this->templateBuilder->buildSubject($apiName);
            $sendTo = $apiMaintainers[$apiName];

            $responseData[$apiName] = $this->emailProvider->sendEmail($subject, $template, $sendTo);
        }

        return ['emailProviderResponse' => $responseData, 'errors' => $errorMessages];
    }

}