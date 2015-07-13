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
    - [Customer](#customer-2)
        - [Need Create Profile Page](#need-create-profile-page)
        - [Show form profile when visit](#show-form-profile-when-visit)
    - [Developer](#developer-2)
        - [Write spect code for 'create-profile-page'](#write-spect-code-for-create-profile-page)
            - [When use visit create profile page then show form profile](#when-use-visit-create-profile-page-then-show-form-profile)
            - [Run Unit-test](#run-unit-test-4)
        - [Quick & dirty way to write production code](#quick--dirty-way-to-write-production-code-2)
            - [Run Unit-test again](#run-unit-test-again-2)
        - [Refactoring code](#refactoring-code-2)
            - [Run Unit-test again](#run-unit-test-again-3)

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

## Customer

### Need Create Profile Page

### Show form profile when visit

## Developer

### Write spect code for 'create-profile-page'

#### When use visit create profile page then show form profile

- Expected response code 200
- Expected request handler by create action, profile controller, default module
- Expected response content containts:
    + Hidden field name=id with value blank
    + Text field name=fullname with value blank
    + Text field name=age with value blank
    + Text field name=email with value blank
#### Run Unit-test 

***expected test failed***

### Quick & dirty way to write production code

1. add method createAction to ProfileController
2. create file view/scripts/profile/create.phtml
3. make html form in file view/scripts/profile/create.phtml

#### Run Unit-test again 

***expected test success***

### Refactoring code

#### Run Unit-test again 

***expected test success***
