import EditorJS from '@editorjs/editorjs';

import './../../styles/editorjs.css';
import ImageTool from './../../js/editorjs/plugins/image/image'

document.querySelectorAll('[data-editor="editorjs"]').forEach((el) => {

    const inputEl = el.parentElement.querySelector(`[data-editor-content]`);

    const editor = new EditorJS({
        holder: el,
        placeholder: 'Rédigez votre contenu ici !',

        tools: {
            image: {
                class: ImageTool,
                inlineToolbar: true,
                config: {
                    endpoints: {
                        byFile: '/editorjs/upload/image', // Your backend file uploader endpoint
                        byUrl: '/editorjs/fetch/image', // Your endpoint that provides uploading by Url
                    }
                }
            },
        },

        onChange: (api, event) => {
            editor.saver.save()
                .then((outputData) => inputEl.value = JSON.stringify(outputData))
                .catch((error) => console.error("Erreur lors de l'enregistrement", error))
        }
    });

    editor.isReady
        .then(() => editor.blocks.render(JSON.parse(inputEl.value)))
});
