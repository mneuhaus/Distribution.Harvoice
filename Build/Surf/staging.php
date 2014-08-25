<?php
use \TYPO3\Surf\Domain\Model\Workflow;
use \TYPO3\Surf\Domain\Model\Node;
use \TYPO3\Surf\Domain\Model\SimpleWorkflow;

$application = new \Famelo\Surf\SharedHosting\Application\Flow();
$application->setOption('repositoryUrl', 'https://mneuhaus@github.com/mneuhaus/Distribution.Harvoice.git');
$application->setDeploymentPath('/html/staging/');
$application->setOption('keepReleases', 3);

$application->setOption('defaultContext', 'Production');
$application->setOption('composerCommandPath', 'composer');
$application->setHosting('Mittwald');

$application->setOption('transferMethod', 'rsync');
$application->setOption('packageMethod', 'git');
$application->setOption('updateMethod', NULL);

$deployment->addApplication($application);

$workflow = new SimpleWorkflow();
$workflow->setEnableRollback(FALSE);

// $workflow->addTask('famelo.surf.sharedhosting:beardpatch', 'package');
// $workflow
// 	->afterTask('typo3.surf:composer:install', array(
// 		'famelo.surf.sharedhosting:downloadbeard',
// 		'famelo.surf.sharedhosting:beardpatch'
// 	), $application);

$deployment->setWorkflow($workflow);

$node = new Node('p234273.mittwaldserver.info');
$node->setHostname('p234273.mittwaldserver.info');
$node->setOption('username', 'p234273');

$application->addNode($node);
$deployment->addApplication($application);
?>