<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\DefinedData;

/**
 * PolarChartRenderer est la classe qui permet de rendre des données 
 * dans un graphique de type polaire.
 *
 * @author Thomas Prelot
 */
class PolarChartRenderer extends AbstractRenderer
{
	/**
     * {@inheritdoc}
     */
	public function getType()
	{
		return 'highcharts';
	}

	/**
     * {@inheritdoc}
     */
	public function support(DataInterface $data)
	{
		return 
			(
				$data instanceof DefinedData
			);
	}

	/**
     * {@inheritdoc}
     */
	public function render(DataInterface $data)
	{
		$renderingDescription = array
			(
				'chart' => array
					(
				        'polar' => true
				    ),

				'credits' => array
					(
                		'enabled' => false
            		),
			    
			    'pane' => array
				    (
				        'startAngle' => 0,
				        'endAngle' => 360
				    ),
			        
			    'yAxis' => array
				    (
				        'min' => 0
				    ),
			);

		if ($data instanceof DefinedData)
			return $this->renderFromDefinedData($renderingDescription, $data);
	}

	private function renderFromDefinedData($renderingDescription, DefinedData $data)
	{
		$renderingDescription['series'] = array();
		foreach ($data->getValues() as $name => $series) 
		{
			$renderingDescription['series'][] = array
				(
					'name' => $name,
					'type' => 'area',
					'data' => $series
				);
		}
		$renderingDescription['xAxis'] = array('categories' => $data->getItems());

		return $renderingDescription;
	}
}