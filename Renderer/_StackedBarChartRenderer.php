// TO REDESIGN
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
class StackedBarChartRenderer extends AbstractRenderer
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
            	'tooltip' => array
                	(
                		'enabled' => true,
	                	'shared'  => true
	            	),
                 'legend'=> array(
                        'backgroundColor' =>'#FFFFFF',
                        'reversed'        => true
                 ),
	           	'plotOptions' => array
	           		(
	                	'series' => array
	                    	(
	                    		'stacking'     => 'normal',
                                'dataLabels'   => array(
                                   'enabled'  => true,
                                   'rotation' => 0,
                                   'color'    => '#FFFFFF',
                                   'align'    => 'center',
                                   'x'        => 10,
                                   'y'        => 15                                  
                                )
	                    	),
	                )
			);

            if ($data instanceof StackedBarData) {
            return $this->renderFromStackedBarData($renderingDescription, $data);
        }
	}

	private function renderFromStackedBarData($renderingDescription, StackedBarData $data)
	{
        $items = array();
        foreach ($data->getValues() as $k => $v) {
            foreach ($v['data'] as $item => $v1) {
                $items[] = $item;
            }
        }

		$extraDescription = array
            (
            'xAxis' => array
                (
                'categories' => $items,
                'labels' => array(
                    'enabled' => false,
                ),
                'lineWidth' => 0
            ),
            'yAxis' => array
                (
                'min' => 0,
                'title' => array(
                    'text' => null
                ),
                'gridLineWidth' => 0,
                'labels' => array(
                    'enabled' => false
                )
            )
        );
	    $renderingDescription = array_merge_recursive($renderingDescription, $extraDescription);

		$renderingDescription['series'] = array();

        foreach ($data->getValues() as $name => $series) {
            foreach ($series['data']['Fonds'] as $name => $value) {
                $fonds[] = array('name' => $name, 'data' => array($value));
            }
            $renderingDescription['series'] = $fonds;
        }

		return $renderingDescription;
    }
}