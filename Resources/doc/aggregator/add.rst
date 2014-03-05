Ajouter un nouvel aggrégateur
=============================

Pour ajouter un nouvel aggrégateur, il suffit de créer une classe qui implémente 
l'interface AggregatorInterface (le code suivant suppose que vous vous trouviez 
dans le répertoire standard de définition des classes d'aggrégateurs et utilise 
des conventions par défaut):

.. code-block:: php

    // /src/Da/StatBundle/Core/Aggregator/MyAggregator.php
    namespace Da\StatBundle\Aggregator;

    /**
     * MyAggregator est la classe qui permet de sélectionner
     * et d'aggréger les données relatives à ...
     *
     * @author Me
     */
    class MyAggregator implements AggregatorInterface
    {
        // Implémentation...
    }

Puis de le déclarer comme service:

.. configuration-block::

    .. code-block:: yaml

        # /src/Da/StatBundle/Resources/config/services.yml
        da.stat.aggregator.my:
            class: Da\StatBundle\Aggregator\MyAggregator
            arguments: []
            tags:
                - { name: da.stat.aggregator }