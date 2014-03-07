<?php

namespace Da\StatBundle\Renderer;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * AbstractRenderer is an helper to define a renderer class.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
abstract class AbstractRenderer implements RendererInterface
{
    /**
     * The translator.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator The translator.
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
}