<?php
use \TYPO3\Surf\Domain\Model\Workflow;
use \TYPO3\Surf\Domain\Model\Node;
use \TYPO3\Surf\Domain\Model\SimpleWorkflow;

$application = new \Famelo\Surf\SharedHosting\Application\Flow();
$application->setOption('repositoryUrl', 'https://mneuhaus@github.com/mneuhaus/Distribution.Harvoice.git');
$application->setDeploymentPath('/html/development');
$application->setOption('keepReleases', 3);

$application->setOption('defaultContext', 'Development');
$application->setContext('Development');
$application->setOption('composerCommandPath', 'composer');
$application->setHosting('Mittwald');

$application->setOption('transferMethod', 'rsync');
$application->setOption('packageMethod', 'git');
$application->setOption('updateMethod', NULL);

$workflow = new SimpleWorkflow();
$workflow->setEnableRollback(FALSE);

$workflow->defineTask('famelo.harvest:resourcepublish',
	'typo3.surf:shell',
	array('command' => 'cd {releasePath} && ./flow typo3.flow:resource:publish')
);

$workflow->addTask('famelo.harvest:resourcepublish', 'finalize', $application);

$deployment->setWorkflow($workflow);
$deployment->addApplication($application);

$node = new Node('p234273.mittwaldserver.info');
$node->setHostname('p234273.mittwaldserver.info');
$node->setOption('username', 'p234273');

$application->addNode($node);
$deployment->addApplication($application);
?>