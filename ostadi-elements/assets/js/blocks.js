(function (blocks, blockEditor, element, components) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;

    blocks.registerBlockType('ostadi/section-heading', {
        edit: function (props) { return el('div', {className:'ostadi-section-heading'}, el(RichText,{tagName:'h2',value:props.attributes.title,onChange:function(v){props.setAttributes({title:v});},placeholder:'عنوان بخش'}), el(RichText,{tagName:'p',value:props.attributes.description,onChange:function(v){props.setAttributes({description:v});},placeholder:'توضیح کوتاه'})); },
        save: function () { return null; }
    });
    blocks.registerBlockType('ostadi/article-card', {
        edit: function (props) { return el('div', {}, el(InspectorControls,{},el(PanelBody,{title:'تنظیمات مقاله'},el(TextControl,{label:'شناسه نوشته',value:props.attributes.postId,onChange:function(v){props.setAttributes({postId:v});}}))),el('div',{className:'ostadi-card'},'کارت مقاله استادی — شناسه نوشته: '+(props.attributes.postId||'خودکار'))); },
        save: function () { return null; }
    });
    blocks.registerBlockType('ostadi/article-grid', {
        edit: function (props) { return el('div', {}, el(InspectorControls,{},el(PanelBody,{title:'تنظیمات شبکه'},el(TextControl,{label:'تعداد مقاله',value:props.attributes.count,onChange:function(v){props.setAttributes({count:v});}}))),el('div',{className:'ostadi-article-grid ostadi-cols-4'},'شبکه مقالات استادی')); },
        save: function () { return null; }
    });
    blocks.registerBlockType('ostadi/category-list', {
        edit: function () { return el('div',{className:'ostadi-category-list'},el('div',{className:'ostadi-category-item'},'دسته‌بندی‌های سایت شما')); },
        save: function () { return null; }
    });
    blocks.registerBlockType('ostadi/hero', {
        edit: function (props) { return el('div', {className:'ostadi-hero'}, el(InspectorControls,{},el(PanelBody,{title:'تنظیمات هیرو'},el(TextControl,{label:'برچسب',value:props.attributes.eyebrow,onChange:function(v){props.setAttributes({eyebrow:v});}}),el(TextControl,{label:'عنوان',value:props.attributes.title,onChange:function(v){props.setAttributes({title:v});}}),el(TextControl,{label:'توضیحات',value:props.attributes.description,onChange:function(v){props.setAttributes({description:v});}}),el(TextControl,{label:'متن دکمه',value:props.attributes.buttonText,onChange:function(v){props.setAttributes({buttonText:v});}}),el(TextControl,{label:'لینک دکمه',value:props.attributes.buttonUrl,onChange:function(v){props.setAttributes({buttonUrl:v});}}),el(TextControl,{label:'آدرس تصویر',value:props.attributes.imageUrl,onChange:function(v){props.setAttributes({imageUrl:v});}}))),el('div',{className:'ostadi-hero__content'},el('span',{className:'ostadi-badge'},props.attributes.eyebrow),el(RichText,{tagName:'h1',value:props.attributes.title,onChange:function(v){props.setAttributes({title:v});}}),el(RichText,{tagName:'p',value:props.attributes.description,onChange:function(v){props.setAttributes({description:v});}}),el('span',{className:'ostadi-button'},props.attributes.buttonText+' ←')),props.attributes.imageUrl ? el('div',{className:'ostadi-hero__media'},el('img',{src:props.attributes.imageUrl,alt:props.attributes.title})) : null); },
        save: function () { return null; }
    });
    blocks.registerBlockType('ostadi/video-card', {
        edit: function (props) { return el('div', {}, el(InspectorControls,{},el(PanelBody,{title:'تنظیمات ویدئو'},el(TextControl,{label:'عنوان',value:props.attributes.title,onChange:function(v){props.setAttributes({title:v});}}),el(TextControl,{label:'توضیح',value:props.attributes.description,onChange:function(v){props.setAttributes({description:v});}}),el(TextControl,{label:'آدرس تصویر',value:props.attributes.imageUrl,onChange:function(v){props.setAttributes({imageUrl:v});}}),el(TextControl,{label:'لینک ویدئو',value:props.attributes.videoUrl,onChange:function(v){props.setAttributes({videoUrl:v});}}),el(TextControl,{label:'مدت زمان',value:props.attributes.duration,onChange:function(v){props.setAttributes({duration:v});}}))),el('article',{className:'ostadi-media-card'},el('div',{className:'ostadi-media-card__image'},props.attributes.imageUrl ? el('img',{src:props.attributes.imageUrl,alt:props.attributes.title}) : null,el('span',{className:'ostadi-play'},'▶')),el('div',{className:'ostadi-media-card__body'},el('h3',{},props.attributes.title),el('p',{},props.attributes.description))); },
        save: function () { return null; }
    });
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.components);
