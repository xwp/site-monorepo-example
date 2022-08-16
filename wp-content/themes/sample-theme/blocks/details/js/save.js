/**
 * WordPress dependencies
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

 /**
  * The save function defines the way in which the different attributes should
  * be combined into the final markup, which is then serialized by the block
  * editor into `post_content`.
  *
  * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
  * @param {Object} props Block properties
  * @return {WPElement} Element to render.
  */
 
export default function Save( props ) {
    const { attributes } = props;
    const { summary, summaryTag, content, openDetail } = attributes;

    const propsObject = {};
    propsObject.className = 'c-details';
    if ( true === openDetail ) {
        propsObject.open = true;
    }
    const blockProps = useBlockProps.save( propsObject );

    return (
        <details { ...blockProps }>
            <summary>
                <RichText.Content tagName={ summaryTag } value={ summary } />
            </summary>
            <RichText.Content
                tagName="div"
                className="c-details__content"
                value={ content }
            />
        </details>
    );
}