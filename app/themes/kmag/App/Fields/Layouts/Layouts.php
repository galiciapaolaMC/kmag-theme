<?php

namespace CN\App\Fields\Layouts;

use Extended\ACF\Fields\Tab;

/**
 * Class Layouts
 *
 * @package CN\App\Fields\Layouts
 */
abstract class Layouts
{
    /**
     * Defines fields for layout.
     *
     * @return object
     */
    abstract public function fields();

    /**
     * Creates Content Tab Field.
     *
     * @return object
     */
    public function contentTab()
    {
        return Tab::make(__('Content', 'kmag'), 'content-tab')
            ->placement('left');
    }

    /**
     * Creates Content Tab Field.
     *
     * @return object
     */
    public function cardTab()
    {
        return Tab::make(__('Card', 'kmag'), 'card-tab')
            ->placement('left');
    }


    /**
     * Creates Relationships Tab Field.
     *
     * @return object
     */
    public function relationshipsTab()
    {
        return Tab::make(__('Relationships', 'kmag'), 'relationships-tab')
            ->placement('left');
    }

    /**
     * Creates Options Tab Field.
     *
     * @return object
     */
    public function optionsTab()
    {
        return Tab::make(__('Options', 'kmag'), 'options-tab')
            ->placement('left');
    }

    /**
     * Creates Options Tab Field.
     *
     * @return object
     */
    public function styleTab()
    {
        return Tab::make(__('Style', 'kmag'), 'style-tab')
            ->placement('left');
    }
}
