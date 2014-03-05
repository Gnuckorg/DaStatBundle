Modifier le gestionnaire principal
==================================

Remplacer
---------

Pour remplacer le gestionnaire principal, il suffit de créer une classe qui implémente 
l'interface StatHandlerInterface:

.. code-block:: php

    // /src/My/OwnBundle/ClassNamespace/MyStatHandler.php
    namespace My\OwnBundle\ClassNamespace;

    use Da\StatBundle\Handler\StatHandlerInterface;
    use Da\StatBundle\Aggregator\AggregatorInterface;
    use Da\StatBundle\Renderer\RendererInterface;
    use Da\StatBundle\Filter\FilterInterface;

    /**
     * MyStatHandler est la classe principale de gestion des fonctionnalités
     * liées aux statistiques. Il est l'interface de l'encapsulation du mécanisme 
     * des statistiques. C'est lui qui doit être appelé par les contrôleurs.
     *
     * @author Me
     */
    class MyStatHandler implements StatHandlerInterface
    {
        // Implémentation...
    }

Puis de redéfinir le paramètre "da.stat.handler.class":

.. configuration-block::

    .. code-block:: yaml

        # /app/config/parameters.yml
        parameters:
            da.stat.handler.class: My\OwnBundle\ClassNamespace\MyStatHandler
    
Surcharger
----------

De même, pour surcharger le gestionnaire principal par défaut, il suffit de créer une classe qui surcharge
la classe StatHandler:

.. code-block:: php

    // /src/My/OwnBundle/ClassNamespace/MyStatHandler.php
    namespace My\OwnBundle\ClassNamespace;

    use Da\StatBundle\Handler\StatHandler;
    use Da\StatBundle\Aggregator\AggregatorInterface;
    use Da\StatBundle\Renderer\RendererInterface;
    use Da\StatBundle\Filter\FilterInterface;

    /**
     * MyStatHandler est la classe principale de gestion des fonctionnalités
     * liées aux statistiques. Il est l'interface de l'encapsulation du mécanisme 
     * des statistiques. C'est lui qui doit être appelé par les contrôleurs.
     *
     * @author Me
     */
    class MyStatHandler extends StatHandler
    {
        // Implémentation...
    }

Puis de redéfinir le paramètre "da.stat.handler.class":

.. configuration-block::

    .. code-block:: yaml

        # /app/config/parameters.yml
        parameters:
            da.stat.handler.class: My\OwnBundle\ClassNamespace\MyStatHandler