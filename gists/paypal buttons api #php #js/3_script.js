class PayPalButtons {
    constructor(clientID) {
        this.clientID = clientID;
    }

    async init(items, selector, style = null) {
        if (!(items instanceof Array)) {
            items = [items];
        }

        if (document.querySelector('[data-paypal-js]') === null) {
            await new Promise((resolve, reject) => {
                let script = document.createElement('script');
                script.src = 'https://www.paypal.com/sdk/js?client-id=' + this.clientID + '&currency=EUR';
                script.setAttribute('data-paypal-js', '');
                script.onload = () => {
                    resolve();
                };
                document.head.appendChild(script);
            });
        }

        let fundingSources = [];
        fundingSources.push(paypal.FUNDING.PAYPAL);
        fundingSources.push(paypal.FUNDING.SEPA);
        if (items.reduce((a, c) => a + c.amount, 0) >= 1) {
            fundingSources.push(paypal.FUNDING.GIROPAY);
            fundingSources.push(paypal.FUNDING.SOFORT);
        }
        fundingSources.push(paypal.FUNDING.CARD);

        for (let fundingSource of fundingSources) {
            let args = {
                fundingSource: fundingSource,
                style: {
                    color: 'black',
                    shape: 'rect',
                    layout: 'horizontal'
                },
                createOrder: (data, actions) => {
                    let createOrderPayload = {
                        purchase_units: []
                    };
                    items.forEach((items__value, items__key) => {
                        createOrderPayload.purchase_units.push({
                            amount: {
                                value: items__value.amount,
                                currency_code: 'EUR',
                                breakdown: {
                                    item_total: {
                                        currency_code: 'EUR',
                                        value: items__value.amount
                                    }
                                }
                            },
                            items: [
                                {
                                    unit_amount: {
                                        currency_code: 'EUR',
                                        value: items__value.amount
                                    },
                                    quantity: '1',
                                    name: items__value.name,
                                    description: 'idfka'
                                }
                            ],
                            reference_id: items__key // required if multiple items are present
                        });
                    });
                    return actions.order.create(createOrderPayload);
                },
                onApprove: (data, actions) => {
                    return actions.order.capture().then(details => {
                        let payerName = details.payer.name.given_name;
                        console.log(details);
                        console.log('Transaction completed');
                        fetch('backend.php', {
                            method: 'POST',
                            body: JSON.stringify(details),
                            cache: 'no-cache',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(response => {
                                let data = response.json(),
                                    status = response.status;
                                if (status == 200 || status == 304) {
                                    return data;
                                }
                                return { success: false, message: status };
                            })
                            .catch(error => {
                                return { success: false, message: error };
                            })
                            .then(response => {
                                console.log([response.success, response.message, response.data]);
                                alert(response.public_message);
                          		// remove buttons
                          		document.querySelector(selector).remove();
                            });
                    });
                },
                onCancel: data => {
                    console.log(data);
                },
                onError: err => {
                    console.log(err);
                }
            };

            if (style !== null) {
                for (const [style__key, style__value] of Object.entries(style)) {
                    args.style[style__key] = style__value;
                }
            }

            /* card payments open for whatever reason inline */
            /* workaround this (https://github.com/paypal/paypal-checkout-components/issues/1521#issuecomment-821815565) */
            if (fundingSource === paypal.FUNDING.CARD) {
                args.onShippingChange = (data, actions) => {
                    return actions.resolve();
                };
            }

            let paypalButtonsComponent = paypal.Buttons(args);
            if (paypalButtonsComponent.isEligible()) {
                paypalButtonsComponent.render(selector).catch(err => {
                    console.log('PayPal Buttons failed to render');
                });
            } else {
                console.log('The funding source is ineligible');
            }
        }
    }
}

window.addEventListener('load', async e => {
    /* usage */
    let clientID = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',

    let p = new PayPalButtons(clientID);

    await p.init(
        {
            name: 'Testproduct #1',
            amount: 1.15
        },
        '.paypal-button-container--1',
        { shape: 'rect', color: 'black' }
    );

    await p.init(
        [
            {
                name: 'Testproduct #1',
                amount: 1.15
            },
            {
                name: 'Testproduct #2',
                amount: 2.2
            }
        ],
        '.paypal-button-container--2',
        { shape: 'pill', color: 'white' }
    );
});
