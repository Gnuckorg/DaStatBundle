<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\AssociativeData;

/**
 * Pie chart renderer.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
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
        return (
            $data instanceof AssociativeData
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render(DataInterface $data)
    {
        $decimalsNumber = 2;
        if ($data->hasOption('decimalsNumber')) {
            $decimalsNumber = $data->getOption('decimalsNumber');
        }

        $unit = '';
        if ($data->hasOption('unit')) {
            $unit = $data->getOption('unit');
        }

        $subtitle = '';
        if ($data->hasOption('subtitle')) {
            $subtitle = $data->getOption('subtitle');
        }

        $renderingDescription = array(
            'credits' => array(
                'enabled' => false
            ),
            'chart' => array(
                'plotBackgroundColor' => null,
                'plotBorderWidth' => null,
                'plotShadow' => false,
            ),
            'tooltip' => array(
                'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
                'percentageDecimals' => 1,
            ),
            'subtitle' => array(
                'text' => $subtitle,
            ),
            'plotOptions' => array(
                'pie' => array(
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => array(
                        'enabled' => true,
                        'formatter' => "function(label) {
                                label.style.color = this.point.color;
                                label.style.fontSize = '12px';
                                return '<b>' + this.point.name +'</b>: '+ Highcharts.numberFormat(this.y, " . $decimalsNumber . ", ',') " . (!empty($unit) ? " + ' ' + this.point.unit" : "") . " + ' (' + Highcharts.numberFormat(((this.percentage * 10) / 10), 2, ',', ' ') + '%)';
                            }"
                    )
                )
            )
        );

        if ($data->hasOption('description')) {
            $renderingDescription = array_merge_recursive($renderingDescription, $data->getOption('description'));
        }

        if ($data instanceof AssociativeData) {
            $renderingDescription = $this->renderFromAssociativeData($renderingDescription, $data);
        }

        return $renderingDescription;
    }

    private function renderFromAssociativeData($renderingDescription, AssociativeData $data)
    {
        $renderingDescription['series'] = array();
        $series = array('type' => 'pie', 'name' => '', 'data' => array());

        if ($data->getOption('label')) {
            $series['name'] = $this->translator->trans($data->getOption('label'), array(), 'chart');
        }

        foreach ($data->getValues() as $name => $value) {
            $slice = array(
                'name' => $name,
                'y' => $value
            );

            if ($data->hasOption('unit')) {
                $slice['unit'] = $this->translator->trans($data->getOption('unit'), array(), 'chart');
            }

            $series['data'][] = $slice;
        }

        $renderingDescription['series'][] = $series;

        return $renderingDescription;
    }
}