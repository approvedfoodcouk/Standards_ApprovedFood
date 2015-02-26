**Main codebase status**
[![Code Climate](https://codeclimate.com/repos/54dfa1ac69568016fc00ee88/badges/41fa8cb995a17eb24334/gpa.svg)](https://codeclimate.com/repos/54dfa1ac69568016fc00ee88/feed)
[![Test Coverage](https://codeclimate.com/repos/54dfa1ac69568016fc00ee88/badges/41fa8cb995a17eb24334/coverage.svg)](https://codeclimate.com/repos/54dfa1ac69568016fc00ee88/feed)
[![Circle CI](https://circleci.com/gh/approvedfoodcouk/af_web.svg?style=svg&circle-token=e8a47dba4eef52299165eabd07a6fdbc2008bbe3)](https://circleci.com/gh/approvedfoodcouk/af_web)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/approvedfoodcouk/af_web/badges/quality-score.png?b=master&s=76907f1b7ab9bf529c65c81fb967fefd8488f5b0)](https://scrutinizer-ci.com/g/approvedfoodcouk/af_web/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/approvedfoodcouk/af_web/badges/coverage.png?b=master&s=7adf2a16f2abc6804d3e09891bc9f12f79486e2f)](https://scrutinizer-ci.com/g/approvedfoodcouk/af_web/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/approvedfoodcouk/af_web/badges/build.png?b=master&s=ebbe869a1204f467d476c6021db27d824e7d7d32)](https://scrutinizer-ci.com/g/approvedfoodcouk/af_web/build-status/master)

Welcome to Approved Group Coding Standards
===================================

![acceptance-tests](https://cloud.githubusercontent.com/assets/1629421/5827702/8e8bd5d0-a0f4-11e4-87b4-773b046732bd.png)

These coding standards are used for all Approved Group web-based projects using a variety of tools including.

Inside you will find configuration files for popular tools including [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer), [JSLINT](http://www.jslint.com) and [SCSS-LINT](https://github.com/causes/scss-lint)
`phploc`, `pdepend`, `phpmd`, `phpdocumentor`, `phpunit` & Selenium Server

## Setup
To install the Approved Food coding standards clone the `git@github.com:approvedfoodcouk/Standards_ApprovedFood.git` somewhere outside of the _af_web_ code base.

Run the command `install_phpcs.sh` to setup the necessary global configurations & rulesets.

TODO: Move towards `composer` to hand git dependancies

Please also read & use the [Git Commit Message Conventions](https://github.com/approvedfoodcouk/Standards_ApprovedFood/blob/master/docs/git_commit_message_conventions.md)

## Notes

### Commenting out code without breaking standards

When commenting out blocks of code, Standards will often tell you everything is wrong with it. This code can be exlcluded by wrapping it in `// @codingStandardsIgnoreStart` and `// @codingStandardsIgnoreEnd` to inform the checkers to ignore this code.

**NOTE:** This is only acceptable for commented out code! Don't use it because you don't intend to fix the code.

``` php
// @codingStandardsIgnoreStart
/*
    $sql = 'SELECT distro_countries.* FROM distro_countries INNER JOIN distro_groups ON distro_groups.ID=group_id AND distro_groups.biz_id='.$GLOBALS['BUSINESS_ID'].' WHERE DISABLED=0 AND distro_countries.country_id='.$cont_id;
    $rs = DB::query($sql);
    $country = DB::fetch($rs);
    if (DB::numRows($rs)) { $country_invalid = false; }
*/
// @codingStandardsIgnoreEnd
```

### PHP Compatibility stand-alone testing

It can be useful to check a bunch of code for potential issues and it is possibly to expose PHP version issues with a single command.

`phpcs -l --standard=PHPCompatibility --extensions=php --runtime-set testVersion 5.6 .`

**Where:**
* `-l`  local directory only
* `--standard=PHPCompatibility` the standard itself
* `--extensions=php` file extensions, you may want to add `htm` if you have embedded php inside html files
* `--runtime-set testVersion 5.4` - specify the version of PHP to test for, typically the one your migrating towards
* `.` the directory to test inside, i.e., the current directory
