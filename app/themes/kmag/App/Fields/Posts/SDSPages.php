<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\DatePicker;

/**
 * Class SDSPages
 *
 * @package CN\App\Fields\Posts
 */
class SDSPages
{
    /**
     * Defines fields used within SDSPages post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/sds-pages',
            [
                Group::make(__('Head Section', 'kmag'), 'top_header')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Product Name', 'kmag'), 'product_name')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ),
                        Text::make(__('Status', 'kmag'), 'status')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ),
                        File::make(__('Product Logo', 'kmag'), 'product_logo')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ),
                        File::make(__('PDF File', 'kmag'), 'pdf_file')->wrapper(
                            [
                                'width' => '25'
                            ]
                        )->mimeTypes(['pdf']),
                        DatePicker::make(__('Revision Date', 'kmag'), 'revision_date')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ),
                        Text::make(__('SDS', 'kmag'), 'sds')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ), Text::make(__('Section(s) Revised', 'kmag'), 'sect_revised')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ),
                        DatePicker::make(__('Issue Date', 'kmag'), 'issue_date')->wrapper(
                            [
                                'width' => '25'
                            ]
                        ),
                    ]),
                Group::make(__('Section 1 - Product and Company Identification', 'kmag'), 'sec_1')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Trade Name', 'kmag'), 'trade_name'),
                        Text::make(__('Chemical Name', 'kmag'), 'chemical_name')->wrapper([
                            'width' => '50'
                        ]),
                        Text::make(__('CAS Number', 'kmag'), 'cas_number')->wrapper([
                            'width' => '50'
                        ]),
                        Text::make(__('Chemical Family', 'kmag'), 'chemical_family')->wrapper([
                            'width' => '50'
                        ]),
                        Text::make(__('Primary Use', 'kmag'), 'primary_use')->wrapper([
                            'width' => '50'
                        ]),
                        WysiwygEditor::make(__('Synonyms', 'kmag'), 'synonyms')->mediaUpload(false),
                        Group::make(__('Company Information', 'kmag'), 'comp_info')
                            ->layout('block')
                            ->fields([
                                WysiwygEditor::make(__('Corporate Headquarters', 'kmag'), 'corp_headquarters')->wrapper([
                                    'width' => '50',
                                    'class' => 'wysEditorSds'
                                ])->mediaUpload(false),
                                WysiwygEditor::make(__('US Guarantor', 'kmag'), 'us_guarantor')->wrapper([
                                    'width' => '50',
                                    'class' => 'wysEditorSds'
                                ])->mediaUpload(false),
                                WysiwygEditor::make(__('Canada Guarantor', 'kmag'), 'canada_headquarters')->wrapper([
                                    'width' => '50',
                                    'class' => 'wysEditorSds'
                                ])->mediaUpload(false),
                                WysiwygEditor::make(__('Contact Info', 'kmag'), 'contact_info')->wrapper([
                                    'width' => '50',
                                    'class' => 'wysEditorSds'
                                ])->mediaUpload(false),
                            ]),
                        WysiwygEditor::make(__('Emergency Contact', 'kmag'), 'emergency_contact')->mediaUpload(false),
                    ]),
                Group::make(__('Section 2 - Hazard Identification', 'kmag'), 'sec_2')
                    ->layout('block')
                    ->fields([
                        Text::make(__('OSHA / HCS Status', 'kmag'), 'osha_hcs_status'),
                        Repeater::make(__('GHS Classification', 'kmag'), 'ghs_classification')
                            ->fields([
                                Text::make(__('GHS Column 1', 'kmag'), 'column_ghs_1'),
                                Text::make(__('GHS Column 2', 'kmag'), 'column_ghs_2'),
                                Text::make(__('Hazard Column', 'kmag'), 'column_hazard_3'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                        Text::make(__('Signal Word', 'kmag'), 'signal_word'),
                        File::make(__('Warning Symbol', 'kmag'), 'warning_symbol'),
                        Group::make(__('Label Elements', 'kmag'), 'label_ele')
                            ->layout('block')
                            ->fields([
                                Repeater::make(__('Prevention', 'kmag'), 'prevention_list')
                                    ->fields([
                                        Text::make(__('Label', 'kmag'), 'label'),
                                        WysiwygEditor::make(__('Description', 'kmag'), 'description')
                                    ])
                                    ->buttonLabel(__('Add', 'kmag'))
                                    ->layout('table'),
                                Repeater::make(__('Response', 'kmag'), 'response_list')
                                    ->fields([
                                        Text::make(__('Label', 'kmag'), 'label'),
                                        WysiwygEditor::make(__('Description', 'kmag'), 'description')
                                    ])
                                    ->buttonLabel(__('Add', 'kmag'))
                                    ->layout('table'),
                                Repeater::make(__('Storage', 'kmag'), 'storage_list')
                                    ->fields([
                                        Text::make(__('Label', 'kmag'), 'label'),
                                        WysiwygEditor::make(__('Description', 'kmag'), 'description')
                                    ])
                                    ->buttonLabel(__('Add', 'kmag'))
                                    ->layout('table'),
                                Repeater::make(__('Disposal', 'kmag'), 'disposal_list')
                                    ->fields([
                                        Text::make(__('Label', 'kmag'), 'label'),
                                        WysiwygEditor::make(__('Description', 'kmag'), 'description')
                                    ])
                                    ->buttonLabel(__('Add', 'kmag'))
                                    ->layout('table'),
                            ])
                    ]),
                Group::make(__('Section 3 — Composition Information on Ingredients', 'kmag'), 'sec_3')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Formula', 'kmag')),
                        Repeater::make(__('Composition', 'kmag'), 'composition_list')
                            ->fields([
                                Text::make(__('Label', 'kmag'), 'label'),
                                Text::make(__('Code', 'kmag'), 'code'),
                                Text::make(__('Range', 'kmag'), 'range'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                    ]),
                Group::make(__('Section 4 — First Aid Measures', 'kmag'), 'sec_4')
                    ->layout('block')
                    ->fields([
                        Repeater::make(__('First Aid Procedures', 'kmag'), 'first_aid_list')
                            ->fields([
                                Text::make(__('Label', 'kmag'), 'label'),
                                Text::make(__('Description', 'kmag'), 'description'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                        Text::make(__('Note to Physician', 'kmag')),
                    ]),
                Group::make(__('Section 5 — Fire Fighting Measures', 'kmag'), 'sec_5')
                    ->layout('block')
                    ->fields([
                        TextArea::make(__('Extinguishing Media', 'kmag'), 'extinguish')->wrapper([
                            'width' => '50'
                        ]),
                        TextArea::make(__('Protection of Firefighters', 'kmag'), 'protection')->wrapper([
                            'width' => '50'
                        ]),
                    ]),
                Group::make(__('Section 6 — Accidental Release Measures', 'kmag'), 'sec_6')
                    ->layout('block')
                    ->fields([
                        TextArea::make(__('Response Techniques', 'kmag'), 'response_tech')
                    ]),
                Group::make(__('Section 7 — Handling and Storage', 'kmag'), 'sec_7')
                    ->layout('block')
                    ->fields([
                        TextArea::make(__('Handling', 'kmag'), 'handling')->wrapper([
                            'width' => '50'
                        ]),
                        TextArea::make(__('Storage', 'kmag'), 'storage')->wrapper([
                            'width' => '50'
                        ])
                    ]),
                Group::make(__('Section 8 — Exposure Controls / Personal Protection', 'kmag'), 'sec_8')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Engineering Controls', 'kmag'), 'engineering_control'),
                        Repeater::make(__('Personal Protective Equipment (PPE)', 'kmag'), 'ppe_list')
                            ->fields([
                                Text::make(__('Label', 'kmag'), 'label'),
                                Text::make(__('Description', 'kmag'), 'description'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                        Text::make(__('General Hygiene Considerations', 'kmag'), 'general_hygience'),
                        Repeater::make(__('Exposure Guidelines', 'kmag'), 'exposure_list')
                            ->fields([
                                Text::make(__('Label', 'kmag'), 'label'),
                                WysiwygEditor::make(__('Description', 'kmag'), 'description'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                        Repeater::make(__('Saskatchewan', 'kmag'), 'saskatchewan_list')
                            ->fields([
                                Text::make(__('Label', 'kmag'), 'label'),
                                WysiwygEditor::make(__('Description', 'kmag'), 'description'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                    ]),
                Group::make(__('Section 9 — Physical and Chemical Properties', 'kmag'), 'sec_9')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Note', 'kmag'), 'note'),
                        Text::make(__('Appearance', 'kmag'), 'appearance')->wrapper(['width' => '50']),
                        Text::make(__('Vapor Pressure (mm Hg)', 'kmag'), 'vapor_pressure')->wrapper(['width' => '50']),
                        Text::make(__('Odor', 'kmag'), 'odor')->wrapper(['width' => '50']),
                        Text::make(__('Vapor Density (air=1)', 'kmag'), 'vapor_desnsity')->wrapper(['width' => '50']),
                        Text::make(__('Odor Threshold', 'kmag'), 'odor_threshold')->wrapper(['width' => '50']),
                        Text::make(__('Specific Gravity or Relative Density', 'kmag'), 'specific_gravity')->wrapper(['width' => '50']),
                        Text::make(__('Physical state', 'kmag'), 'physical_state')->wrapper(['width' => '50']),
                        Text::make(__('Bulk Density:', 'kmag'), 'bulk_density')->wrapper(['width' => '50']),
                        Text::make(__('pH', 'kmag'), 'ph')->wrapper(['width' => '50']),
                        Text::make(__('Solubility in Water', 'kmag'), 'solubility')->wrapper(['width' => '50']),
                        Text::make(__('Melting Point/ Freezing Point', 'kmag'), 'melting_freezing_points')->wrapper(['width' => '50']),
                        Text::make(__('Partition coefficient', 'kmag'), 'partition_coef')->wrapper(['width' => '50']),
                        Text::make(__('Boiling Point', 'kmag'), 'boiling_point')->wrapper(['width' => '50']),
                        Text::make(__('Auto-Ignition Temperature', 'kmag'), 'auto_ignition_temp')->wrapper(['width' => '50']),
                        Text::make(__('Flash Point', 'kmag'), 'flash_point')->wrapper(['width' => '50']),
                        Text::make(__('Decomposition Temperature', 'kmag'), 'auto_decomposition_temp')->wrapper(['width' => '50']),
                        Text::make(__('Evaporation Rate', 'kmag'), 'evaporation_rate')->wrapper(['width' => '50']),
                        Text::make(__('Viscosity', 'kmag'), 'viscosity')->wrapper(['width' => '50']),
                        Text::make(__('Flammability', 'kmag'), 'flammability')->wrapper(['width' => '50']),
                        Text::make(__('Volatility', 'kmag'), 'volatility')->wrapper(['width' => '50']),
                        Text::make(__('Upper/Lower Flammability or explosive limits', 'kmag'), 'flammability_limits'),
                    ]),
                Group::make(__('Section 10 — Stability and Reactivity', 'kmag'), 'sec_10')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Chemical Stability', 'kmag'), 'chemical_stability')->wrapper(['width' => '50']),
                        Text::make(__('Conditions to Avoid', 'kmag'), 'conditions_to_avoid')->wrapper(['width' => '50']),
                        Text::make(__('Incompatible Materials', 'kmag'), 'incompatible')->wrapper(['width' => '50']),
                        Text::make(__('Hazardous Decomposition Products', 'kmag'), 'hazardous_products')->wrapper(['width' => '50']),
                        Text::make(__('Corrosiveness', 'kmag'), 'corrosiveness')->wrapper(['width' => '50']),
                        Text::make(__('Hazardous Polymerization', 'kmag'), 'hazardous_polymer')->wrapper(['width' => '50']),
                    ]),
                Group::make(__('Section 11 — Toxicological Information', 'kmag'), 'sec_11')
                    ->layout('block')
                    ->fields([
                        Repeater::make(__('Details', 'kmag'))
                            ->fields([
                                Text::make(__('Chemical Component', 'kmag')),
                                Repeater::make(__('Toxicological Information', 'kmag'))
                                    ->fields([
                                        Text::make(__('Label', 'kmag'), 'label'),
                                        Text::make(__('Description', 'kmag'), 'description'),
                                    ])
                                    ->buttonLabel(__('Add', 'kmag'))
                                    ->layout('table'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table')
                    ]),
                Group::make(__('Section 12 — Ecological Information', 'kmag'), 'sec_12')
                    ->fields([
                        Repeater::make(__('Chemical Component', 'kmag'))
                            ->layout('block')
                            ->fields([
                                Text::make(__('Label', 'kmag'), 'label'),
                                Text::make(__('Type', 'kmag'), 'type'),
                                WysiwygEditor::make(__('Description', 'kmag'), 'description'),
                            ])
                            ->buttonLabel(__('Add', 'kmag'))
                            ->layout('table'),
                    ]),
                Group::make(__('Section 13 — Disposal Considerations'), 'sec_13')
                    ->layout('block')
                    ->fields([
                        TextArea::make(__('Description', 'kmag'), 'description'),
                    ]),
                Group::make(__('Section 14 — Transport Info'), 'sec_14')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Regulatory Status', 'kmag'), 'regulatory')->wrapper(['width' => '50']),
                        Text::make(__('Identification Number', 'kmag'), 'id_number')->wrapper(['width' => '50']),
                        Text::make(__('Hazard Class', 'kmag'), 'hazard_class')->wrapper(['width' => '50']),
                        Text::make(__('Proper Shipping Name', 'kmag'), 'proper_shipping_name')->wrapper(['width' => '50']),
                        Text::make(__('Packing Group', 'kmag'), 'packing_group')->wrapper(['width' => '50']),
                        Text::make(__('DOT Emergency Response Guide Number', 'kmag'), 'dot_emergency_guide_num')->wrapper(['width' => '50']),
                        Text::make(__('Transport in bulk according to Annex II of MARPOL 73/78 and the IBC Code', 'kmag'), 'bulk_transport')->wrapper(['width' => '50']),
                        Text::make(__('MARPOL Annex V', 'kmag'), 'marpol_annex')->wrapper(['width' => '50']),
                        Text::make(__('IMO/IMDG', 'kmag'), 'imo_imdg'),
                    ]),

                Group::make(__('Section 15 — Regulatory Information'), 'sec_15')
                    ->layout('block')
                    ->fields([
                        Text::make(__('CERCLA', 'kmag'))->wrapper(['width' => '50']),
                        Text::make(__('RCRA 261.33', 'kmag'), 'rcra')->wrapper(['width' => '50']),
                        Group::make(__('SARA TITLE III'))
                            ->layout('block')
                            ->fields([
                                Text::make(__('Section 302/304', 'kmag'))->wrapper(['width' => '33']),
                                Text::make(__('RQ', 'kmag'))->wrapper(['width' => '33']),
                                Text::make(__('TPQ', 'kmag'))->wrapper(['width' => '33']),
                            ]),
                        Group::make(__('Section 311/312'))
                            ->layout('block')
                            ->fields([
                                Text::make(__('Acute', 'kmag'))->wrapper(['width' => '50']),
                                Text::make(__('Chronic', 'kmag'))->wrapper(['width' => '50']),
                                Text::make(__('Fire', 'kmag'))->wrapper(['width' => '50']),
                                Text::make(__('Pressure', 'kmag'))->wrapper(['width' => '50']),
                                Text::make(__('Reactivity', 'kmag')),
                            ]),
                        Text::make(__('Section 313', 'kmag'))->wrapper(['width' => '50']),
                        Text::make(__('NTP, IARC, OSHA', 'kmag'))->wrapper(['width' => '50']),
                        Text::make(__('Canada DSL', 'kmag'))->wrapper(['width' => '50']),
                        Text::make(__('Canada NDSL', 'kmag'))->wrapper(['width' => '50']),
                        Text::make(__('TSCA', 'kmag')),
                        TextArea::make(__('CA Proposition 65', 'kmag'))->wrapper(['width' => '50']),
                        TextArea::make(__('WHMIS', 'kmag'))->wrapper(['width' => '50']),
                        TextArea::make(__('REACH Registration', 'kmag'))->wrapper(['width' => '100']),
                    ]),

                Group::make(__('Section 16 — Other Information'), 'sec_16')
                    ->layout('block')
                    ->fields([
                        WysiwygEditor::make(__('Disclaimer', 'kmag'), 'disclaimer'),
                        Text::make(__('Preparation', 'kmag'), 'preparation')->wrapper(['width' => '50']),
                        DatePicker::make(__('Revision Date', 'kmag'), 'revision_date')->wrapper(['width' => '50']),
                        Text::make(__('Sections Revised', 'kmag'), 'sections_revised')->wrapper(['width' => '50']),
                        Text::make(__('SDS Number', 'kmag'), 'sds_number')->wrapper(['width' => '50']),
                        TextArea::make(__('References', 'kmag'), 'references'),
                        Group::make(__('Other Hazard Classifications'), 'ohc')
                            ->layout('block')
                            ->fields([
                                Group::make(__('NFPA HAZARD CLASS'), 'nfpa_class')
                                    ->layout('block')
                                    ->fields([
                                        Text::make(__('Health', 'kmag'), 'health')->wrapper(['width' => '50']),
                                        Text::make(__('Flammability', 'kmag'), 'flammability')->wrapper(['width' => '50']),
                                        Text::make(__('Instability', 'kmag'), 'instability')->wrapper(['width' => '50']),
                                        Text::make(__('Special Hazard', 'kmag'), 'special_hazard')->wrapper(['width' => '50']),
                                    ]),
                                Group::make(__('HMIS HAZARD CLASS'), 'hmis_class')
                                    ->layout('block')
                                    ->fields([
                                        Text::make(__('Health', 'kmag'), 'health')->wrapper(['width' => '50']),
                                        Text::make(__('Flammability', 'kmag'), 'flammability')->wrapper(['width' => '50']),
                                        Text::make(__('Physical Hazard', 'kmag'), 'physical')->wrapper(['width' => '50']),
                                        Text::make(__('PPE', 'kmag'), 'ppe')->wrapper(['width' => '50']),
                                    ]),
                                Group::make(__('WHMIS 2015 (HPR) HAZARD CLASS'), 'whis_class')
                                    ->layout('block')
                                    ->fields([
                                        File::make(__('Symbol', 'kmag'), 'symbol'),
                                        WysiwygEditor::make(__('Signal Word', 'kmag'), 'signal_word')->mediaUpload(false)->wrapper(['width' => '33']),
                                        WysiwygEditor::make(__('Classification', 'kmag'), 'classification')->mediaUpload(false)->wrapper(['width' => '33']),
                                        WysiwygEditor::make(__('Hazard Statements', 'kmag'), 'hazard_statements')->mediaUpload(false)->wrapper(['width' => '33']),
                                    ])
                            ])
                    ])
            ]
        );
    }
}
