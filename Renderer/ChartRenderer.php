<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\TypedSeriesDatedData;
use Da\StatBundle\Data\TypedSeriesDefinedData;

/**
 * ColumnChartRenderer est la classe qui permet de rendre des données
 * dans un graphique avec des colonnes.
 *
 * @author Thomas Prelot
 */
class ChartRenderer extends AbstractRenderer
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
				$data instanceof TypedSeriesDefinedData ||
				$data instanceof TypedSeriesDatedData
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
			        	'spacingRight' => 20
                	),
				'credits' => array
					(
                		'enabled' => false
            		),
			);

		if ($data instanceof TypedSeriesDefinedData)
			return $this->renderFromTypedSeriesDefinedData($renderingDescription, $data);
		else if ($data instanceof TypedSeriesDatedData)
			return $this->renderFromTypedSeriesDatedData($renderingDescription, $data);
	}

	private function renderFromTypedSeriesDefinedData($renderingDescription, TypedSeriesDefinedData $data)
	{
		$renderingDescription['series'] = array();
		foreach ($data->getValues() as $name => $series)
		{
			$renderingDescription['series'][] = array
				(
					'name' => $this->translator->trans($name, array(), 'chart'),
					'data' => $series['data'],
					'type' => $series['type']
				);
		}

		$items = array();
		foreach ($data->getItems() as $item)
		{
			$items[] = $this->translator->trans($item, array(), 'chart');
		}
		$renderingDescription['xAxis'] = array('categories' => $items);

		return $renderingDescription;
	}

	private function renderFromTypedSeriesDatedData($renderingDescription, TypedSeriesDatedData $data)
	{
		$extraDescription = array
            (
            'tooltip' => array
                (
                'crosshairs' => true,
                'shared' => true,
//                'formatter' => "function(label)
//                    {
//                        return Highcharts.numberFormat(this.y, " . $data->getDecimalNumber() . ", ',');
//                    }"
            ),
            'chart' => array
                (
                'zoomType' => 'x',
            ),
            'subtitle' => array
                (
                'text' => '(function () { return (document.ontouchstart === undefined ? "'
                . $this->translator->trans('stat.label.zoom.pc', array(), 'stat') . '" : "'
                . $this->translator->trans('stat.label.zoom.mobile', array(), 'stat') . '"); })()'
            ),
            'xAxis' => array
                (
                'type' => 'datetime',
                'maxZoom' => 14 * 24 * 3600000, // fourteen days
//                        'tickPositioner' => 'function () {
//                                return this.series[0].xData;
//                            }',
                'labels' => array
                    (
                    'formatter' => 'function() {
                                         return Highcharts.dateFormat(\'%d %b\', this.value);
                                     }'
                )
            ),
            'plotOptions' => array
                (
                'areaspline' => array
                    (
                    'fillColor' => array
                        (
                        'linearGradient' => array('x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 1),
                        'stops' => array
                            (
                            array(0, '(function () { return Highcharts.Color(Highcharts.getOptions().colors[1]).setOpacity(0.1).get("rgba"); })()'),
                            array(1, '(function () { return Highcharts.Color(Highcharts.getOptions().colors[1]).setOpacity(0).get("rgba"); })()')
                        )
                    )
                ),
                'lineWidth' => 2,
                'marker' => array
                    (
                    'enabled' => false
                ),
                'shadow' => false,
                'states' => array
                    (
                    'hover' => array
                        (
                        'lineWidth' => 3
                    )
                ),
                'threshold' => null,
                'series' => array
                    (
                    'dataLabels' => array(
                        'enabled' => true,
                        'style' => array
                            (
                            'fontWeight' => 'bold',
                            'color' => 'gray'
                        ),
                        'formatter' => "function(label)
                            {
                                return Highcharts.numberFormat(this.y, " . $data->getDecimalNumber() . ", ',');
                            }"
                    )
                ),
            )
        );
	    $renderingDescription = array_merge_recursive($renderingDescription, $extraDescription);

		$renderingDescription['series'] = array();
		foreach ($data->getValues() as $name => $series)
		{
			$data = array();
			foreach ($series['data'] as $date => $value)
			{
				$datetime = \DateTime::createFromFormat('U', $date);
				$data[] = array('(function () { return Date.UTC('.$datetime->format('Y,').($datetime->format('m') - 1).$datetime->format(',d').'); })()', $value);
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