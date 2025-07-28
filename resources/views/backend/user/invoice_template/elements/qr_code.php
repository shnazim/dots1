<?php

function option_fields() {
    $options = [
        'qr_code_width' => [
            'label'    => _lang('QR Code Width'),
            'type'     => 'text',
            'value'    => '100px',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '.element-qr-code',
                'action' => 'css_width',
            ],
        ],
        'qr_code_display'     => [
            'label'    => _lang('Display'),
            'type'     => 'select',
            'options'  => [
                'd-block'        => _lang('Block'),
                'd-inline-block' => _lang('Inline Block'),
				'd-inline'  => _lang('Inline'),
            ],
            'value'    => 'none',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '',
                'action' => 'addClass',
            ],
        ],
		'qr_code_align' => array(
			'label'    => _lang('Align'),
			'type'     => 'select',
			'options'  => array(
			                'none'   => _lang('None'),
							'left' => _lang('Left'),
							'right'  => _lang('Right'),
						),
			'value'    => 'none',
			'column'   => 'col-md-6',
			'required' => true,
			'change'    => array(
			               'class'   => '',
						   'action'  => 'css_text-align',
						),
		),
        'qr_code_custom_class' => array(
            'label'    => _lang('Custom Class'),
            'type'     => 'text',
            'value'    => '',
            'column'   => 'col-md-6',
            'required' => false,
            'change'   => array(
                'class'  => '',
                'action' => 'addClass',
            ),
        ),
    ];

    return $options;
}

function element() {
    return '<div class="d-block" data-drop="false">
		<i class="far fa-trash-alt"></i>
		<i class="far fa-edit"></i>
		<i class="fas fa-clone"></i>
		<img src="/public/backend/images/qr_code.png" class="element-qr-code wp-100">
	</div>';
}