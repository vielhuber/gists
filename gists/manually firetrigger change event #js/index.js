# this fires only on vanillajs event listeners (not jquery!)
el.dispatchEvent(new Event('change'));

# be aware, this does not fire with vanillajs event listenes!
$(el).change();