/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { useEffect, useState } from '@wordpress/element';
import { ComboboxControl, CheckboxControl, PanelBody, Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import apiFetch from '@wordpress/api-fetch';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
  edit: ({ attributes, setAttributes }) => {
     const { fileId, fileUpload } = attributes;
     const blockProps = useBlockProps();
     const [files, setFiles] = useState([]);
     const [isLoading, setIsLoading] = useState(true);

     useEffect(() => {
       apiFetch({ path: '/wp/v2/shared_file?per_page=100' }).then((files) => {
         setFiles(files.map(file => ({ label: file.title.rendered, value: file.id })));
         setIsLoading(false);
       });
     }, []);

     const handleFileChange = (value) => {
       setAttributes({ fileId: value ? parseInt(value, 10) : 0 });
     };

     return (
       <div {...blockProps}>
         <InspectorControls>
          <PanelBody title={__('Select Options', 'shared-files')}>
             <CheckboxControl
               label={__('Enable File Upload', 'shared-files')}
               checked={fileUpload}
               onChange={(value) => setAttributes({ fileUpload: value })}
             />
             {!isLoading && (
               <ComboboxControl
                 label={__('File', 'shared-files')}
                 value={fileId}
                 options={[{ label: __('Select a file', 'shared-files'), value: 0 }, ...files]}
                 onChange={handleFileChange}
                 disabled={fileUpload}
               />
             )}
           </PanelBody>
         </InspectorControls>
         <Disabled>
           <ServerSideRender block="shared-files/files-default" attributes={{ fileId, fileUpload }} />
         </Disabled>
       </div>
     );
   },
   save: () => {
     return null; // Server-side rendering is used.
   },
} );
