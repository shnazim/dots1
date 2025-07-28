<?php

function option_fields()
{
    $options = [
        'paragraph_text'         => [
            'label'    => _lang('Paragraph Text'),
            'type'     => 'textarea',
            'value'    => 'Paragraph text',
            'required' => true,
            'change'   => [
                'class'  => '.paragraph',
                'action' => 'html',
            ],
        ],
        'paragraph_text_color'   => [
            'label'    => _lang('Text Color'),
            'type'     => 'text',
            'value'    => '#000',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '.paragraph',
                'action' => 'css_color',
            ],
        ],
        'paragraph_display_type' => [
            'label'    => _lang('Display'),
            'type'     => 'select',
            'options'  => [
                'd-block'        => _lang('Block'),
                'd-inline-block' => _lang('Inline block'),
                'd-inline'       => _lang('Inline'),
            ],
            'value'    => 'd-block',
            'column'   => 'col-md-6',
            'required' => true,
            'change'   => [
                'class'  => '',
                'action' => 'addClass',
            ],
        ],
        'paragraph_text_align'   => [
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
                'class'  => '.paragraph',
                'action' => 'css_text-align',
            ],
        ],
        'paragraph_custom_class' => [
            'label'    => _lang('Custom Class'),
            'type'     => 'text',
            'value'    => '',
            'column'   => 'col-md-6',
            'required' => false,
            'change'   => [
                'class'  => '.paragraph',
                'action' => 'addClass',
            ],
        ],

    ];

    return $options;
}

function element()
{
    return '<div class="element-paragraph">
                <i class="far fa-trash-alt"></i>
                <i class="far fa-edit"></i>
                <i class="fas fa-clone"></i>
				<p class="paragraph">Paragraph text</p>
			</div>';
}
