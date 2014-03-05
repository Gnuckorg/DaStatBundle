<?php

namespace Da\StatBundle\Renderer;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * AbstractRenderer est une classe abstraite qui fournit les services standards
 * dont a besoin un gestionnaire de rendu.
 *
 * @author Thomas Prelot
 */
abstract class AbstractRenderer implements RendererInterface
{
    /**
     * Le service de traduction.
     *
     * @var Translator
     */
    protected $translator;

	/**
     * Constructeur.
     *
     * @param TranslatorInterface $translator Le service de traduction.
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
}

