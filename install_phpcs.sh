#!/bin/bash
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

PWD=$(pwd)
echo "Using rule parent directory ${PWD}"

BASEDIR=$(dirname $0)
echo "Script location: ${BASEDIR}"

PATH_PRE="${PWD}/${BASEDIR}"
echo "Standards home: ${PATH_PRE}"


RULES=""
PRE=""
for package in "${PHPCS_PACKAGES[@]}"
do
    RULES="${RULES}${PRE}${PATH_PRE}/${package}"
    PRE=","
done

phpcs --config-set installed_paths "${RULES}"
