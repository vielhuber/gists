### tl;dr

- usage: ```wp_safe_redirect($url, $code = 302); die();``` / ```wp_redirect($url, $code = 302); die();```
- use ```wp_safe_redirect``` when you want to redirect internally (to another url on the same domain)
- use ```wp_redirect``` in all other cases

### notes

- ```wp_safe_redirect('https://www.your-wp-domain.com/foo')``` // works
- ```wp_safe_redirect('https://tld.com')``` // does not work, because wp_validate_redirect is false
- ```wp_redirect('https://tld.com')``` // works