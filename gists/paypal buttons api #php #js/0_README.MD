#### links

- https://developer.paypal.com/sdk/js/reference/
- https://developer.paypal.com/integration-builder
- https://stackoverflow.com/questions/57659436/is-server-side-paypal-payment-verification-actually-needed

#### caveats
- the popup of giropay/sofort does not open in test mode
- in live mode, they only work with
    - minimum amount: 1€
    - https://www.paypal.com/businessmanage/preferences/payments > "Ja, akzeptieren und umrechnen in Euro. Es fallen zusätzliche Gebühren an"
    - https://www.paypal.com/businessmanage/account/money > you have to add a credit card (changes take some time to apply)
