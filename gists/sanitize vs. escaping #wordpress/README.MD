## sanitizing

do sanitization when accepting input and storing it to the database.

#### most common functions
- `sanitize_text_field()`
- `sanitize_textarea_field()`
- `sanitize_email()`
- `wp_filter_post_kses()`
- `wp_kses_post()`

#### more functions
- `sanitize_user()`
- `esc_url_raw()`
- `sanitize_file_name()`
- `sanitize_html_class()`
- `sanitize_key()`
- `sanitize_meta()`
- `sanitize_mime_type()`
- `sanitize_option()`
- `sanitize_sql_orderby()`
- `sanitize_title()`
- `sanitize_title_for_query()`
- `sanitize_title_with_dashes()`
- `wp_filter_nohtml_kses()`

## escaping

do escaping when you want to secure your output and prevent this data from being seen as code in the frontend.

#### most common functions
- `esc_attr()`
- `esc_html()`
- `esc_textarea()`
- `esc_url()`

#### more functions
- `esc_js()`
- `esc_html__()`
- `esc_attr__()`