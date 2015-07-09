<!-- MarkdownTOC -->

- [Profile manager](#profile-manager)
- [Pharse 'ListEmptyProfile'](#pharse-listemptyprofile)
    - [Customer](#customer)
        - [Given list profile empty](#given-list-profile-empty)
            - [When visit list profile page then](#when-visit-list-profile-page-then)
    - [Developer](#developer)
        - [Make app skeleton](#make-app-skeleton)
        - [Write specification code for "ListEmptyProfile"](#write-specification-code-for-listemptyprofile)
        - [Run unittest](#run-unittest)
        - [Quick & dirty way to write production code](#quick--dirty-way-to-write-production-code)
        - [Run unittest](#run-unittest-1)
        - [Refactoring code](#refactoring-code)
        - [Run unittest again](#run-unittest-again)
- [Pharse 'ListNonEmptyProfile'](#pharse-listnonemptyprofile)
    - [Customer](#customer-1)
        - [Given list profile not empty](#given-list-profile-not-empty)
            - [Profile info need display](#profile-info-need-display)
            - [When visit list profile page then](#when-visit-list-profile-page-then-1)
    - [Developer](#developer-1)
        - [Write specification code for "ProfileListPageIntergrateDbTest"](#write-specification-code-for-profilelistpageintergratedbtest)
        - [Run unittest](#run-unittest-2)
        - [Quick & dirty way to write production code](#quick--dirty-way-to-write-production-code-1)
        - [Run unittest](#run-unittest-3)
        - [Refactoring code](#refactoring-code-1)
        - [Run unittest again](#run-unittest-again-1)

<!-- /MarkdownTOC -->

Profile manager
===============

Practical TDD - gitflow - markdown

# Pharse 'ListEmptyProfile'

## Customer

### Given list profile empty

#### When visit list profile page then
1. I want to see page title 'list profile'
2. I want to see web page display "Empty list profile"

## Developer

### Make app skeleton

1. Install automation tool
2. Download composer phar
3. Install composer package
- phing
- phpunit
- zend framework 1
4. Write phing task phpunit

### Write specification code for "ListEmptyProfile"

1. Create tests/application/controller/ProfileListPageTest.php
2. When visit list profile page then

- expected response code equals 200
- expected request handler by
    + index action
    + profile controller
    + default module
- expected response content
    + contain title 'Profile list'
    + contain 'empty profile list'

### Run unittest

***expected test failed***

### Quick & dirty way to write production code

1. Create ProductController
2. Create index action
3. add head title
4. add 'Empty list profile' to index.phtml

### Run unittest

***expected test success***

### Refactoring code

add html layout

### Run unittest again

***expected test success***

# Pharse 'ListNonEmptyProfile'

## Customer

### Given list profile not empty

#### Profile info need display

- Profile id
- Profile fullname
- Profile age
- Profile email

#### When visit list profile page then
- i want to see all profile list
- table head bold

## Developer

### Write specification code for "ProfileListPageIntergrateDbTest"

1. Create tests/application/controller/ProfileListPageIntergrateDbTest.php
2. When visit list profile page then
- expected response content
    + contain table with thead tag
    + contain thead > th with 'id'
    + contain thead > th with 'fullname'
    + contain thead > th with 'age'
    + contain thead > th with 'email'
### Run unittest

***expected test failed***

### Quick & dirty way to write production code

1. Find and add phinx to composer.json (require-dev)
2. Create scripts/build/sql/create-database.sql
3. Create script CreateProfileTable in scripts/build/migrations by phinx
4. Add Application_Model_DbTable_Profile
5. Fill code to index action
6. Fill code to index.phtml

### Run unittest

***expected test success***

### Refactoring code

1. in profile/index.phtml switch case to display message 'profile list empty' or display table profile.

### Run unittest again
