<?php

namespace XWP\Sample_Theme;

class Block_Variation {

    protected $name;

    protected $label;

    public function __construct( $name, $label ) {
        $this->name = $name;
        $this->label = $label;
    }

    public function properties() {
        $properties = [
            'name' => $this->name,
            'label' => $this->label,
        ];

        return $properties;
    }

}