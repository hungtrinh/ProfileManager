<!-- MarkdownTOC -->

- [Profile manager](#profile-manager)
- [Phrase 'ListEmptyProfile'](#phrase-listemptyprofile)
    - [Customer](#customer)
        - [Given list profile empty](#given-list-profile-empty)
            - [When visit list profile page then](#when-visit-list-profile-page-then)
    - [Developer](#developer)
        - [Make application skeleton](#make-application-skeleton)
        - [Write specification code for "ListEmptyProfile"](#write-specification-code-for-listemptyprofile)
        - [Run unit-test](#run-unit-test)
        - [Quick & dirty way to write production code](#quick--dirty-way-to-write-production-code)
        - [Run unit-test](#run-unit-test-1)
        - [Refactoring code](#refactoring-code)
        - [Run unit-test again](#run-unit-test-again)
- [Phrase 'ListNonEmptyProfile'](#phrase-listnonemptyprofile)
    - [Customer](#customer-1)
        - [Given list profile not empty](#given-list-profile-not-empty)
            - [Profile info need display](#profile-info-need-display)
            - [When visit list profile page then](#when-visit-list-profile-page-then-1)
    - [Developer](#developer-1)
        - [Write specification code for "ProfileListPageIntergrateDbTest"](#write-specification-code-for-profilelistpageintergratedbtest)
        - [Run unit-test](#run-unit-test-2)
        - [Quick & dirty way to write production code](#quick--dirty-way-to-write-production-code-1)
        - [Run unit-test](#run-unit-test-3)
        - [Refactoring code](#refactoring-code-1)
        - [Run unit-test again](#run-unit-test-again-1)
- [Phrase 'Pagination list profile'](#phrase-pagination-list-profile)
    - [Customer](#customer-2)
        - [Given list has many profile](#given-list-has-many-profile)
            - [When visit list profile page then](#when-visit-list-profile-page-then-2)
    - [Developer](#developer-2)
        - [Write specification code for "ProfileListPageIntergrateDbTest"](#write-specification-code-for-profilelistpageintergratedbtest-1)
            - [Specification verify paging logic right](#specification-verify-paging-logic-right)
            - [Specification verify paging area displayed](#specification-verify-paging-area-displayed)
        - [Run unit-test](#run-unit-test-4)
        - [Quick & dirty way to write production code](#quick--dirty-way-to-write-production-code-2)
        - [Refactoring code](#refactoring-code-2)

<!-- /MarkdownTOC -->

Profile manager
===============

Practical TDD - git flow - markdown

# Phrase 'ListEmptyProfile'

## Customer

### Given list profile empty

#### When visit list profile page then
1. I want to see page title 'list profile'
2. I want to see web page display "Empty list profile"

## Developer

### Make application skeleton

1. Install automation tool
2. Download composer.phar
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

### Run unit-test

***expected test failed***

### Quick & dirty way to write production code

1. Create ProductController
2. Create index action
3. add head title
4. add 'Empty list profile' to index.phtml

### Run unit-test

***expected test success***

### Refactoring code

add html layout

### Run unit-test again

***expected test success***

# Phrase 'ListNonEmptyProfile'

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

### Run unit-test

***expected test failed***

### Quick & dirty way to write production code

1. Find and add phinx to composer.json (require-dev)
2. Create scripts/build/sql/create-database.sql
3. Create script CreateProfileTable in scripts/build/migrations by phinx
4. Add Application_Model_DbTable_Profile
5. Fill code to index action
6. Fill code to index.phtml

### Run unit-test

***expected test success***

### Refactoring code

1. in profile/index.phtml switch case to display message 'profile list empty' or display table profile.

### Run unit-test again

# Phrase 'Pagination list profile'

## Customer

### Given list has many profile

#### When visit list profile page then
- i want to see 25 profile per page
- i want to see pagination region, has next,back, number to support switch all other page

## Developer

### Write specification code for "ProfileListPageIntergrateDbTest"

#### Specification verify paging logic right

When visit first page with page size equal one then show only first record base on list profile prepaired (mark test incomplete)

1. Write spec Profile Repository Interface
2. To be continue
    
#### Specification verify paging area displayed

1. To be continue

When visit when has many profile prepaired then show pagination region (mark test incomplete)

### Run unit-test 

***expected test failed***

### Quick & dirty way to write production code

***expected test success***

### Refactoring code

