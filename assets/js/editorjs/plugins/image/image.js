import {IconAddBorder, IconStretch, IconAddBackground, IconPicture} from '@codexteam/icons';

import './image.css';

export default class ImageTool {

    constructor({data, api, config, block}) {
        this.api = api;
        this.block = block;

        this.wrapper = null;

        this.data = {
            url: data.url || '',
            caption: data.caption || '',
            withBorder: data.withBorder !== undefined ? data.withBorder : false,
            withBackground: data.withBackground !== undefined ? data.withBackground : false,
            stretched: data.stretched !== undefined ? data.stretched : false,
        };

        this.config = {
            endpoints: config.endpoints || '',
            actions: config.actions || [],
        };

        this.settings = [
            {
                name: 'withBorder',
                icon: IconAddBorder,
                title: 'With border',
            },
            {
                name: 'stretched',
                icon: IconStretch,
                title: 'Stretch image',
                action: (name) => {
                    this.data[name] = !this.data[name];
                    this.wrapper.classList.toggle(name, this.data[name]);
                    this.block.stretched = this.data[name];
                }
            },
            {
                name: 'withBackground',
                icon: IconAddBackground,
                title: 'With background',
            }
        ];
    }

    static get toolbox() {
        return {
            title: 'Image',
            icon: IconPicture
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
            this._createImage({
                url: event.clipboardData.getData('text')
            });
        });

        this.wrapper.appendChild(input);

        return this.wrapper;
    }

    save(blockContent) {
        console.log(blockContent);

        const image = blockContent.querySelector('img');
        const caption = blockContent.querySelector('[contenteditable]');

        return Object.assign(this.data, {
            url: image.src,
            caption: caption.innerHTML || ''
        });
    }

    renderSettings() {
        return this.settings
            .concat(this.config.actions)
            .map(setting => ({
                icon: setting.icon,
                label: this.api.i18n.t(setting.title),
                name: setting.name,
                toggle: true,
                isActive: this.data[setting.name],
                onActivate: () => {
                    typeof setting.action === 'function'
                        ? setting.action(setting.name)
                        : this._toggleSettingAction(setting.name);
                },
            }));
    }

    _createImage(data) {
        const image = document.createElement('img');
        const caption = document.createElement('div');

        image.src = data.url;
        caption.contentEditable = true;
        caption.innerHTML = data.caption || '';

        this.wrapper.innerHTML = '';
        this.wrapper.appendChild(image);
        this.wrapper.appendChild(caption);

        this._acceptSettingsView();
    }

    _toggleSettingAction(setting) {
        this.data[setting] = !this.data[setting];
        this._acceptSettingsView();
    }

    _acceptSettingsView() {
        this.settings.forEach(setting => {
            this.wrapper.classList.toggle(setting.name, !!this.data[setting.name]);
        });
    }
}