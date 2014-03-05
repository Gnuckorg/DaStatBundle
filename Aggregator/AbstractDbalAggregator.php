<?php

namespace Da\StatBundle\Aggregator;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Doctrine\DBAL\Connection;
use Da\StatBundle\Data\DataInterface;

/**
 * AbstractAggregator is an abstact helper to define an aggregator on a dbal connection.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
abstract class AbstractDbalAggregator implements AggregatorInterface
{
    /**
     * The database connection.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * The translator.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * The security context.
     *
     * @var SecurityContextInterface
     */
    protected $security;

    /**
     * Constructor.
     *
     * @param Connection               $connection The database connection.
     * @param TranslatorInterface      $translator The translator.
     * @param SecurityContextInterface $security   The security context.
     */
    public function __construct(Connection $connection, TranslatorInterface $translator, SecurityContextInterface $security)
    {
        $this->connection = $connection;
        $this->translator = $translator;
        $this->security = $security;
    }
}

