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
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.components);
