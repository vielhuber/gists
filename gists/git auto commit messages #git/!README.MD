##### modify git message

###### install
- `mkdir -p ~/git-template/hooks`
- `nano ~/git-template/hooks/prepare-commit-msg`
- `chmod +x ~/git-template/hooks/prepare-commit-msg`
- `git config --global core.hooksPath ~/git-template/hooks`

###### uninstall
- `git config --global --unset core.hooksPath`