Here is a comprehensive guide to best practices for setting up PHP testing in a WordPress context using your exact toolset:

---

## 🧱 Recommended Stack Summary

| Tool | Role |
|---|---|
| **Composer** | Dependency management for testing libraries |
| **PHPUnit** | Unit testing (isolated, fast, no WP needed) |
| **Codeception + WP-Browser** | Integration, functional & acceptance testing |
| **Xdebug** | Code coverage reports + step debugging |
| **Local by Flywheel** | Live WordPress environment for integration tests |
| **PhpStorm** | IDE with native PHPUnit + Xdebug integration |

---

## 1. 📁 Recommended Project Structure

Each plugin or theme should be self-contained with its own tests:

```
name=my-custom-plugin/
/wp-content/plugins/my-custom-plugin/
  ├── src/                    # Your custom PHP classes
  ├── tests/
  │   ├── unit/               # Pure PHPUnit unit tests
  │   ├── integration/        # WP-aware tests (Codeception)
  │   ├── acceptance/         # Browser/E2E tests (Codeception)
  │   ├── _support/           # Codeception helpers/factories
  │   ├── _data/              # Fixtures, SQL dumps
  │   └── _output/            # Test results, coverage reports
  ├── bootstrap.php           # PHPUnit bootstrap
  ├── phpunit.xml.dist        # PHPUnit config
  ├── codeception.yml         # Codeception config
  └── composer.json
```

---

## 2. 📦 Composer Setup

```json name=composer.json
{
  "name": "your-org/my-custom-plugin",
  "require": {},
  "require-dev": {
    "phpunit/phpunit": "^10.0",
    "codeception/codeception": "^5.0",
    "lucatume/wp-browser": "^4.3"
  },
  "autoload": {
    "psr-4": {
      "MyPlugin\\": "src/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "MyPlugin\\Tests\\": "tests/"
    }
  },
  "scripts": {
    "test:unit": "./vendor/bin/phpunit",
    "test:integration": "./vendor/bin/codecept run integration",
    "test:acceptance": "./vendor/bin/codecept run acceptance",
    "test:all": "composer test:unit && composer test:integration"
  }
}
```

> ✅ **Best Practice:** Keep `require-dev` separate from `require`. Never ship test tooling to production.

---

## 3. 🧪 PHPUnit — Unit Tests

Unit tests should test **pure PHP logic only** — no database, no WordPress functions. Mock or abstract WP dependencies.

```xml name=phpunit.xml.dist
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="tests/unit/bootstrap.php"
         colors="true"
         verbose="true">
  <testsuites>
    <testsuite name="Unit">
      <directory>./tests/unit</directory>
    </testsuite>
  </testsuites>
  <coverage>
    <include>
      <directory suffix=".php">./src</directory>
    </include>
    <report>
      <html outputDirectory="./tests/_output/coverage-html"/>
      <clover outputFile="./tests/_output/coverage.xml"/>
    </report>
  </coverage>
</phpunit>
```

```php name=tests/unit/bootstrap.php
<?php
// No WordPress needed for unit tests — just Composer autoload
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
```

### Example Unit Test

```php name=tests/unit/MyServiceTest.php
<?php
use PHPUnit\Framework\TestCase;
use MyPlugin\MyService;

class MyServiceTest extends TestCase {
    public function test_it_formats_a_price(): void {
        $service = new MyService();
        $this->assertSame('$10.00', $service->formatPrice(10));
    }
}
```

> ✅ **Best Practice:** If your code calls WordPress functions like `get_option()` or `wp_insert_post()`, either **abstract them behind an interface** you can mock, or move those tests to integration tests.

---

## 4. 🔗 Codeception + WP-Browser — Integration Tests

`lucatume/wp-browser` is the key library here. It gives you WordPress-aware Codeception modules that boot WordPress in the test process.

```bash name=terminal
# From inside your plugin directory:
vendor/bin/codecept bootstrap
vendor/bin/codecept init wpbrowser
```

This wizard will ask about your Local by Flywheel site URL, DB credentials, etc. and generate your suite configs automatically.

**Example Integration Test (WordPress-aware):**

```php name=tests/integration/MyServiceIntegrationTest.php
<?php
class MyServiceIntegrationTest extends \Codeception\TestCase\WPTestCase {
    public function test_it_saves_to_options(): void {
        $service = new \MyPlugin\MyService();
        $service->saveOption('my_key', 'my_value');
        $this->assertSame('my_value', get_option('my_key'));
    }
}
```

> ✅ **Best Practice:** Integration tests run against a **real WordPress install** (your Local site). Use a **separate dedicated test database** — never your dev DB — as WP-Browser can truncate tables.

---

## 5. 🖥️ Local by Flywheel Setup Tips

- **Use the built-in SSH shell:** Local gives you a terminal with the correct PHP binary and environment. Run `composer install` and your test commands from there.
- **Enable Xdebug:** In Local → select your site → **Utilities tab** → toggle Xdebug on.
- **Create a dedicated test site:** Consider a second Local site (or a separate DB on the same site) specifically for running integration/acceptance tests.
- **DB Credentials:** Find them in Local's **Database tab** to configure `wp-browser`.

---

## 6. 🐛 Xdebug + PhpStorm Integration

### Xdebug for Coverage (PHPUnit)
```bash name=terminal
# Set mode before running tests
XDEBUG_MODE=coverage vendor/bin/phpunit
```

### Xdebug for Step Debugging in PhpStorm
1. In PhpStorm: **Preferences → PHP → Debug** — confirm port is `9003`
2. Add a **PHP Remote Debug** server pointing to your Local site path mappings
3. Click the **🐛 Listen for PHP Debug Connections** button
4. Run PHPUnit from Local's terminal and PhpStorm will catch breakpoints

> ✅ **Best Practice:** Use `XDEBUG_MODE=off` during normal test runs for speed — only switch to `coverage` or `debug` when needed.

---

## 7. ⚙️ PhpStorm Configuration

- **PHPUnit integration:** Go to **Preferences → PHP → Test Frameworks** → add PHPUnit via Composer (`vendor/autoload.php` as the autoloader, `phpunit.xml.dist` as the config).
- **Run Configurations:** Create a PHPUnit run configuration pointing to your `tests/unit` directory — gives you the green ▶️ run button per test.
- **Coverage display:** After a coverage run, PhpStorm highlights covered/uncovered lines directly in the gutter.

---

## 8. 🎯 Key Best Practices Summary

| Practice | Why |
|---|---|
| **Unit test pure logic, integration test WP behavior** | Keeps tests fast and focused |
| **Never test against your dev/prod DB** | Tests can truncate data — use a dedicated test DB |
| **Abstract WP function calls** | Makes unit testing without WP possible |
| **Commit `phpunit.xml.dist`, not `phpunit.xml`** | `.dist` is the template; developers create their own local copy |
| **Add `tests/_output` to `.gitignore`** | Don't commit generated reports |
| **Run unit tests frequently, acceptance tests in CI** | Acceptance tests are slow — don't block local dev flow |
| **Use Composer scripts** | `composer test:unit` is easier to remember and documents intent |
| **Document the setup** | Add a `TESTING.md` explaining how to run tests for new developers |

---

## 9. 🚀 Suggested Getting-Started Path

Given you're starting from scratch, here's a pragmatic order:

1. **Start with PHPUnit unit tests only** — no WordPress dependencies needed, fastest feedback loop
2. **Refactor existing code** to be unit-testable (extract logic out of template files into classes)
3. **Add Codeception + WP-Browser** once you want to test WP-specific behavior (hooks, DB, options)
4. **Enable Xdebug coverage** to identify untested areas
5. **Add acceptance tests last** for critical user flows

---

### 📚 Key Resources
- [WP-Browser Documentation](https://wpbrowser.wptestkit.dev/)
- [WordPress Plugin Testing Handbook](https://developer.wordpress.org/plugins/wordpress-unit-tests/)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Codeception Documentation](https://codeception.com/docs)
- [Xdebug Configuration Guide](https://xdebug.org/docs/install)

Would you like me to help scaffold a specific plugin or theme with a working test setup, or dive deeper into any particular area (e.g., mocking WP functions, CI setup with GitHub Actions, etc.)?