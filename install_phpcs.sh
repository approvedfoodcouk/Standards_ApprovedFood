#!/bin/bash
PATH_PRE=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
echo "Standards home: ${PATH_PRE}"

vendor/bin/phpcs --config-set tab_width 4

PHPCS_PACKAGES=(
    'ApprovedFood'
    'phpcs-security-audit'
    'drupalcs'
    'thinkup-codesniffer'
    # 'vendor/fluidtypo3/code-standards'
    'vendor/phpcompat'
    'vendor/a24'
    'vendor/wp-coding-standards/wpcs'
    'vendor/cakephp/cakephp-codesniffer'
)

RULES=""
PRE=""
for package in "${PHPCS_PACKAGES[@]}"
do
    RULES="${RULES}${PRE}${PATH_PRE}/${package}"
    PRE=","
done

vendor/bin/phpcs --config-set installed_paths "${RULES}"
vendor/bin/phpcs -i
