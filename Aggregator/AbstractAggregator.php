<?php

namespace Da\StatBundle\Aggregator;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface as OptionsResolverException;
use Da\StatBundle\Data\Provider\DataProviderInterface;
use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Exception\BadCriteriaException;

/**
 * AbstractAggregator is an abstact helper to define an aggregator.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
abstract class AbstractAggregator implements AggregatorInterface
{
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
     * @param TranslatorInterface      $translator   The translator.
     * @param SecurityContextInterface $security     The security context.
     * @param DataProviderInterface    $dataProvider The data provider.
     */
    public function __construct(
        TranslatorInterface $translator,
        SecurityContextInterface $security,
        DataProviderInterface $dataProvider
    )
    {
        $this->translator = $translator;
        $this->security = $security;
        $this->dataProvider = $dataProvider;
    }

    /**
     * Create and return a new option resolver.
     *
     * @return OptionsResolverInterface The new option resolver.
     */
    protected function createOptionResolver()
    {
        return new OptionsResolver();
    }

    /**
     * {@inheritdoc}
     */
    public function formatCriteria(array $criteria = array())
    {
        $optionsResolver = $this->createOptionResolver();

        $this->defineCriteria($optionsResolver);

        try {
            $criteria = $optionsResolver->resolve($criteria);
        } catch (OptionsResolverException $exception) {
            throw new BadCriteriaException($criteria, $exception->getMessage(), $exception);
        }

        return $optionsResolver->resolve($criteria);
    }

    /**
     * Define the structure and default values of the criteria.
     *
     * @param OptionsResolverInterface $optionsResolver The option resolver.
     *
     * @return OptionsResolverInterface The option resolver.
     */
    protected function defineCriteria(OptionsResolverInterface $optionsResolver)
    {
        return $optionsResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function checkCriteria(array $criteria = array())
    {
        return $criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function aggregate(array $criteria = array())
    {
        $data = $this->dataProvider->create();

        return $this->load($data, $criteria);
    }

    /**
     * Load the data.
     *
     * @param DataInterface $data     The empty data.
     * @param array         $criteria The criteria.
     *
     * @return DataInterface The filled data.
     */
    abstract protected function load(DataInterface $data, array $criteria = array());
}