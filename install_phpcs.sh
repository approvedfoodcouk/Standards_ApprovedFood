#!/bin/sh
sudo phpcs --config-set tab_width 4

PHPCS_PACKAGES=(
    'ApprovedFood'
    'wpcs'
    'phpcompat'
    'a24'
    'phpcs-security-audit'
    'thinkup-codesniffer'
    'drupalcs'
    # 'vendor/fluidtypo3/code-standards'
    'vendor/cakephp/cakephp-codesniffer/CakePHP'
)

PATH_PRE=$(pwd)
RULES=""
PRE=""
for package in "${PHPCS_PACKAGES[@]}"
do
    RULES="${RULES}${PRE}${PATH_PRE}/${package}"
    PRE=","
done

phpcs --config-set installed_paths "${RULES}"
