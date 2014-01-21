<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CrudGenerator\MetaData\MetaDataSourceFactory;
use CrudGenerator\MetaData\Config\ConfigException;
use CrudGenerator\Generators\Questions\MetaDataSourcesQuestionFactory;
use CrudGenerator\Generators\Questions\MetaDataQuestionFactory;
use CrudGenerator\Generators\Questions\GeneratorQuestionFactory;
use CrudGenerator\Generators\Parser\GeneratorParserFactory;
use CrudGenerator\Context\WebContext;
use CrudGenerator\Generators\GeneratorDataObject;

$app->match('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('homepage');

$app->match('/list-backend', function() use ($app) {

    $context       = new WebContext($app);
    $backendFinder = MetaDataSourcesQuestionFactory::getInstance($context);

    return $app->json(array('backend' => $backendFinder->ask()), 201);
})->bind('list-backend');

$app->match('/list-generator', function() use ($app) {

    $context         = new WebContext($app);
    $generatorFinder = GeneratorQuestionFactory::getInstance($context);

    return $app->json(array('generators' => $generatorFinder->ask()), 201);
})->bind('list-generator');

// on choice metadata
$app->match('/metadata', function (Request $request) use ($app) {
    $backendString = $request->request->get('backend');

    $context        = new WebContext($app);
    $backendFinder  = MetaDataSourcesQuestionFactory::getInstance($context);
    $metadataFinder = MetaDataQuestionFactory::getInstance($context);

    $metadataSource = $backendFinder->ask($backendString);

    return $app->json(array('metadatas' => $metadataFinder->ask($metadataSource)), 201);
})->bind('metadata');

$app->match('generator', function (Request $request) use ($app) {

    parse_str($request->request->get('questions'), $questionArray);
    $metadataSource = $request->request->get('backend');
    $metadata       = $request->request->get('metadata');
    $context        = new WebContext($app);

    $generatorParser        = GeneratorParserFactory::getInstance($context);
    $matadataSourceFinder   = MetaDataSourcesQuestionFactory::getInstance($context);
    $metadataFinder         = MetaDataQuestionFactory::getInstance($context);

    $metadataSourceSelect   = $matadataSourceFinder->ask($metadataSource);
    $metaData               = $metadataFinder->ask($metadataSourceSelect, $metadata);

    $generator = new GeneratorDataObject();
    $generator->setName($request->request->get('generator'));

    $generator = $generatorParser->init($generator, $metaData, $questionArray);

    return $app->json(array('generator' => $generator), 201);
});

$app->match('view-file', function (Request $request) use ($app) {

    parse_str($request->request->get('questions'), $questionArray);
    $metadataSource = $request->request->get('backend');
    $metadata       = $request->request->get('metadata');
    $file           = $request->request->get('file');
    $context        = new WebContext($app);

    $generatorParser        = GeneratorParserFactory::getInstance($context);
    $matadataSourceFinder   = MetaDataSourcesQuestionFactory::getInstance($context);
    $metadataFinder         = MetaDataQuestionFactory::getInstance($context);

    $metadataSourceSelect   = $matadataSourceFinder->ask($metadataSource);
    $metaData               = $metadataFinder->ask($metadataSourceSelect, $metadata);

    $generator = new GeneratorDataObject();
    $generator->setName($request->request->get('generator'));

    $generator = $generatorParser->init($generator, $metaData, $questionArray);

    return $app->json(array('generator' => $generatorParser->viewFile($generator, $file)), 201);
});

$app->match('metadata-save', function (Request $request) use ($app) {

    $formDatas             = $request->request->get('form');
    $backendString         = isset($formDatas['Backend']) ? $formDatas['Backend'] : null;
    $context         = new WebContext($app);
    $backendFinder   = MetaDataSourcesQuestionFactory::getInstance($context);
    $backendSelect   = $backendFinder->ask($request->request->get('backend'));
    $metadataSourceFactory = new MetaDataSourceFactory();

    $configReader = CrudGenerator\MetaData\Config\MetaDataConfigReaderFormFactory::getInstance($app);
    try {
        $metadataSourceConfigured = $configReader->write($backendSelect->getConfig(), $formDatas);
        $configReader->isValid($metadataSourceConfigured);
        $metadataSourceFactory->create($backendSelect->getFactory(), $metadataSourceConfigured);
        return $app->json(array('valid' => true), 201);
    } catch (ConfigException $e) {
        return $app->json(array('error' => $e->getMessage()), 201);
    }


})->bind('metadata-save');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    var_dump($e);exit;

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