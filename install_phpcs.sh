#!/bin/bash
PATH_PRE=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
echo "Standards home: ${PATH_PRE}"

#Install PHPCS globally to ensure installed packages are globally available.
composer global require "squizlabs/php_codesniffer=2.*"
PHPCS=~/.composer/vendor/bin/phpcs

$PHPCS --config-set tab_width 4

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

$PHPCS --config-set installed_paths "${RULES}"
$PHPCS -i
