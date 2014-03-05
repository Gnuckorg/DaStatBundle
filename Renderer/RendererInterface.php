<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;

/**
 * RendererInterface est l'interface qu'un gestionnaire de rendu doit 
 * implémenter pour être utilisée par le service da.stat.handler.
 *
 * @author Thomas Prelot
 */
interface RendererInterface
{
     /**
      * Récupère le type de gestionnaire de rendu. Ce dernier est utilisé
      * pour les labels et le traitement javascript d'affichage.
      *
      * @return string Le type de gestionnaire de rendu.
      */
     function getType();

	/**
      * Vérifie si la classe supporte ce type de données.
      *
      * @param DataInterface $data La donnée.
      *
      * @return array True si la classe supporte ce type de données.
      */
	function support(DataInterface $data);

	/**
      * Fabrique la description du rendu d'une donnée.
      *
      * @param DataInterface $data La donnée.
      *
      * @return array La description du rendu.
      */
	function render(DataInterface $data);
}