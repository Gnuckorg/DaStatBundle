<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\AssociativeData;
use Da\StatBundle\Data\ArrayListData;
use Da\StatBundle\Data\ListData;
use Da\StatBundle\Data\SeriesData;
use Da\StatBundle\Data\TableData;

/**
 * Table renderer.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class TableRenderer extends AbstractRenderer
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'da.widget';
    }

    /**
     * {@inheritdoc}
     */
    public function supports(DataInterface $data)
    {
        return (
            $data instanceof AssociativeData ||
            $data instanceof ArrayListData ||
            $data instanceof ListData ||
            $data instanceof SeriesData ||
            $data instanceof TableData
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render(DataInterface $data)
    {
        $renderingDescription = array(
            'type' => 'Table',
            'values' => $data->getValues(),
        );

        if ($data->hasOption('tableId')) {
            $renderingDescription['tableId'] = $data->getOption('tableId');
        }

        if ($data->hasOption('tableClass')) {
            $renderingDescription['tableClass'] = $data->getOption('tableClass');
        }

        return $renderingDescription;
    }
}