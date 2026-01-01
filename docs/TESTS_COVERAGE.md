# How to enable code coverage locally

To generate coverage reports locally you need PHP with Xdebug or PCOV available.

Recommended options:

-   Install Xdebug (Debian/Ubuntu):

    -   sudo apt-get install php-dev php-pear
    -   pecl install xdebug
    -   echo "zend_extension=$(find /usr/lib -name xdebug.so | head -n1)" | sudo tee /etc/php/$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')/mods-available/xdebug.ini
    -   sudo phpenmod xdebug
    -   Restart PHP-FPM / PHP CLI session if needed.

-   Or use PCOV (faster for coverage):
    -   pecl install pcov
    -   echo "extension=$(find /usr/lib -name pcov.so | head -n1)" | sudo tee /etc/php/$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')/mods-available/pcov.ini
    -   sudo phpenmod pcov

After enabling a coverage driver, run:

```bash
composer install --no-dev
./vendor/bin/pest --coverage --coverage-text --coverage-clover=coverage/clover.xml
```

If you prefer running coverage in CI, we added a GitHub Actions workflow at `.github/workflows/coverage.yml` that enables Xdebug/PCOV and uploads `coverage/clover.xml` as an artifact.
