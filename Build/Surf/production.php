<?php
use \TYPO3\Surf\Domain\Model\Workflow;
use \TYPO3\Surf\Domain\Model\Node;
use \TYPO3\Surf\Domain\Model\SimpleWorkflow;

$application = new \Famelo\Surf\SharedHosting\Application\Flow();
$application->setOption('repositoryUrl', 'https://mneuhaus@github.com/mneuhaus/Distribution.Harvoice.git');
$application->setDeploymentPath('/kunden/350350_33330/harvoi/production');
$application->setOption('keepReleases', 3);

$application->setOption('defaultContext', 'Development');
$application->setOption('composerCommandPath', 'composer');
$application->setHosting('DomainFactory/ManagedHosting');

$application->setOption('transferMethod', 'rsync');
$application->setOption('packageMethod', 'git');
$application->setOption('updateMethod', NULL);

$deployment->addApplication($application);

$workflow = new SimpleWorkflow();
$workflow->setEnableRollback(FALSE);

$workflow
	->afterTask('typo3.surf:typo3:flow:copyconfiguration', array(
		'famelo.surf.sharedhosting:downloadbeard',
		'famelo.surf.sharedhosting:beardpatch'
	), $application);

$deployment->setWorkflow($workflow);

$node = new Node('harvoi.famelo.com');
$node->setHostname('harvoi.famelo.com');
$node->setOption('username', 'ssh-350350-famelo');

$application->addNode($node);
$deployment->addApplication($application);
?>