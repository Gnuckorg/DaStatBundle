<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Data\MapData;

/**
 * MapRenderer est la classe qui permet de rendre des données 
 * dans une carte.
 *
 * @author Thomas Prelot
 */
class MapRenderer extends AbstractRenderer
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
		return 
			(
				$data instanceof MapData
			);
	}

	/**
     * {@inheritdoc}
     */
	public function render(DataInterface $data)
	{
		$renderingDescription = array
			(
                'type' => 'Map',
				'values' => $data->getValues()
			);
		return $renderingDescription;
	}
}