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
auto_switch() {
    if [[ $PWD == $PREV_PWD ]]; then
        return
    fi
    PREV_PWD=$PWD
    local nvmrc=$(find_up ".nvmrc")
    local phprc=$(find_up ".phprc")
    local envrc=$(find_up ".envrc")
    [[ -n "$nvmrc" ]] && nvm use --silent && echo "switch to node $(cat "$nvmrc") (from $nvmrc)"
    [[ -n "$phprc" ]] && sudo update-alternatives --set php /usr/bin/php$(cat "$phprc") && echo "switch to php $(cat "$phprc") (from $phprc)"
    [[ -n "$envrc" ]] && source "$(cat "$envrc")/bin/activate" && echo "switch to python $(cat "$envrc") (from $envrc)"
}
export PROMPT_COMMAND=auto_switch