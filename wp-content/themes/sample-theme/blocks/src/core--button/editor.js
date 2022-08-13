/**
 * WordPress dependencies
 */
import { unregisterBlockStyle } from '@wordpress/blocks';

import './css/editor.scss';

// Unregister default button styles. Note, this can't be done via PHP.
document.addEventListener( 'DOMContentLoaded', () => {
    unregisterBlockStyle( 'core/button', 'fill' );
    unregisterBlockStyle( 'core/button', 'outline' );
    unregisterBlockStyle( 'core/button', 'default' );
    unregisterBlockStyle( 'core/button', 'transparent' );
} );