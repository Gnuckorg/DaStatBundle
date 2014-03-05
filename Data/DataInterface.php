<?php

namespace Da\StatBundle\Data;

/**
 * DataInterface est l'interface d'une donnée que s'échange 
 * un aggrégateur et un gestionnaire de rendu.
 *
 * @author Thomas Prelot
 */
interface DataInterface
{
	/**
      * Récupère les valeurs de la donnée.
      *
      * @return array Les valeurs.
      */
	function getValues();
}