# PHP 8.2 – 8.5 workshop

Hands-on exercises for the language features that arrived between PHP 8.2 and
PHP 8.5. Every exercise is a small coding task with PHPUnit tests that turn
green once the task is solved.

## Setup

You need Docker. Everything else (PHP 8.5, Composer, PHPUnit) runs inside the
container.

```bash
git clone <repository-url> php-workshop
cd php-workshop
make install        # builds the image and installs the dependencies
make test           # runs all tests: most of them fail, that is your job
```

| Command                 | What it does                                   |
|-------------------------|------------------------------------------------|
| `make test`             | Run all tests                                  |
| `make test ex=03`       | Run the tests of one exercise                  |
| `make shell`            | Open a shell in the container (`php -v`, ...)  |

### Without make (e.g. on Windows)

```bash
docker compose build
docker compose run --rm php composer install
docker compose run --rm php vendor/bin/phpunit                  # all tests
docker compose run --rm php vendor/bin/phpunit --testsuite ex03 # one exercise
docker compose run --rm php bash                                # shell
```

The container runs as user 1000:1000. If your Linux user has another id, put
`UID=<your uid>` and `GID=<your gid>` into a file named `.env` first.

## How the exercises work

- The code to work on is in `src/ExNN.../`. Each file starts with a comment
  that states the problem, the task, the constraints and some hints.
- Files marked "Given code: do not change" are part of the setting.
- The tests in `tests/ExNN.../` check the behaviour and, where a task says
  "use feature X", also the source code. Do not change the tests.
- Some exercises start with working legacy code and green behaviour tests:
  there the task is a refactoring.
- A syntax error or a compile-time error stops PHPUnit before any test runs.
  Run a single exercise (`make test ex=05`) to keep the output readable.

## Exercises

| #  | Topic                                              | PHP  | Files to work on                                    | Minutes |
|----|----------------------------------------------------|------|-----------------------------------------------------|---------|
| 01 | Property hooks                                     | 8.4  | `User` · `Shape`, `Square`, `Circle`                | 30      |
| 02 | Asymmetric visibility                              | 8.4  | `BankAccount` · `Document`                          | 20      |
| 03 | Pipe operator                                      | 8.5  | `Slugger` · `WordFrequency`                         | 25      |
| 04 | `clone` with property overrides                    | 8.5  | `Money` · `ServerConfig`, `Deployment`              | 20      |
| 05 | Typed class constants                              | 8.3  | `PaymentGateway` and the three gateways             | 10      |
| 06 | `array_find`, `array_find_key`, `array_any`, `array_all` | 8.4 | `Inventory`                                    | 10      |
| 07 | `array_first`, `array_last`                        | 8.5  | `RaceResults`                                       | 10      |
| 08 | Closures and first-class callables in constant expressions | 8.5 | `SignupForm` · `TextFilters`              | 20      |
| 09 | Backtraces for fatal errors                        | 8.5  | bug hunt, start in `run-reports.php`                | 10      |

A "·" separates task 1 from task 2 of an exercise. The minutes are estimates
and add up to 155, which leaves 25 minutes of a three-hour session for the
introduction and a break. If time runs short, the second tasks of exercises
01, 03, 04 and 08 can be skipped or given as homework.

## Solutions

The reference solutions are on the branch `solutions`. After
`git switch solutions`, `make test-solutions` runs the tests against them.
