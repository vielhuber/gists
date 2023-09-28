var fields = [];
var props = [
    'alignment',
    'borderStyle',
    'buttonAlignX',
    'buttonAlignY',
    'buttonFitBounds',
    'buttonScaleHow',
    'buttonScaleWhen',
    'comb',
    'display',
    'doNotScroll',
    'editable',
    'exportValues',
    'fileSelect',
    'fillColor',
    'highlight',
    'lineWidth',
    'multiline',
    'multipleSelection',
    'numItems',
    'password',
    'readonly',
    'richText',
    'richValue',
    'rotation',
    'strokeColor',
    'style',
    'textColor',
    'textFont',
    'textSize',
    'userName'
];
for (var i = 0; i < this.numFields; i++) {
    fields.push(this.getNthFieldName(i));
}
loop:
for (var i = 0; i < fields.length; i++) {
    var source_name = fields[i];

    // skip some names if needed
    //if (source_name.indexOf('.') === -1) { continue; }

    // modifications to name (various examples)
    var target_name = source_name;
    target_name = target_name+'_'+(i+1);
    //target_name = source_name.replace(/\./g, '#');
    //target_name = target_name.toLowerCase();
    //target_name = target_name.replace(/\s/g, '');
    //target_name = target_name.replace(/\ß/g, 'ss');
    //target_name = target_name.replace(/\-|\/|\*|\.|\;|\:/g, '_');
    //target_name = target_name+'-S1';
    
    if( source_name === target_name ) {
        continue;
    }

    var source_field = this.getField(source_name);

    if (source_field !== null) {
        // debug output (if needed)
        //console.println(JSON.stringify([target_name, source_field.type, source_field.page, source_field.rect]));

        var page = source_field.page;
        if( !Array.isArray(page) ) { page = [page]; }
        for(var pages__value = 0; pages__value < page.length; pages__value++) {
            var rename = target_name;
            // completely unique name (if needed)
            if( 1===1 ) {
                rename = target_name + '_' + pages__value;
            }
            if( source_name === rename ) { continue loop; }
            var rect = this.getField(source_name+'.'+pages__value).rect;
            var target_field = this.addField(
                rename,
                source_field.type,
                page[pages__value],
                rect
            );
        }
        for (var p = 0; p < props.length; p++) {
            if (testField(source_field, props[p])) {
                target_field[props[p]] = source_field[props[p]];
            }
        }
        // support dropdowns
        if( testField(source_field, 'numItems') ) {
            for(var dd = source_field.numItems-1; dd >= 0; dd--) {
                target_field.insertItemAt(source_field.getItemAt(dd), -1);
            }
        }
        this.removeField(source_name);
    }
}
function testField(field, prop) {
    try {
        var tprop = field[prop];
        return true;
    } catch (e) {
        return false;
    }
}