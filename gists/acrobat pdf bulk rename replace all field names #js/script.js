var fields = [];
for (var i = 0; i < this.numFields; i++) {
    fields.push(this.getNthFieldName(i));
}
for (var i = 0; i < fields.length; i++) {
    var source_name = fields[i];

    // skip some names
    if (source_name.indexOf('.') === -1) {
        continue;
    }

    // modifications to name
    var target_name = source_name;
    target_name = source_name.replace(/\./g, '#');
    // other replacements (examples)
    /*
    target_name = target_name.toLowerCase();
    target_name = target_name.replace(/\s/g, '');
    target_name = target_name.replace(/\ß/g, 'ss');
    target_name = target_name.replace(/\-|\/|\*|\.|\;|\:/g, '_');
    */

    var source_field = this.getField(source_name);

    if (source_field !== null) {
        // debug output (if needed)
        //console.println(JSON.stringify([target_name, source_field.type, source_field.page, source_field.rect]));
        var target_field = this.addField(
            target_name,
            source_field.type,
            source_field.page,
            source_field.rect
        );
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
        for (var p = 0; p < props.length; p++) {
            if (testField(source_field, props[p])) {
                target_field[props[p]] = source_field[props[p]];
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