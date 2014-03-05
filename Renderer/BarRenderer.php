<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\StackedBarData;

/**
 * ColumnChartRenderer est la classe qui permet de rendre des données 
 * dans un graphique avec des colonnes.
 *
 * @author Thomas Prelot
 */
class BarRenderer extends AbstractRenderer
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
				$data instanceof StackedBarData
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
			        	'type' => 'bar'
                	),	
			);

            if ($data instanceof StackedBarData) {
            return $this->renderFromStackedBarData($renderingDescription, $data);
        }
	}

	private function renderFromStackedBarData($renderingDescription, StackedBarData $data)
	{
        $items = array();
        $unit = $data->getUnit();
        
        foreach ($data->getValues() as $k => $v) {
            foreach ($v['data'] as $item => $v1) {
                $items[] = $item;
            }
        }

		$extraDescription = array
            (
            'xAxis' => array (
                'categories' => $items,
            ),
            'yAxis' => array (
                'min' => 0,
                'title' => array (
                    'text' => $data->getTitle(),
                    'align' => 'high'
                ),
                'labels' => array (
                    'overflow' => 'justify'
                )
            ),
            'plotOptions' => array (
                'series' => array
                    (
                       'dataLabels' => array(
                            'enabled' => true,
                            'formatter' => "function () {
                                        return Math.round(this.y) + '$unit'
                                    }" ,
                            'style' => array
                                (
                                'fontWeight' => 'bold',
                                'color' => 'gray'
                                )
                        )
                    ),
            ),
            'tooltip' => array (
                'enabled' => true,
                'shared' => true,
                'valueSuffix' => $unit,
            ),
        );
        
	    $renderingDescription = array_merge_recursive($renderingDescription, $extraDescription);

		$renderingDescription['series'] = array();
        foreach ($data->getValues() as $name => $series) {
            $data = array();
            foreach ($series['data'] as $d => $value) {
                $data[] = array($d, $value);
            }

            $renderingDescription['series'][] = array
                (
                'name' => $this->translator->trans($name, array(), 'chart'),
                'data' => $data,
                'type' => $series['type']
            );
		}

		return $renderingDescription;
    }
}