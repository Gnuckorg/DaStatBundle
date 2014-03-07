<?php

namespace Da\StatBundle\Renderer;

use Da\StatBundle\Data\DataInterface;

/**
 * RendererInterface is the interface that a class should implement
 * to be used as a renderer in the mechanism of the statistics.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface RendererInterface
{
    /**
     * Get the type of the renderer (used for client javascript side and for the labels).
     *
     * @return string The type.
     */
    function getType();

    /**
     * Whether or not the renderer supports this kind of data.
     *
     * @param DataInterface $data The data.
     *
     * @return boolean True if the kind of data is supported, false otherwise.
     */
    function supports(DataInterface $data);

    /**
     * Build the rendering description.
     *
     * @param DataInterface $data The data.
     *
     * @return array The rendering description.
     */
    function render(DataInterface $data);
}