<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\AssociativeData;
use Da\StatBundle\Data\ArrayListData;

/**
 * TableRenderer est la classe qui permet de rendre des données 
 * dans un tableau.
 *
 * @author Thomas Prelot
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

        return $renderingDescription;
    }
}