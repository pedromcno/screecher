<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true,
    ),
    'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path' => array(__DIR__ . '/../app/views')
));

// Register repositories.
$app['repository.api'] = $app->share(function ($app) {
    return new Screecher\Repository\ApiRepository($app['db']);
});
$app['repository.maintainer'] = $app->share(function ($app) {
    return new Screecher\Repository\MaintainerRepository($app['db']);
});

// Register custom services.
$app['parser.api_log'] = $app->share(function ($app) {
    return new Screecher\Service\ApiLogParser();
});

$app['processor.errors'] = $app->share(function ($app) {
   return new Screecher\Service\ErrorsProcessor(
       $app['mandrill.adapter'],
       $app['repository.api'],
       $app['template_builder.errors_template']
   );
});

$app['email.builder'] = $app->share(function ($app) {
   return new Screecher\Service\ErrorsTemplateBuilder();
});

$app['mandrill.adapter'] = $app->share(function ($app) {
    return new Screecher\Service\MandrillAdapter($app['mandrill.settings']);
});

$app['template_builder.errors_template'] = $app->share(function ($app) {
   return new Screecher\Service\ErrorsReportTemplateBuilder($app['twig']);
});

// Register the error handler.
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }
    return new Response($message, $code);
});

return $app;