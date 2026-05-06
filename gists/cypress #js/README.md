## SETUP

- `apt-get install libgtk-3-0t64 libgbm-dev libnotify-dev libnss3 libxss1 libasound2t64 libxtst6 xauth xvfb`
- `git lfs install`
- `mkdir -d /var/www/project/path/to/cypress`
- `cd /var/www/project/path/to/cypress`

## PREPARE SEED FROM SQL

- `syncdb custom-production-local`
- `./db.sh prepare`

## CREATE TEST

- `CI=true php -S 0.0.0.0:8042 -t /var/www/project`
- Chrome: `http://localhost:8042`
- Network > Preserve log: an
- Record steps
- Right click > Copy > Copy all as HAR (sanitized)
- Copy to `/recordings/YYYY-MM-DD.har`

## RUN TEST

- `npm run cypress:open`
- `npm run cypress:run`
- `npm run cypress:run -- --spec "tests/basic.js"`

## FILES

## `.gitignore`

```
/node_modules
/package-lock.json
/snapshots
/cypress.env.json
```

## `.gitattributes`

```
dump/**/* filter=lfs diff=lfs merge=lfs -text
```

## `cypress.env.json`

```json
{
    "USERNAME": "change-me",
    "PASSWORD": "change-me"
}
```

## `package.json`

```json
{
    "scripts": {
        "cypress:open": "cypress open",
        "cypress:run": "DISPLAY= npx cypress run --browser electron --headless",
        "cypress:run:monkey": "DISPLAY= npx cypress run --browser electron --headless --spec tests/monkey.js"
    },
    "devDependencies": {
        "cypress": "^15.10.0",
        "@simonsmith/cypress-image-snapshot": "^10.0.3"
    }
}
```

## `tests/basic.js`

```js
describe('basic-test', () => {
    it('passes', () => {
        cy.restore('2026-03-02');

        cy.login();
        cy.matchImageSnapshot('_001');

        cy.visit('/');
        cy.matchImageSnapshot('_002');

        /* ... */
    });
});
```

## `tests/har.js`

```js
describe('har-test', () => {
    it('passes', () => {
        cy.restore('2026-03-08');
        cy.replay('2026-03-08');
    });
});
```

## `tests/monkey.js`

```js
describe('monkey-test', () => {
    it('runs seeded monkey fuzzing', () => {
        cy.restore('2026-03-08');
        cy.login();
        cy.visit('/');
        cy.runMonkey();
    });
});
```

## `db.sh`

```sh
#!/usr/bin/env bash

# config
DB_NAME="custom"
TABLES_TRIM=(table_1 table_2)
TABLES_TRUNCATE=(table_3 table_4 table_5)
TRIM_KEEP=100
MYSQL_HOST="127.0.0.1"
MYSQL_USER="root"
MYSQL_PASS="root"
LOCAL_URL="http://localhost:8042"

# only print real executed commands, skip variable assignments, conditionals and shell keywords
trap '
  cmd="$BASH_COMMAND"
  if [[ ! "$cmd" =~ ^([A-Za-z_][A-Za-z0-9_]*(\+?=|\[)|\[\[|for |if |elif |else$|fi$|do$|done$|then$|echo |return |:$|export ) ]]; then
    echo "ℹ️ $cmd"
  fi
' DEBUG

THREADS=8
DB_TEST="${DB_NAME}_test"
export MYSQL_PWD="$MYSQL_PASS"
TIMEFORMAT=$'\nreal\t%lR'
COMMAND="${1}"

if [[ "$COMMAND" == "prepare" ]]; then

  time {

    # copy + replace
    mysqldump -h "$MYSQL_HOST" -u "$MYSQL_USER" --routines "$DB_NAME" > dump.sql
    wget -q https://raw.githubusercontent.com/vielhuber/magicreplace/main/src/magicreplace.php
    php magicreplace.php dump.sql dump.sql "https://${DB_NAME}.vielhuber.dev" "$LOCAL_URL" "${DB_NAME}.vielhuber.dev" "${LOCAL_URL#http://}" > /dev/null
    mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -e "DROP DATABASE IF EXISTS \`$DB_TEST\`; CREATE DATABASE IF NOT EXISTS \`$DB_TEST\`;"
    mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" --default-character-set=utf8 "$DB_TEST" < dump.sql
    rm -f magicreplace.php dump.sql

    # cleanup
    mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" "$DB_TEST" -e "SET FOREIGN_KEY_CHECKS=0;"
    for t in "${TABLES_TRIM[@]}"; do \
      keycol="$(mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -N -s -e "SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA='${DB_TEST}' AND TABLE_NAME='${t}' AND CONSTRAINT_NAME='PRIMARY' ORDER BY ORDINAL_POSITION LIMIT 1;")";
      cutoff="$(mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -N -s -e "SELECT MIN(\`${keycol}\`) FROM (SELECT \`${keycol}\` FROM \`${DB_TEST}\`.\`${t}\` ORDER BY \`${keycol}\` DESC LIMIT ${TRIM_KEEP}) _keep;")";
      # faster than DELETE: create new table with only kept rows, then swap atomically
      mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" "$DB_TEST" -e "
        CREATE TABLE \`${t}_new\` LIKE \`${t}\`;
        INSERT INTO \`${t}_new\` SELECT * FROM \`${t}\` WHERE \`${keycol}\` >= ${cutoff};
        RENAME TABLE \`${t}\` TO \`${t}_old\`, \`${t}_new\` TO \`${t}\`;
        DROP TABLE \`${t}_old\`;
        ANALYZE TABLE \`${t}\`;
      " > /dev/null; \
    done
    for t in "${TABLES_TRUNCATE[@]}"; do mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" "$DB_TEST" -e "TRUNCATE TABLE \`$t\`; ANALYZE TABLE \`$t\`" > /dev/null; done
    mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" "$DB_TEST" -e "SET FOREIGN_KEY_CHECKS=1;"

    # export
    DUMP_DIR="./dump/$(date +%Y-%m-%d)"
    rm -rf "$DUMP_DIR"
    mkdir -p "$DUMP_DIR"
    mydumper -h "$MYSQL_HOST" -u "$MYSQL_USER" --password "$MYSQL_PASS" -B "$DB_TEST" -o "$DUMP_DIR" -t "$THREADS" --max-threads-per-table "$THREADS" --trx-tables --clear -F 64 2> >(grep -v "binlog coordinates will not be accurate\|Row bigger than statement_size" >&2)

    # track with git lfs
    git lfs track "./dump/**/*"

  }

elif [[ "$COMMAND" == "restore" ]]; then

    DUMP_DATE="${2:?Datum fehlt, z.B.: ./db.sh restore 2026-03-02}"
    DUMP_DIR="./dump/${DUMP_DATE}"
    if [[ ! -d "$DUMP_DIR" ]]; then
        echo "Fehler: Verzeichnis $DUMP_DIR existiert nicht."
        exit 1
    fi

    # drop
    mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -e "DROP DATABASE IF EXISTS \`$DB_TEST\`; CREATE DATABASE IF NOT EXISTS \`$DB_TEST\`;"

    # restore
    { time myloader -h "$MYSQL_HOST" -u "$MYSQL_USER" --password "$MYSQL_PASS" -B "$DB_TEST" -d "$DUMP_DIR" -t "$THREADS" --max-threads-per-table "$THREADS" --queries-per-transaction 100000 --checksum skip --skip-post --set-names utf8mb4; } 2> >(grep -v "Warnings found during INSERT" >&2)

fi
```

## `cypress.config.js`

```js
import { defineConfig } from 'cypress';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { addMatchImageSnapshotPlugin } from '@simonsmith/cypress-image-snapshot/plugin';

let width = 1920,
    height = 1080,
    config = JSON.parse(
        fs.readFileSync(path.join(path.dirname(fileURLToPath(import.meta.url)), 'cypress.env.json'), 'utf8')
    );

export default defineConfig({
    video: false,
    screenshotOnRunFailure: true,
    screenshotsFolder: 'snapshots',
    trashAssetsBeforeRuns: false,
    env: {
        ...config
    },
    viewportWidth: width,
    viewportHeight: height,
    e2e: {
        baseUrl: 'http://localhost:8042',
        supportFile: 'support.js',
        specPattern: 'tests/*.{js,jsx,ts,tsx}',
        experimentalInteractiveRunEvents: true,
        watchForFileChanges: false,
        setupNodeEvents(on, config) {
            on('task', {
                fileExists(filePath) {
                    return fs.existsSync(path.join(path.dirname(fileURLToPath(import.meta.url)), filePath));
                },
                log(message) {
                    console.log(message);
                    return null;
                }
            });
            on('before:browser:launch', (browser, launchOptions) => {
                if (browser.name === 'electron') {
                    launchOptions.preferences.width = width;
                    launchOptions.preferences.height = height;
                    launchOptions.preferences.fullscreen = true;
                }
                return launchOptions;
            });
            addMatchImageSnapshotPlugin(on, config);
            return config;
        }
    }
});
```

## `support.js`

```js
import { addMatchImageSnapshotCommand } from '@simonsmith/cypress-image-snapshot/command';
import { registerMonkeyCommands } from './monkey.js';

addMatchImageSnapshotCommand({
    failureThreshold: 0.1,
    failureThresholdType: 'percent'
});

registerMonkeyCommands();

Cypress.Commands.add('login', () => {
    cy.env(['USERNAME', 'PASSWORD']).then(({ USERNAME: username, PASSWORD: password }) => {
        cy.visit('/');
        cy.get('[name="log"]').type(username, { log: false });
        cy.get('[name="pwd"]').type(password, { log: false });
        cy.get('[name="wp-submit"]').click();
        cy.visit('/');
    });
});

beforeEach(() => {});

Cypress.Commands.add('restore', date => {
    cy.exec(`./db.sh restore ${date}`, {
        timeout: 120000
    });
});

Cypress.Commands.add('replay', harFixtureName => {
    const harFixturePath = harFixtureName + '.har';
    let snapshotPrefix = 'har' + harFixturePath,
        baseUrl = Cypress.config('baseUrl'),
        waitAfterNavigate = 800,
        waitAfterPost = 500,
        snapshotOptions = {};

    cy.readFile('recordings/' + harFixturePath).then(raw => {
        const har = typeof raw === 'string' ? JSON.parse(raw) : raw;
        const entries = har.log.entries.sort((a, b) => new Date(a.startedDateTime) - new Date(b.startedDateTime));
        let snapshotIndex = 1;

        const snap = label => {
            /*
            let name = `${snapshotPrefix}-${String(snapshotIndex++).padStart(3, '0')}-${label}`
                .replace(/[^a-zA-Z0-9-_]/g, '_')
                .substring(0, 80);
            */
            let name = '_' + snapshotIndex++;
            cy.matchImageSnapshot(name, snapshotOptions);
        };

        // Klassifiziere jeden Entry
        const steps = entries.map(entry => {
            const url = new URL(entry.request.url);
            const method = entry.request.method;
            const accept = (entry.request.headers || []).find(h => h.name.toLowerCase() === 'accept');
            const isDocument =
                entry._resourceType === 'document' || (method === 'GET' && accept?.value?.includes('text/html'));

            return { entry, method, url, isDocument };
        });

        steps.forEach(step => {
            const { entry, method, url, isDocument } = step;
            const path = url.pathname + url.search;

            if (isDocument && method === 'GET') {
                // ====== Seitennavigation ======
                const targetUrl = baseUrl ? path : entry.request.url;
                cy.visit(targetUrl, { failOnStatusCode: false });
                cy.wait(waitAfterNavigate);
                snap(path.replace(/\//g, '_'));
            } else if (method === 'POST' || method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
                // ====== Schreibende Requests → echt ausführen ======
                const headers = Object.fromEntries(
                    (entry.request.headers || [])
                        .filter(
                            h =>
                                !['host', 'content-length', 'connection', 'accept-encoding'].includes(
                                    h.name.toLowerCase()
                                )
                        )
                        .map(h => [h.name, h.value])
                );

                let body = entry.request.postData?.text || undefined;
                const mimeType = entry.request.postData?.mimeType || '';

                // JSON body parsen
                if (mimeType.includes('application/json') && body) {
                    try {
                        body = JSON.parse(body);
                    } catch {}
                }

                const targetUrl = baseUrl ? `${baseUrl}${path}` : entry.request.url;

                cy.request({
                    method,
                    url: targetUrl,
                    body,
                    headers,
                    failOnStatusCode: false,
                    followRedirect: false
                }).then(response => {
                    const contentType = response.headers['content-type'] || '';
                    const location = response.headers['location'];
                    if (location) {
                        // follow redirect
                        cy.visit(location, { failOnStatusCode: false });
                        cy.wait(waitAfterNavigate);
                    } else if (contentType.includes('text/html')) {
                        // render returned HTML directly
                        cy.document().then(doc => {
                            doc.open();
                            doc.write(response.body);
                            doc.close();
                        });
                        cy.wait(waitAfterNavigate);
                    } else {
                        // reload to reflect side effects
                        cy.reload();
                        cy.wait(waitAfterNavigate);
                    }
                });

                cy.wait(waitAfterPost);
                snap(`${method}_${path.replace(/\//g, '_')}`);
            }
            // API-GETs (XHR/fetch) → ignorieren, passieren automatisch beim visit/reload
        });
    });
});
```

## `monkey.js`

```js
const MONKEY_DANGEROUS_TOKENS = [
    'delete',
    'remove',
    'destroy',
    'truncate',
    'drop',
    'logout',
    'signout',
    'abmelden',
    'loeschen',
    'loschen',
    'loesch',
    'lorsch',
    'entfernen',
    'kuend',
    'storn',
    'archiv',
    'reset',
    'revoke'
];

const MONKEY_SELECTORS = {
    click: ['a[href]', 'button', '[role="button"]', 'input[type="submit"]', 'input[type="button"]', 'summary'].join(
        ','
    ),
    type: [
        'textarea',
        'input:not([type])',
        'input[type="text"]',
        'input[type="search"]',
        'input[type="email"]',
        'input[type="url"]',
        'input[type="tel"]',
        'input[type="number"]',
        'input[type="date"]',
        'input[type="datetime-local"]',
        'input[type="month"]',
        'input[type="time"]',
        'input[type="week"]'
    ].join(','),
    toggle: 'input[type="checkbox"], input[type="radio"]',
    select: 'select'
};

const MONKEY_DEFAULTS = {
    seed: '20260309',
    steps: 50,
    settleMs: 250,
    startPath: '/',
    allowBack: true,
    screenshotEachStep: true,
    blackout: [],
    recordFile: 'recordings/monkey/2026-03-08-20260309.json',
    snapshotPrefix: 'monkey/2026-03-08/20260309',
    weights: {
        click: 5,
        type: 3,
        select: 2,
        toggle: 2,
        back: 1
    }
};

const monkeyFormatDuration = milliseconds => {
    const totalSeconds = Math.max(0, Math.round(milliseconds / 1000));
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;

    return `${minutes}m ${String(seconds).padStart(2, '0')}s`;
};

const monkeyPrintStatus = message => {
    Cypress.log({
        name: 'monkey',
        message
    });

    return cy.task('log', message, { log: false });
};

const monkeyDescribeStep = step => {
    const label = (step.label || '').trim();

    if (step.action === 'type') {
        return `${step.action} ${step.tagName}${step.name ? `:${step.name}` : ''} = ${String(step.value || '').slice(0, 40)}`;
    }
    if (step.action === 'select') {
        return `${step.action} ${step.tagName}${step.name ? `:${step.name}` : ''} = ${String(step.value || '').slice(0, 40)}`;
    }
    if (step.action === 'visit') {
        return `${step.action} ${step.target}`;
    }
    if (step.action === 'back') {
        return 'back';
    }

    return `${step.action} ${step.tagName}${label ? ` ${label.slice(0, 40)}` : ''}`;
};

const createMonkeySeed = seedValue => {
    const input = String(seedValue ?? Date.now());
    let state = 0;

    for (let index = 0; index < input.length; index++) {
        state = (state * 31 + input.charCodeAt(index)) >>> 0;
    }

    return state || 1;
};

const createMonkeyRandom = seedValue => {
    let state = createMonkeySeed(seedValue);

    return () => {
        state = (state * 1664525 + 1013904223) >>> 0;
        return state / 4294967296;
    };
};

const monkeyPickIndex = (length, nextRandom) => {
    if (length <= 1) {
        return 0;
    }

    return Math.min(length - 1, Math.floor(nextRandom() * length));
};

const monkeyBuildScreenshotName = (prefix, stepIndex, action) => {
    return [prefix, `${String(stepIndex + 1).padStart(4, '0')}-${action}`].join('/');
};

const monkeyGetElementText = element => {
    return [
        element.getAttribute('aria-label'),
        element.getAttribute('title'),
        element.getAttribute('name'),
        element.getAttribute('value'),
        element.textContent
    ]
        .filter(Boolean)
        .join(' ')
        .replace(/\s+/g, ' ')
        .trim();
};

const monkeyGetFieldType = element => {
    if ((element.tagName || '').toLowerCase() === 'textarea') {
        return 'textarea';
    }

    return String(element.type || element.getAttribute('type') || 'text').toLowerCase();
};

const monkeyIsVisible = element => {
    if (!(element instanceof element.ownerDocument.defaultView.HTMLElement)) {
        return false;
    }

    const rect = element.getBoundingClientRect();
    const style = element.ownerDocument.defaultView.getComputedStyle(element);

    if (rect.width <= 0 || rect.height <= 0) {
        return false;
    }
    if (style.visibility === 'hidden' || style.display === 'none' || style.pointerEvents === 'none') {
        return false;
    }

    return true;
};

const monkeyIsDisabled = element => {
    return element.matches(':disabled') || element.getAttribute('aria-disabled') === 'true';
};

const monkeyIsDangerous = element => {
    const text = monkeyGetElementText(element).toLowerCase();
    const href = (element.getAttribute('href') || '').toLowerCase();
    const onclick = (element.getAttribute('onclick') || '').toLowerCase();
    const haystack = `${text} ${href} ${onclick}`;

    if (href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
        return true;
    }

    return MONKEY_DANGEROUS_TOKENS.some(token => haystack.includes(token));
};

const monkeyGetCandidates = (doc, group) => {
    return [...doc.querySelectorAll(MONKEY_SELECTORS[group] || '')].filter(element => {
        if (!monkeyIsVisible(element) || monkeyIsDisabled(element) || monkeyIsDangerous(element)) {
            return false;
        }

        if (group === 'select') {
            return [...element.options].some(option => !option.disabled && option.value !== '');
        }

        return true;
    });
};

const monkeyPickWeightedAction = (groups, settings, nextRandom) => {
    const weightedActions = [];

    if (groups.click.length > 0) {
        weightedActions.push({ action: 'click', weight: settings.weights.click });
    }
    if (groups.type.length > 0) {
        weightedActions.push({ action: 'type', weight: settings.weights.type });
    }
    if (groups.select.length > 0) {
        weightedActions.push({ action: 'select', weight: settings.weights.select });
    }
    if (groups.toggle.length > 0) {
        weightedActions.push({ action: 'toggle', weight: settings.weights.toggle });
    }
    if (settings.allowBack) {
        weightedActions.push({ action: 'back', weight: settings.weights.back });
    }

    const totalWeight = weightedActions.reduce((sum, item) => sum + item.weight, 0);
    if (totalWeight === 0) {
        return 'visit';
    }

    let value = nextRandom() * totalWeight;

    for (const item of weightedActions) {
        value -= item.weight;
        if (value <= 0) {
            return item.action;
        }
    }

    return weightedActions[weightedActions.length - 1].action;
};

const monkeyCreateTypedValue = (element, nextRandom, stepIndex) => {
    const type = monkeyGetFieldType(element);
    const serial = Math.floor(nextRandom() * 100000);
    const day = String((stepIndex % 28) + 1).padStart(2, '0');
    const minute = String(serial % 60).padStart(2, '0');
    const week = String((stepIndex % 52) + 1).padStart(2, '0');

    if (type === 'email') {
        return `monkey.${stepIndex}.${serial}@example.test`;
    }
    if (type === 'url') {
        return `https://example.test/${serial}`;
    }
    if (type === 'tel') {
        return `089${String(serial).padStart(6, '0').slice(0, 6)}`;
    }
    if (type === 'number') {
        return String(Math.floor(nextRandom() * 10000));
    }
    if (type === 'date') {
        return `2026-03-${day}`;
    }
    if (type === 'datetime-local') {
        return `2026-03-${day}T12:${minute}`;
    }
    if (type === 'month') {
        return '2026-03';
    }
    if (type === 'time') {
        return `12:${minute}`;
    }
    if (type === 'week') {
        return `2026-W${week}`;
    }

    const samples = [
        'alpha test',
        'beta 42',
        'gamma /?foo=bar',
        'delta+check@example.test',
        'epsilon <tag>',
        'zeta & value',
        'eta 2026-03-09'
    ];

    return `${samples[monkeyPickIndex(samples.length, nextRandom)]} ${serial}`;
};

const monkeyNormalizeTypedValue = (element, rawValue) => {
    const type = monkeyGetFieldType(element);
    const value = String(rawValue ?? '');

    if (type === 'date') {
        return /^\d{4}-\d{2}-\d{2}$/.test(value) ? value : '2026-03-09';
    }
    if (type === 'datetime-local') {
        return /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/.test(value) ? value : '2026-03-09T12:00';
    }
    if (type === 'month') {
        return /^\d{4}-\d{2}$/.test(value) ? value : '2026-03';
    }
    if (type === 'time') {
        return /^\d{2}:\d{2}$/.test(value) ? value : '12:00';
    }
    if (type === 'week') {
        return /^\d{4}-W\d{2}$/.test(value) ? value : '2026-W10';
    }

    return value;
};

const monkeyCreateStep = (doc, settings, nextRandom, stepIndex) => {
    const groups = {
        click: monkeyGetCandidates(doc, 'click'),
        type: monkeyGetCandidates(doc, 'type'),
        toggle: monkeyGetCandidates(doc, 'toggle'),
        select: monkeyGetCandidates(doc, 'select')
    };
    const action = monkeyPickWeightedAction(groups, settings, nextRandom);
    const currentUrl = `${doc.location.pathname}${doc.location.search}`;

    if (action === 'visit') {
        return {
            action: 'visit',
            target: settings.startPath,
            url: currentUrl
        };
    }

    if (action === 'back') {
        return {
            action: 'back',
            url: currentUrl
        };
    }

    const candidates = groups[action];
    if (!candidates || candidates.length === 0) {
        return {
            action: 'visit',
            target: settings.startPath,
            url: currentUrl
        };
    }

    const index = monkeyPickIndex(candidates.length, nextRandom);
    const element = candidates[index];
    const step = {
        action,
        index,
        url: currentUrl,
        label: monkeyGetElementText(element).slice(0, 120),
        tagName: element.tagName.toLowerCase(),
        name: element.getAttribute('name') || null
    };

    if (action === 'type') {
        step.value = monkeyNormalizeTypedValue(element, monkeyCreateTypedValue(element, nextRandom, stepIndex));
    }
    if (action === 'select') {
        const options = [...element.options].filter(option => !option.disabled && option.value !== '');
        step.value = options[monkeyPickIndex(options.length, nextRandom)].value;
    }

    return step;
};

const monkeySaveRun = payload => {
    return cy.writeFile(payload.recordFile, payload.data, {
        log: false,
        timeout: 120000
    });
};

const monkeyAssertPage = () => {
    return cy.document({ log: false }).then(doc => {
        const bodyText = (doc.body?.innerText || '').toLowerCase();
        const html = doc.documentElement.innerHTML.toLowerCase();

        expect(doc.body, 'body').to.exist;
        expect(bodyText, 'fatal error').not.to.include('fatal error');
        expect(bodyText, 'critical error').not.to.include('critical error on this website');
        expect(bodyText, 'uncaught').not.to.include('uncaught');
        expect(html, 'php warning').not.to.include('warning:</b>');
        expect(html, 'php notice').not.to.include('notice:</b>');
        expect(html, 'php parse error').not.to.include('parse error');
    });
};

const monkeyExecuteStep = (step, settings) => {
    if (step.action === 'visit') {
        return cy.visit(step.target, { failOnStatusCode: false });
    }
    if (step.action === 'back') {
        return cy.go('back');
    }

    return cy.document({ log: false }).then(doc => {
        const candidates = monkeyGetCandidates(doc, step.action);
        const element = candidates[step.index];

        if (!element) {
            return cy.visit(settings.startPath, { failOnStatusCode: false });
        }

        const chain = cy.wrap(element, { log: false }).scrollIntoView({ log: false });

        if (step.action === 'click') {
            return chain.click({ force: true, log: false });
        }
        if (step.action === 'toggle') {
            return chain.click({ force: true, log: false });
        }
        if (step.action === 'type') {
            const value = monkeyNormalizeTypedValue(element, step.value);

            return chain
                .focus({ log: false })
                .invoke('val', value)
                .trigger('input', { force: true, log: false })
                .trigger('change', { force: true, log: false })
                .trigger('keyup', { force: true, log: false })
                .blur({ log: false });
        }
        if (step.action === 'select') {
            return chain.select(step.value, { force: true, log: false });
        }
    });
};

export const registerMonkeyCommands = () => {
    const createMonkeyRun = settings => {
        const nextRandom = createMonkeyRandom(settings.seed);
        const startedAt = new Date().toISOString();
        const startedAtMs = Date.now();
        const steps = [];
        const meta = {
            seed: String(settings.seed),
            steps: settings.steps,
            startPath: settings.startPath,
            startedAt
        };

        const runStep = stepIndex => {
            if (stepIndex >= settings.steps) {
                return monkeySaveRun({
                    recordFile: settings.recordFile,
                    data: {
                        meta,
                        steps
                    }
                }).then(() => {
                    const duration = monkeyFormatDuration(Date.now() - startedAtMs);

                    return monkeyPrintStatus(
                        `Monkey finished: mode=create, steps=${settings.steps}, duration=${duration}, seed=${settings.seed}`
                    ).then(() => cy.wrap(steps, { log: false }));
                });
            }

            return cy.document({ log: false }).then(doc => {
                const step = monkeyCreateStep(doc, settings, nextRandom, stepIndex);
                steps.push(step);

                return monkeyPrintStatus(
                    `Monkey step ${stepIndex + 1}/${settings.steps}: ${monkeyDescribeStep(step)}`
                ).then(() => {
                    return monkeySaveRun({
                        recordFile: settings.recordFile,
                        data: {
                            meta,
                            steps
                        }
                    }).then(() => {
                        return monkeyExecuteStep(step, settings)
                            .then(() => cy.wait(settings.settleMs, { log: false }))
                            .then(() => monkeyAssertPage())
                            .then(() => {
                                if (settings.screenshotEachStep !== true) {
                                    return;
                                }

                                return cy.matchImageSnapshot(
                                    monkeyBuildScreenshotName(settings.snapshotPrefix, stepIndex, step.action),
                                    {
                                        blackout: settings.blackout
                                    }
                                );
                            })
                            .then(() => runStep(stepIndex + 1));
                    });
                });
            });
        };

        const estimatedMinimumDuration = monkeyFormatDuration(settings.steps * settings.settleMs);

        return monkeyPrintStatus(
            `Monkey started: mode=create, steps=${settings.steps}, settleMs=${settings.settleMs}, estimated-min=${estimatedMinimumDuration}, seed=${settings.seed}`
        ).then(() => runStep(0));
    };

    const replayMonkeyRun = recordFile => {
        return cy.readFile(recordFile).then(run => {
            const settings = Cypress._.merge({}, MONKEY_DEFAULTS, run.meta || {}, { recordFile });
            const startedAtMs = Date.now();
            const steps = run.steps || [];

            const replayStep = stepIndex => {
                if (stepIndex >= steps.length) {
                    const duration = monkeyFormatDuration(Date.now() - startedAtMs);

                    return monkeyPrintStatus(
                        `Monkey finished: mode=replay, steps=${steps.length}, duration=${duration}, seed=${settings.seed}`
                    ).then(() => cy.wrap(steps, { log: false }));
                }

                return monkeyPrintStatus(
                    `Monkey step ${stepIndex + 1}/${steps.length}: ${monkeyDescribeStep(steps[stepIndex])}`
                ).then(() => {
                    return monkeyExecuteStep(steps[stepIndex], settings)
                        .then(() => cy.wait(settings.settleMs, { log: false }))
                        .then(() => monkeyAssertPage())
                        .then(() => {
                            if (settings.screenshotEachStep !== true) {
                                return;
                            }

                            return cy.matchImageSnapshot(
                                monkeyBuildScreenshotName(settings.snapshotPrefix, stepIndex, steps[stepIndex].action),
                                {
                                    blackout: settings.blackout
                                }
                            );
                        })
                        .then(() => replayStep(stepIndex + 1));
                });
            };

            const estimatedMinimumDuration = monkeyFormatDuration(steps.length * settings.settleMs);

            return monkeyPrintStatus(
                `Monkey started: mode=replay, steps=${steps.length}, settleMs=${settings.settleMs}, estimated-min=${estimatedMinimumDuration}, seed=${settings.seed}`
            ).then(() => replayStep(0));
        });
    };

    Cypress.Commands.add('runMonkey', () => {
        const settings = Cypress._.cloneDeep(MONKEY_DEFAULTS);

        return cy.task('fileExists', settings.recordFile, { log: false }).then(exists => {
            if (exists) {
                return replayMonkeyRun(settings.recordFile);
            }

            return createMonkeyRun(settings);
        });
    });

    Cypress.Commands.add('replayMonkey', () => {
        return replayMonkeyRun(MONKEY_DEFAULTS.recordFile);
    });
};
```
