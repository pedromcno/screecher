<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

require __DIR__.'/routes.php';

if (isset($app_env) && in_array($app_env, array('prod','dev','test'))) {
    $app['env'] = $app_env;
} else {
    $app['env'] = 'prod';
}

require __DIR__.'/../app/config/' . $app['env'] . '.php';

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true,
    ),
    'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path' => array(__DIR__ . '/../app/views')
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
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
    return new Screecher\Service\ApiLogParser($app['api_log.path']);
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