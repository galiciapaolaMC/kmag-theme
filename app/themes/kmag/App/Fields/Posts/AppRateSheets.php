<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Repeater;

/**
 * Class TableLayout
 *
 * @package CN\App\Fields\Posts
 */
class AppRateSheets
{
    /**
     * Defines the ACF fields for the Table layout.
     *
     * @return array
     */
    public function fields(): array
    {
        return apply_filters('cn/posts/AppRateSheets', [
            Text::make(__('Table Title', 'kmag'), 'table_title'),
            File::make(__('PDF', 'kmag'))
                ->mimeTypes(['pdf'])
                ->library('all'),
            Repeater::make(__('Table Headers', 'kmag'), 'table_headers')
                ->layout('table')
                ->buttonLabel(__('Add Header', 'kmag'))
                ->fields([
                    Text::make(__('Header Label', 'kmag'), 'header_label'),
                ]),

            Repeater::make(__('Table Data', 'kmag'), 'table_data')
                ->layout('table')
                ->buttonLabel(__('Add Table Row', 'kmag'))
                ->fields([

                    WysiwygEditor::make(__('Column 1', 'kmag'), 'column_1')
                        ->toolbar('basic')
                        ->mediaUpload(false),

                    Repeater::make(__('Column 2', 'kmag'), 'column_2')
                        ->layout('table')
                        ->buttonLabel(__('Add Point', 'kmag'))
                        ->fields([
                            Text::make(__('Point', 'kmag'), 'point'),
                        ]),

                    Repeater::make(__('Column 3', 'kmag'), 'column_3')
                        ->layout('table')
                        ->buttonLabel(__('Add Point', 'kmag'))
                        ->fields([
                            Text::make(__('Point', 'kmag'), 'point'),
                        ]),
                ]),

                Repeater::make(__('Application Method Blocks', 'kmag'), 'method_blocks')
             
                ->buttonLabel(__('Add Method Block', 'kmag'))
                ->fields([
                    Text::make(__('Application Title', 'kmag'), 'application_title'),
                    WysiwygEditor::make(__('Application Description', 'kmag'), 'application_desc')
                            ->toolbar('basic')
                            ->mediaUpload(false),
                    Text::make(__('Method Title', 'kmag'), 'method_title')
                        ->defaultValue('Method of Application:'),
                    WysiwygEditor::make(__('Point', 'kmag'), 'method_desc')
                        ->toolbar('basic')
                        ->mediaUpload(false),
                ]),
        ]);
    }
}
