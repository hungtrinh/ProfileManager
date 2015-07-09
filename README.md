# Profile manager

Practical TDD - gitflow - markdown

# Pharse 'ListEmptyProfile'

## Customer

1. When visit list profile page then 
- i want to see page title 'list profile'
2. When visit list profile with empty profile list then
- i wan to see web page display "Empty list profile"

## Developer

### Make app sekeleton

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
