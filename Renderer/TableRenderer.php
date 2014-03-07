<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;
//use Da\StatBundle\Data\TableData;
use Da\StatBundle\Data\AssociativeDefinedData;

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
		return 
			(
				$data instanceof AssociativeDefinedData
			);
	}

	/**
     * {@inheritdoc}
     */
	public function render(DataInterface $data)
	{
		$renderingDescription = array
			(
                'type' => 'Table',
				'values' => $data->getValues(),
			);
		return $renderingDescription;
	}
}