<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\StackedColumnData;

/**
 * StackedColumnChartRenderer est la classe qui permet de rendre des données
 * dans un graphique avec des colonnes.
 *
 * @author Thomas Prelot
 */
class StackedColumnChartRenderer extends AbstractRenderer
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
				$data instanceof StackedColumnData
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
			        	'type' => 'column'
                	),
            	'tooltip' => array
                	(
                        'formatter' => "function()
                                        {
                                            return '<b>' + this.x + '</b><br/>' +
                                                this.series.name + ': '+ this.y + '<br/>'+
                                                'Total: '+this.point.stackTotal;
                                        }"
	            	),
                 'legend'=> array(
                        'backgroundColor' =>'#FFFFFF',
                        'reversed'        => false
                 ),
	           	'plotOptions' => array
	           		(
	                	'column' => array
                            (
                                'stacking'   => 'normal',
                                'dataLabels' => array
                                    (
                                        'enabled' => true,
                                        'color'   => "(Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'"
                                    ),
                            ),
	                )
			);
                        if ($data instanceof StackedColumnData) {
                        return $this->renderFromStackedColumnData($renderingDescription, $data);
        }
    }

    private function renderFromStackedColumnData($renderingDescription, StackedColumnData $data)
	{
        $items = array();
        foreach ($data->getCategories() as $k => $v) {
            $items[] = (string)$v;
        }

		$extraDescription = array
            (
            'xAxis' => array
                (
                'categories' => $items,
                'lineWidth' => 0,
            ),
            'yAxis' => array
                (
                'min' => 0,
                'title' => array(
                    'text' => $data->getYtitle(),
                ),
                'stackLabels'  => array
                    (
                        'enabled' => false,
                        'style'   => array
                            (
                                'fontWeight' => 'bold',
                                'color'      => "(Highcharts.theme && Highcharts.theme.textcolor) || 'gray'"
                            ),
                    ),
            )
        );
	    $renderingDescription = array_merge_recursive($renderingDescription, $extraDescription);

		$renderingDescription['series'] = array();
        $courrier = array();
        $stack = null;
        foreach ($data->getValues() as $name => $series) {
            foreach ($series['data'] as $key => $value) {
                if($key == 'Reçu'){
                    $stack = 1;
                }
                else {
                    $stack = 2;
                }
                $courrier[] = array
                    (
                        'name' => $key,
                        'data' => $value,
                        'stack'=> $stack
                    );
            }
            $renderingDescription['series'] = $courrier;
        }
        return $renderingDescription;
    }
}