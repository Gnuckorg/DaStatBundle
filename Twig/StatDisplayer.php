<?php

namespace Da\StatBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Da\StatBundle\Mediator\StatMediatorInterface;

/**
 * StatDisplayer is a basic împlementation of a displayer
 * for the statistics.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class StatDisplayer implements StatDisplayerInterface
{
	/**
     * The templating engine.
     *
     * @var EngineInterface
     */
    private $templatingEngine;

    /**
     * The mediator of the statistics mechanism.
     *
     * @var StatMediatorInterface
     */
    private $mediator;

	/**
     * Constructor.
     *
     * @param EngineInterface $templatingEngine The templating engine.
     */
    public function __construct(EngineInterface $templatingEngine, StatMediatorInterface $mediator)
    {
        $this->templatingEngine = $templatingEngine;
        $this->mediator = $mediator;
    }

    /**
     * {@inheritdoc}
     */
    public function displayStat($id)
    {
    	try {
    		$assembly = $this->mediator->getAssembly($id);

    		return $this->templatingEngine->render(
	    		'DaStatBundle::stat.html.twig',
	    		array('assembly' => $assembly, 'assemblyId' => $id)
	    	);
    	} catch (\LogicException $exception) {
    		// Check the existence of the stat.
    		$this->mediator->getStat($id);

	    	return $this->templatingEngine->render(
	    		'DaStatBundle::stat.html.twig',
	    		array('statId' => $id, 'assemblyId' => '')
	    	);
	    }
    }
}