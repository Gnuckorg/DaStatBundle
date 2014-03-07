<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\DefinedData;
use Da\StatBundle\Data\UnitDataInterface;

/**
 * PieChartRenderer est la classe qui permet de rendre des données 
 * dans un graphique en camembert.
 *
 * @author Thomas Prelot
 */
class PieChartRenderer extends AbstractRenderer
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
	public function supports(DataInterface $data)
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
				'credits' => array
					(
                		'enabled' => false
            		),
            	'chart' => array
            		(
	                    'plotBackgroundColor' => null,
	                    'plotBorderWidth' => null,
	                    'plotShadow' => false,
	                ),
	            'tooltip' => array 
	            	(
	                    'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
	                    'percentageDecimals' => 1,
	                ),
			);

		if ($data instanceof DefinedData)
			$renderingDescription = $this->renderFromDefinedData($renderingDescription, $data);
        
        if ($data instanceof UnitDataInterface)
            $renderingDescription = $this->renderFromUnitData($renderingDescription, $data);
        
        return $renderingDescription;
	}

	private function renderFromDefinedData($renderingDescription, DefinedData $data)
	{
        $extraDescription = array
            (
            'subtitle' => array(
                'text' => $data->getSubtitle(),
            ),
            'plotOptions' => array
                (
                'pie' => array
                    (
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => array
                        (
                        'enabled' => true,
                        'formatter' => "function(label)
                            {
                                label.style.color = this.point.color;
                                label.style.fontSize = '12px';
                                return '<b>' + this.point.name +'</b>: '+ Highcharts.numberFormat(this.y, " . $data->getDecimalNumber() . ", ',') " . (($data instanceof UnitDataInterface) ? " + ' ' + this.point.unit" : "") . " + ' (' + Highcharts.numberFormat(((this.percentage * 10) / 10), 2, ',', ' ') + '%)';
                            }"
                    )
                )
            )
        );
        $renderingDescription = array_merge_recursive($renderingDescription, $extraDescription);
        
		$renderingDescription['series'] = array();
		$renderingDescription['series'][] = array
				(
					'name' => $this->translator->trans($data->getName(), array(), 'chart'),
					'type' => 'pie'
				);
		$series = array();
		foreach ($data->getValues() as $name => $value) 
		{
			$series[] = array
				(
					'name'     => $name,
					'y'        => $value,
					'sliced'   => true,
				    'selected' => true
				);
		}
		$renderingDescription['series'][0]['data'] = $series;

		return $renderingDescription;
	}
    
    private function renderFromUnitData($renderingDescription, DefinedData $data)
	{
        foreach ($renderingDescription['series'][0]['data'] as &$series)
        {
            $series['unit'] = $this->translator->trans($data->getUnit(), array(), 'chart');
        }
        
        return $renderingDescription;
	}
}