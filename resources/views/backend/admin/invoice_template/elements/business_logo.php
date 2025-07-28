<?php

function option_fields() {
    $options = [
        'company_logo_width'        => [
            'label'    => _lang('Logo Witdh'),
            'type'     => 'text',
            'value'    => '100px',
            'required' => true,
            'change'   => [
                'class'  => '.element-logo',
                'action' => 'css_width',
            ],
        ],
        'company_logo_display'      => [
            'label'    => _lang('Display'),
            'type'     => 'select',
            'options'  => [
                'd-block'        => _lang('Block'),
                'd-inline-block' => _lang('Inline Block'),
                'd-inline'       => _lang('Inline'),
            ],
            'value'    => 'none',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '',
                'action' => 'addClass',
            ],
        ],
        'company_logo_align'        => [
            'label'    => _lang('Align'),
            'type'     => 'select',
            'options'  => [
                'none'  => _lang('None'),
                'left'  => _lang('Left'),
                'right' => _lang('Right'),
            ],
            'value'    => 'none',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '',
                'action' => 'css_text-align',
            ],
        ],
        'company_logo_custom_class' => [
            'label'    => _lang('Custom Class'),
            'type'     => 'text',
            'value'    => 'wp-100',
            'required' => false,
            'change'   => [
                'class'  => '.element-logo',
                'action' => 'addClass',
            ],
        ],
    ];

    return $options;
}

function element() {
    return '<div class="d-block" data-drop="false">
		<i class="far fa-trash-alt"></i>
		<i class="far fa-edit"></i>
		<i class="fas fa-clone"></i>
		<img src="/public/backend/images/company-logo.png" class="element-logo wp-100">
	</div>';
}
