import './image.css';

export default class ImageTool {

    constructor({data}) {
        this.data = data;
        this.wrapper = null;
    }

    static get toolbox() {
        return {
            title: 'Image',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    render() {
        this.wrapper = document.createElement('div');
        this.wrapper.classList.add('simple-image');

        if (this.data && this.data.url) {
            this._createImage(this.data);
            return this.wrapper;
        }

        const input = document.createElement('input');

        input.placeholder = 'Paste an image URL...';
        input.value = this.data && this.data.url ? this.data.url : '';

        input.addEventListener('paste', (event) => {
            this._createImage(event.clipboardData.getData('text'));
        });

        this.wrapper.appendChild(input);

        console.log(this.wrapper);

        return this.wrapper;
    }

    save(blockContent) {
        console.log(blockContent);

        const image = blockContent.querySelector('img');
        const caption = blockContent.querySelector('input');

        return {
            url: image.src,
            caption: caption.value
        }
    }

    _createImage(data){
        const image = document.createElement('img');
        const caption = document.createElement('input');

        image.src = data.url;
        caption.value = data.caption || '';
        caption.placeholder = 'Caption...';

        this.wrapper.innerHTML = '';
        this.wrapper.appendChild(image);
        this.wrapper.appendChild(caption);
    }
}