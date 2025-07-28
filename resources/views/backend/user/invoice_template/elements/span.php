<?php

function option_fields()
{
    $options = [
        'span_text'         => [
            'label'    => _lang('Span Text'),
            'type'     => 'text',
            'value'    => 'Span text',
            'required' => true,
            'change'   => [
                'class'  => '.span',
                'action' => 'html',
            ],
        ],
        'span_text_color'   => [
            'label'    => _lang('Text Color'),
            'type'     => 'text',
            'value'    => '#000',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '.span',
                'action' => 'css_color',
            ],
        ],
        'span_display_type' => [
            'label'    => _lang('Display'),
            'type'     => 'select',
            'options'  => [
                'd-block'        => _lang('Block'),
                'd-inline-block' => _lang('Inline block'),
                'd-inline'       => _lang('Inline'),
            ],
            'value'    => 'd-inline-block',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '',
                'action' => 'addClass',
            ],
        ],
        'span_text_align'   => [
            'label'    => _lang('Text Align'),
            'type'     => 'select',
            'options'  => [
                'left'   => _lang('Left'),
                'center' => _lang('Center'),
                'right'  => _lang('Right'),
            ],
            'value'    => 'left',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '.span',
                'action' => 'css_text-align',
            ],
        ],
        'span_custom_class' => [
            'label'    => _lang('Custom Class'),
            'type'     => 'text',
            'value'    => '',
            'column'   => 'col-md-6',
            'required' => false,
            'change'   => [
                'class'  => '.span',
                'action' => 'addClass',
            ],
        ],

    ];

    return $options;
}

function element()
{
    return '<div class="element-span d-inline-block" data-drop="false">
                <i class="far fa-trash-alt"></i>
                <i class="far fa-edit"></i>
                <i class="fas fa-clone"></i>
				<span class="span">Span text</span>
			</div>';
}
