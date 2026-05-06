# auto switch
find_up() {
    local file="$1"
    local dir="$PWD"
    while [[ "$dir" != "/" ]]; do
        if [[ -f "$dir/$file" ]]; then
            echo "$dir/$file"
            return 0
        fi
        dir="$(dirname "$dir")"
    done
    [[ -f "/$file" ]] && echo "/$file" && return 0
    return 1
}
file_sig() {
    local f="$1"
    [[ -f "$f" ]] || return 1
    stat -c '%Y:%s' "$f" 2>/dev/null
}
auto_switch() {
    if [[ $PWD == $PREV_PWD ]]; then
        return
    fi
    PREV_PWD=$PWD
    local nvmrc phprc envrc
    nvmrc=$(find_up ".nvmrc")
    phprc=$(find_up ".phprc")
    envrc=$(find_up ".envrc")
    if [[ -n "$nvmrc" ]]; then
        if [[ "$nvmrc" != "$PREV_NVMRC" ]]; then
            PREV_NVMRC="$nvmrc"
            PREV_NVMRC_SIG=$(file_sig "$nvmrc")
            nvm use --silent && echo "switch to node $(cat "$nvmrc") (from $nvmrc)"
        fi
    else
        PREV_NVMRC=""
        PREV_NVMRC_SIG=""
    fi
    if [[ -n "$phprc" ]]; then
        if [[ "$phprc" != "$PREV_PHPRC" ]]; then
            PREV_PHPRC="$phprc"
            PREV_PHPRC_SIG=$(file_sig "$phprc")
            local ver=$(cat "$phprc")
            # remove old, add new
            PATH=$(echo "$PATH" | tr ':' '\n' | grep -v '/tmp/php-override-' | tr '\n' ':' | sed 's/:$//')
            mkdir -p /tmp/php-override-$$
            ln -sf /usr/bin/php${ver} /tmp/php-override-$$/php
            export PATH="/tmp/php-override-$$:$PATH"
            echo "switch to php ${ver} (from $phprc)"
        fi
    else
        PREV_PHPRC=""
        PREV_PHPRC_SIG=""
        # remove override
        PATH=$(echo "$PATH" | tr ':' '\n' | grep -v '/tmp/php-override-' | tr '\n' ':' | sed 's/:$//')
    fi
    if [[ -n "$envrc" ]]; then
        if [[ "$envrc" != "$PREV_ENVRC" ]]; then
            PREV_ENVRC="$envrc"
            PREV_ENVRC_SIG=$(file_sig "$envrc")
            source "$(cat "$envrc")/bin/activate" \
              && echo "switch to python $(cat "$envrc") (from $envrc)"
        fi
    else
        PREV_ENVRC=""
        PREV_ENVRC_SIG=""
    fi
}
export PROMPT_COMMAND=auto_switch