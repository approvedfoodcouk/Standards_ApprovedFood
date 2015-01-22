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

### PHP Compatibility stand-alone testing

It can be useful to check a bunch of code for potential issues and it is possibly to expose PHP version issues with a single command.

`phpcs -l --standard=PHPCompatibility --extensions=php --runtime-set testVersion 5.4 .`

**Where:**
* `-l`  local directory only
* `--standard=PHPCompatibility` the standard itself
* `--extensions=php` file extensions, you may want to add `htm` if you have embedded php inside html files
* `--runtime-set testVersion 5.4` - specify the version of PHP to test for, typically the one your migrating towards
* `.` the directory to test inside, i.e., the current directory
