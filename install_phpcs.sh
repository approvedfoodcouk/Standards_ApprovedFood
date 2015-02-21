#!/bin/bash
PATH_PRE=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
echo "Standards home: ${PATH_PRE}"

sudo phpcs --config-set tab_width 4

PHPCS_PACKAGES=(
    'ApprovedFood'
    'phpcompat'
    'a24'
    'phpcs-security-audit'
    'thinkup-codesniffer'
    'drupalcs'
    # 'vendor/fluidtypo3/code-standards'
    'vendor/wp-coding-standards/wpcs'
    'vendor/cakephp/cakephp-codesniffer/CakePHP'
)

RULES=""
PRE=""
for package in "${PHPCS_PACKAGES[@]}"
do
    RULES="${RULES}${PRE}${PATH_PRE}/${package}"
    PRE=","
done

phpcs --config-set installed_paths "${RULES}"
