function slugify(text)
{
      return text
                .toString()
                .toLowerCase()
                .trim()
                .split('ä').join('ae')
                .split('ö').join('oe')
                .split('ü').join('ue')
                .split('ß').join('ss')
                .replace(/[^\w\s-]/g, '') // remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                .replace(/[\s_-]+/g, '-') // swap any length of whitespace, underscore, hyphen characters with a single -
                .replace(/^-+|-+$/g, ''); // remove leading, trailing -
}